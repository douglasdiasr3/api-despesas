<?php

namespace App\Notifications;

use App\Models\Despesas;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class DespesaCadastrada extends Notification implements ShouldQueue
{
    use Queueable;

    protected $contato;
    protected $despesa;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $usuario, Despesas $despesa)
    {
        $this->contato = $usuario;
        $this->despesa = $despesa;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->greeting('Olá ' . $this->contato->name)
            ->line('Foi cadastrado uma despesa para o seu usuário.')
            ->line('Descrição: '.$this->despesa->descricao)
            ->line('Data: '.$this->despesa->data)
            ->line('Valor: '.$this->despesa->valor);

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
