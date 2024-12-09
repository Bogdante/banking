<?php

namespace App\Modules\Accounts\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Accounts\Entities\CreditAccountEntity;
use App\Modules\Accounts\Entities\PaymentAccountEntity;
use App\Modules\Bank\BankEntity;
use App\Modules\Common\Money;
use App\Modules\Users\Entities\ClientEntity;
use App\Modules\Users\Entities\EmployeeEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/payment-accounts",
     *     summary="Создаёт новый платёжный счёт",
     *     tags={"Accounts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="client_id", type="integer", format="integer", example="1", description="id банка"),
     *             @OA\Property(property="password", type="integer", format="integer", example="1", description="id клиента"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Account created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="account has been created")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Database error: ...")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="object",
     *                 @OA\Property(property="field", type="string", example="email"),
     *                 @OA\Property(property="message", type="string", example="The email has already been taken.")
     *             )
     *         )
     *     )
     * )
     */
    public function createPaymentAccount(Request $request): JsonResponse
    {
        $data = $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'bank_id' => 'required|integer|exists:banks,id',
        ]);

        $client = ClientEntity::getById($data['client_id']);
        $bank = BankEntity::getById($data['bank_id']);

        try {
            PaymentAccountEntity::create(
                $client,
                $bank,
            );

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Payment account has been created'
        ], 201);
    }


    /**
     * @OA\Post(
     *     path="/credit-accounts",
     *     summary="Создание кредитного счёта",
     *     tags={"Accounts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="client_id", type="integer", example=1, description="ID of the client"),
     *             @OA\Property(property="bank_id", type="integer", example=1, description="ID of the bank"),
     *             @OA\Property(property="employee_id", type="integer", example=1, description="ID of the employee who processed the credit"),
     *             @OA\Property(property="payment_account_id", type="integer", example=1, description="ID of the client's payment account"),
     *             @OA\Property(property="start_credit", type="string", format="date", example="2024-03-15", description="Credit start date"),
     *             @OA\Property(property="end_credit", type="string", format="date", example="2025-03-15", description="Credit end date"),
     *             @OA\Property(property="month_credit", type="integer", example=12, description="Credit term in months"),
     *             @OA\Property(property="credit_sum", type="number", format="float", example=10000.00, description="Credit amount"),
     *             @OA\Property(property="month_pay", type="number", format="float", example=1000.00, description="Monthly payment amount"),
     *             @OA\Property(property="percent_credit", type="number", format="float", example=10.00, description="Month rate")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Credit account created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Credit account has been created")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(type="object",
     *                 @OA\Property(property="field", type="string", example="client_id"),
     *                 @OA\Property(property="message", type="string", example="The selected client id is invalid.")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error"),
     *             @OA\Property(property="message", type="string", example="Database error: ...")
     *         )
     *     )
     * )
     */
    public function createCreditAccount(Request $request): JsonResponse
    {
        $data = $request->validate([
            'client_id' => 'required|integer|exists:clients,id',
            'bank_id' => 'required|integer|exists:banks,id',
            'employee_id' => 'required|integer|exists:employees,id',
            'payment_account_id' => 'required|integer|exists:payment_accounts,id',

            'start_credit' => 'required|date',
            'end_credit' => 'required|date',
            'month_credit' => 'required|integer',
            'credit_sum' => 'required|numeric',
            'month_pay' => 'required|numeric',
            'percent_credit' => 'required|numeric',
        ]);

        $client = ClientEntity::getById($data['client_id']);
        $bank = BankEntity::getById($data['bank_id']);
        $employee = EmployeeEntity::getById($data['employee_id']);
        $paymentAccount = PaymentAccountEntity::getById($data['payment_account_id']);

        $creditSum = Money::createFromString($data['credit_sum']);
        $monthPay = Money::createFromString($data['month_pay']);
        $percentCredit = Money::createFromString($data['percent_credit']);

        try {
            CreditAccountEntity::create(
                $client,
                $bank,
                $employee,
                $paymentAccount,
                $data['start_credit'],
                $data['end_credit'],
                $data['month_credit'],
                $creditSum,
                $monthPay,
                $percentCredit
            );

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Credit account has been created'
        ], 201);
    }
}
