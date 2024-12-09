<?php

namespace Database\Seeders;

use App\Modules\Bank\BankEntity;
use App\Modules\Common\Money;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BankEntity::create(
            'VTB',
            Money::createFromString('150000.00'),
            Money::createFromString('3.00'),
        );
        BankEntity::create(
            'Sberbank',
            Money::createFromString('150000.00'),
            Money::createFromString('7.00'),
        );
        BankEntity::create(
            'Tinkoff',
            Money::createFromString('150000.00'),
            Money::createFromString('8.00'),
        );
    }
}
