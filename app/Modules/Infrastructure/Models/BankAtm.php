<?php

namespace App\Modules\Infrastructure\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string amount
 * @property int bank_id
 */

class BankAtm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'status',
        'bank_id',
        'location',
        'can_top_up',
        'can_withdraw',
        'amount',
        'service_cost'
    ];
}
