<?php

namespace App\Modules\Infrastructure\Commands;

use App\Modules\Bank\BankEntity;

use App\Modules\Common\Money;
use App\Modules\Infrastructure\BankOfficeEntity;
use Illuminate\Console\Command;

class CreateBankOfficeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inf:create-bank-office';

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
        $address = $this->ask('Адресс');
        $status = $this->ask('Статус');

        $canPlaceBankAtm = $this->ask('Можно расположить банкомат');
        $canTopUp = $this->ask('Можно пополнить счёт');
        $canWithdraw = $this->ask('Можно снять деньги');
        $canCredit = $this->ask('Можно взять кредит');

        $bankName = $this->ask('Название банка');
        $amount = $this->ask('Резерв');
        $rentCost = $this->ask('Цена аренды');

        $bank = BankEntity::getByName($bankName);

        BankOfficeEntity::createForBank(
            $name,
            $address,
            $status,
            $canPlaceBankAtm,
            $canTopUp,
            $canWithdraw,
            $canCredit,

            $bank,
            Money::createFromString($amount),
            Money::createFromString($rentCost)
            
        );

        $this->info('Успешно!');
    }
}
