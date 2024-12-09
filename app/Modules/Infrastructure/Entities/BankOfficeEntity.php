<?php

namespace App\Modules\Infrastructure\Entities;
use App\Modules\Common\Money;
use App\Modules\Bank\BankEntity;
use App\Modules\Infrastructure\Models\BankOffice;
use Illuminate\Support\Collection;


class BankOfficeEntity
{
    private BankOffice $bankOffice;

    public function __construct(BankOffice $bankOffice)
    {
        $this->bankOffice = $bankOffice;
    }

    private static function create(
        string $name,
        string $address,
        string $status,
        bool $canPlaceBankAtm,
        bool $canTopUp,
        bool $canWithdraw,
        bool $canCredit,
        BankEntity $bank,
        Money $amount,
        Money $rentCost
    ): self {
        return new self(
            BankOffice::create([
                'name' => $name,
                'address' => $address,
                'status' => $status,
                'can_place_bank_atm' => $canPlaceBankAtm,
                'can_top_up' => $canTopUp,
                'can_withdraw' => $canWithdraw,
                'can_credit' => $canCredit,
                'bank_id' => $bank->getId(),
                'amount' => $amount->toString(),
                'rent_cost' => $rentCost->toString(),
            ])
        );
    }

    public static function createForBank(
        string $name,
        string $address,
        string $status,
        bool $canPlaceBankAtm,
        bool $canTopUp,
        bool $canWithdraw,
        bool $canCredit,
        BankEntity $bank,
        Money $amount,
        Money $rentCost
    ): self {

        $bankOffice = self::create(
            $name,
            $address,
            $status,
            $canPlaceBankAtm,
            $canTopUp,
            $canWithdraw,
            $canCredit,
            $bank,
            $amount,
            $rentCost
        );

        $bank->addOfficesAmount();

        return $bankOffice;
    }

    public static function findAllForBank(int $bankId): Collection
    {
        return BankOffice::where('bank_id', $bankId)->get();
    }

    public static function findAllForBankWhereCanCredit(int $bankId): Collection
    {
        return BankOffice::where('bank_id', $bankId)
            ->where('can_credit', true)->get();
    }

    public static function getByName(string $name): self
    {
        return new self(BankOffice::where('name', $name)->first());
    }

    public static function getById(int $id): self
    {
        return new self(BankOffice::where('id', $id)->first());
    }

    public function getRelatedBank(): BankEntity
    {
        return BankEntity::getById($this->getBankId());
    }

    public function getBankId(): int
    {
        return $this->bankOffice->bank_id;
    }

    public function getId(): int
    {
        return $this->bankOffice->id;
    }
}
