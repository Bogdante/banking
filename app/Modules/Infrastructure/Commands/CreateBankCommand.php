<?php

namespace App\Modules\Infrastructure\Commands;

use App\Modules\Common\Money;
use App\Modules\Infrastructure\BankEntity;
use Illuminate\Console\Command;

class CreateBankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inf:create-bank';

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
        $name = $this->ask('Название банка');
        $amount = $this->ask('Резерв банка');
        $rate = $this->ask('Ставка');

        BankEntity::create(
            $name,
            Money::createFromString($amount),
            Money::createFromString($rate)
        );

        $this->info('Успешно!');
    }
}
