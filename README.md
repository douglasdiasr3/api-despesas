## Instruções

Passar pela header Accept:application/json em todas requisições.

Utilizar as rotas POST register campos necessários(name,email,password,password_confirmation)  / login(email,password) para cadastro ou login na api. Com isso será gerado o token, ele será necessário para passar via Auth/Bearer nas demais rotas do crud que estão protegidas.

O campo user_id a ser inserido na despesa é mesmo id do usuário cadastrado na rota register, assim como o e-mail a ser enviado.

Para envio do e-mail é nessário setar no arquivo .env : QUEUE_CONNECTION=database e executar o comando php artisan queue:work .