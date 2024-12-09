<?php

namespace App\Modules\Accounts\Entities;
use App\Modules\Accounts\Models\CreditAccount;
use App\Modules\Bank\BankEntity;
use App\Modules\Users\Entities\ClientEntity;
use App\Modules\Users\Entities\EmployeeEntity;
use App\Modules\Common\Money;

class CreditAccountEntity
{
    private CreditAccount $crediAccount;

    public function __construct(CreditAccount $creditAccount)
    {
        $this->crediAccount = $creditAccount;
    }

    public static function create(
        ClientEntity $client,
        BankEntity $bank,
        EmployeeEntity $employee,
        PaymentAccountEntity $paymentAccount,

        string $startCredit,
        string $endCredit,
        int $monthCredit,
        Money $creditSum,
        Money $monthPay,
        Money $percantageRate
    ): self {

        return new self(
            CreditAccount::create([
                'client_id' => $client->getId(),
                'bank_name' => $bank->getName(),
                'start_credit' => $startCredit,
                'end_credit' => $endCredit,
                'month_credit' => $monthCredit,
                'credit_sum' => $creditSum->toString(),
                'month_pay' => $monthPay->toString(),
                'percentage_rate' => $percantageRate->toString(),
                'employee_id' => $employee->getId(),
                'payment_account_id' => $paymentAccount->getId()
            ])
        );
    }



    public function getRelatedBank(): BankEntity
    {
        return BankEntity::getByName($this->getBankName());
    }

    public function getBankName(): string
    {
        return $this->crediAccount->bank_name;
    }
}
