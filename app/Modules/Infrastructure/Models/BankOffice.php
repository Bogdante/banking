<?php

namespace App\Modules\Infrastructure\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankOffice extends Model
{
    use HasFactory;

    protected $fillable = [
       'name',
        'address',
        'status',
        'can_place_bank_atm',
        'can_top_up',
        'can_withdraw',
        'can_credit',
        'bank_id',
        'amount',
        'rent_cost',
    ];
}
