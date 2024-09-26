<?php

namespace App\Modules\Accounts\Commands;

use App\Modules\Accounts\CreditAccountEntity;
use App\Modules\Accounts\PaymentAccountEntity;
use App\Modules\Common\Money;
use App\Modules\Infrastructure\BankEntity;
use App\Modules\Users\ClientEntity;
use App\Modules\Users\EmployeeEntity;
use Illuminate\Console\Command;

class CreateCreditAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acc:create-credit-account';

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
        $clientName = $this->ask('ФИО клиента');
        $bankName = $this->ask('Название банка');
        $employeeName = $this->ask('ФИО сотрудника');
        $startCredit = $this->ask('Дата начала кредита');
        $endCredit = $this->ask('Дата конца кредита');
        $monthCredit = $this->ask('Число месяцев кредита');
        $creditSum = $this->ask('Сумма кредита');
        $monthPay = $this->ask('Плата за месяц');
        $percRate = $this->ask('Проц. ставка');

        $client = ClientEntity::getByName($clientName);
        $bank = BankEntity::getByName($bankName);
        $employee = EmployeeEntity::getByName($employeeName);
        $paymentAccount = PaymentAccountEntity::getForClientAndBank($bank, $client);

        CreditAccountEntity::create(
            $client,
            $bank,
            $employee,
            $paymentAccount,
            $startCredit,
            $endCredit,
            $monthCredit,
            Money::createFromString($creditSum),
            Money::createFromString($monthPay),
            Money::createFromString($percRate)
        );
        
        $this->info('Успешно');
    }
}
