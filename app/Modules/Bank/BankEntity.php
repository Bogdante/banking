<?php

namespace App\Modules\Bank;

use App\Modules\Bank\Bank;
use App\Modules\Common\Money;

class BankEntity {
    private Bank $bank;

    public function __construct(Bank $bank) {
        $this->bank = $bank;
    }

    public static function create(
        string $name,
        Money $amount,
        Money $percentageRate
    ): self {
        return new self(
            Bank::create([
                'name' => $name,
                'num_offices' => 0,
                'num_atms' => 0,
                'num_employees' => 0,
                'num_clients' => 0,
                'rating' => rand(1, 100),
                'amount' => $amount->toString(),
                'percentage_rate' => $percentageRate->toString()
            ])
        );
    }

    public static function getById(int $id): self
    {
        return new self(Bank::find($id));
    }

    public static function getByName(string $name): self
    {
        return new self(Bank::where('name', $name)->first());
    }

    public function getId(): int
    {
        return $this->bank->id;
    }

    public function getName(): string
    {
        return $this->bank->name;
    }

    public function addEmployeeAmount(): void
    {
        $this->bank->num_employees++;
        $this->bank->save();
    }

    public function addClientsAmount(): void
    {
        $this->bank->num_clients++;
        $this->bank->save();
    }

    public function addOfficesAmount(): void
    {
        $this->bank->num_offices++;
        $this->bank->save();
    }

    public function addAtmsAmount(): void
    {
        $this->bank->num_atms++;
        $this->bank->save();
    }
}
