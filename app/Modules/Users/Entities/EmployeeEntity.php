<?php

namespace App\Modules\Users\Entities;
use App\Modules\Common\Money;
use App\Modules\Bank\BankEntity;

use App\Modules\Infrastructure\Entities\BankOfficeEntity;
use App\Modules\Users\Models\Employee;
use App\Modules\Users\Entities\UserEntity;

class EmployeeEntity
{
    private Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    private static function create(
        string $email,
        string $password,

        string $name,
        string $birthday,
        string $role,
        BankEntity $bank,
        bool $isRemoteWorker,
        BankOfficeEntity $bankOffice,
        bool $canCredit,
        Money $monthSalary
    ): self {

        $user = UserEntity::create($email, $password);

        return new self(
            Employee::create([
                'user_id' => $user->getId(),
                'name' => $name,
                'birthday' => $birthday,
                'role' => $role,
                'bank_id' => $bank->getId(),
                'is_remote_worker' => $isRemoteWorker,
                'bank_office_id' => $bankOffice->getId(),
                'can_credit' => $canCredit,
                'month_salary' => $monthSalary->toString(),
            ])
        );
    }

    public static function createForBank(
        string $email,
        string $password,

        string $name,
        string $birthday,
        string $role,
        BankEntity $bank,
        bool $isRemoteWorker,
        BankOfficeEntity $bankOffice,
        bool $canCredit,
        Money $monthSalary
    ): self {
        $employee = self::create(
            $email,
            $password,
            $name,
            $birthday,
            $role,
            $bank,
            $isRemoteWorker,
            $bankOffice,
            $canCredit,
            $monthSalary
        );

        $bank->addEmployeeAmount();

        return $employee;
    }

    public static function getByName(string $name): self
    {
        return new self(Employee::where('name', $name)->first());
    }

    public static function getById(int $id): self
    {
        return new self(Employee::where('id', $id)->first());
    }

    public function getId(): int
    {
        return $this->employee->id;
    }
}
