<?php

namespace App\Modules\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'birthday',
        'role',
        'bank_id',
        'is_remote_worker',
        'bank_office_id',
        'can_credit',
        'month_salary',
    ];

}
