<?php

namespace App\Modules\Infrastructure;
use App\Modules\Infrastructure\Bank;
use App\Modules\Infrastructure\BankEntity;
use App\Modules\Common\Money;

class BankAtmEntity
{
    private BankAtm $bankAtm;

    public function __construct(BankAtm $bankAtm)
    {
        $this->bankAtm = $bankAtm;
    }

    public static function create(
        BankEntity $bank,
        string $name,
        string $address,
        string $status,
        string $location,
        bool $canTopUp,
        bool $canWithdraw,
        Money $amount,
        Money $serviceCost

    ): self {
        return new self(
            Bank::create([
                'name' => $name,
                'address' => $address,
                'status' => $status,
                'bank_id' => $bank->getId(),
                'location' => $location,
                'can_top_up' => $canTopUp,
                'can_withdraw' => $canWithdraw,
                'amount' => $amount->toString(),
                'service_cost' => $serviceCost->toString()
            ])
        );
    }

    public static function createForBank(
        BankEntity $bank,
        string $name,
        string $address,
        string $status,
        string $location,
        bool $canTopUp,
        bool $canWithdraw,
        Money $amount,
        Money $serviceCost

    ): self {
        $bankAtm = self::create(
        $bank,
        $name,
        $address,
        $status,
        $location,
        $canTopUp,
        $canWithdraw,
        $amount,
        $serviceCost
        );

        $bank->addAtmsAmount();

        return $bankAtm;
    }

    public function getRelatedBank(): BankEntity
    {
        return BankEntity::getById($this->getBankId());
    }

    public function getBankId(): int
    {
        return $this->bankAtm->bank_id;
    }
}