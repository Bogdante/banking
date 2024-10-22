<?php

namespace App\Modules\Accounts\Commands;

use App\Modules\Accounts\PaymentAccountEntity;
use App\Modules\Bank\BankEntity;

use App\Modules\Users\ClientEntity;
use Illuminate\Console\Command;

class CreatePaymentAccountCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acc:create-payment-account';

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

        $client = ClientEntity::getByName($clientName);
        $bank = BankEntity::getByName($bankName);


        PaymentAccountEntity::create(
            $client,
            $bank
        );
        
        $this->info('Успешно');
    }
}
