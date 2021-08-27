<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despesas extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao','data','valor','user_id'
    ];

    protected $dates = [
        'Data'
    ];

    public $timestamps = true;


    public function setDataAttribute($input)
    {
        $this->attributes['data'] = 
          Carbon::createFromFormat(config('app.date_format'), $input)->format('Y-m-d');
    }


    public function getDataAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)
          ->format(config('app.date_format'));
    }
    

}
