<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carne extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor_total',
        'qtd_parcelas',
        'data_primeiro_vencimento',
        'periodicidade',
        'valor_entrada'
    ];
}
