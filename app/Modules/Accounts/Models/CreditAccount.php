<?php

namespace App\Modules\Accounts\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'bank_name',
        'start_credit',
        'end_credit',
        'month_credit',
        'credit_sum',
        'month_pay',
        'percentage_rate',
        'employee_id',
        'payment_account_id'
    ];
}
