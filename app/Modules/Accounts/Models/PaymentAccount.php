<?php

namespace App\Modules\Accounts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'bank_name',
        'amount'
    ];
}
