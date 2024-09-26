<?php

namespace App\Modules\Users\Commands;

use App\Modules\Users\ClientEntity;
use App\Modules\Common\Money;
use Illuminate\Console\Command;

class CreateClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-client';

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
        //

        $email = $this->ask('Почта');
        $pass = $this->ask('пароль');
        $name = $this->ask('ФИО');
        $job = $this->ask('Место работы');
        $monthSalary = $this->ask('Зарплата');
        $rating = $this->ask('Кредитный рейтинг');

        ClientEntity::create(
            $email,
            $pass,
            $name,
            $job, 
            Money::createFromString($monthSalary), 
            $rating
        );

        $this->info('Успешно!');
    }
}
