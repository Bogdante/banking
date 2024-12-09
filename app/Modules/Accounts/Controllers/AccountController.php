<?php

namespace App\Modules\Accounts\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Accounts\Entities\PaymentAccountEntity;
use App\Modules\Bank\BankEntity;
use App\Modules\Users\Entities\ClientEntity;
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
}
