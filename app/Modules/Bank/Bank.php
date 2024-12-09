<?php

namespace App\Modules\Bank;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'num_offices',
        'num_atms',
        'num_employees',
        'num_clients',
        'rating',
        'amount',
        'percentage_rate'
    ];
}
