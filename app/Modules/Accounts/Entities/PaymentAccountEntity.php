<?php

namespace App\Modules\Accounts\Entities;
use App\Modules\Accounts\Models\PaymentAccount;
use App\Modules\Bank\BankEntity;

use App\Modules\Users\Entities\ClientEntity;
use App\Modules\Common\Money;

class PaymentAccountEntity
{
    private PaymentAccount $paymentAccount;

    public function __construct(PaymentAccount $paymentAccount)
    {
        $this->paymentAccount = $paymentAccount;
    }

    public static function create(
        ClientEntity $client,
        BankEntity $bank
    ): self {
        return new self(
            PaymentAccount::create([
            'customer_id' => $client->getId(),
            'bank_name' => $bank->getName(),
            'amount' => Money::createZero()
            ])
        );
    }

    public function createForBank(
        ClientEntity $client,
        BankEntity $bank
    ): self {
        $paymentAccount = self::create(
            $client,
            $bank
        );

        $bank->addClientsAmount();

        return $paymentAccount;
    }

    public static function getForClientAndBank(
        BankEntity $bank,
        ClientEntity $client
    ): self {
        return new self(PaymentAccount::where('bank_name', $bank->getName())
            ->where('customer_id', $client->getId())->first());
    }

    public function getId(): int
    {
        return $this->paymentAccount->id;
    }
}
