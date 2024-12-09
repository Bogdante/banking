<?php

namespace Database\Seeders;

use App\Modules\Bank\BankEntity;
use App\Modules\Common\Money;
use App\Modules\Infrastructure\Entities\BankOfficeEntity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {
            $banks = BankEntity::getAllModels();
        } catch (\Exception $e) {
            $this->command->error("Error fetching banks: {$e->getMessage()}");
            return;
        }


        \DB::transaction(function () use ($banks) {
            foreach ($banks as $bank) {
                $bankEntity = new BankEntity($bank);

                for ($i = 1; $i < rand(2, 5); $i++) {
                    $officeName = "Office {$i} of {$bankEntity->getName()}";
                    $amount = Money::createFromString('100000');
                    $rentCost = Money::createFromString('20000');

                    try{
                        BankOfficeEntity::createForBank(
                            $officeName,
                            "Address for {$officeName}",
                            'opened',
                            true,
                            true,
                            true,
                            (bool)rand(0, 1),
                            $bankEntity,
                            $amount,
                            $rentCost
                        );
                    } catch (\Exception $e){
                        $this->command->error("Error creating BankOffice: {$e->getMessage()}");
                    }
                }
            }
        });
    }
}
