<?php

namespace App\Modules\Infrastructure\Commands;

use App\Modules\Common\Money;
use App\Modules\Infrastructure\BankAtmEntity;
use App\Modules\Bank\BankEntity;

use Illuminate\Console\Command;

class CreateBankAtmCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inf:create-bank-atm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Название');
        $status =  $this->ask('Статус');
        $address =  $this->ask('Адресс');
        $location =  $this->ask('Расположение');

        $bankName =  $this->ask('Имя банка');
        $canTopUp =  $this->ask('Можно пополнять');
        $canWithDraw =  $this->ask('Можно снимать');

        $amount =  $this->ask('Резерв');
        $serviceCost =  $this->ask('Цена обслуживания');

        $bank = BankEntity::getByName($bankName);

        BankAtmEntity::createForBank(
            $bank,
            $name,
            $address,
            $status,
            $location,
            $canTopUp,
            $canWithDraw,
            Money::createFromString($amount),
            Money::createFromString($serviceCost)
        );

        $this->info('Успешно!');
    }
}
