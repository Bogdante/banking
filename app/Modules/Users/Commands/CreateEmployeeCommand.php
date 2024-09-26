<?php

namespace App\Modules\Users\Commands;

use App\Modules\Infrastructure\BankOfficeEntity;
use App\Modules\Users\EmployeeEntity;
use App\Modules\Common\Money;
use Illuminate\Console\Command;

class CreateEmployeeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-employee';

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
        $email = $this->ask('Почта');
        $pass = $this->ask('пароль');
        $name = $this->ask('ФИО');
        $birthday = $this->ask('День рождения');
        $role = $this->ask('Роль');
        $isRemoute = $this->ask('Удалённый сотрудник');
        $bankOfficeName = $this->ask('Имя оффиса');
        $canCredit = $this->ask('Может выдавать кредиты');
        $salary = $this->ask('Зарплата');

        $office = BankOfficeEntity::getByName($bankOfficeName);
        $bank = $office->getRelatedBank();

        EmployeeEntity::createForBank(
            $email,
            $pass,
            $name,
            $birthday,
            $role,
            $bank,
            $isRemoute,
            $office,
            $canCredit,
            Money::createFromString($salary)
        );

        $this->info('Успешно!');
    }
}
