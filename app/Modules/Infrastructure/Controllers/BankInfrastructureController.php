<?php

namespace App\Modules\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bank\Bank;
use App\Modules\Bank\BankEntity;
use App\Modules\Bank\Resources\BankResourse;
use App\Modules\Infrastructure\Entities\BankOfficeEntity;
use App\Modules\OpenApi\OpenApiDefaults;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankInfrastructureController extends Controller
{
    use OpenApiDefaults;

    /**
     * @OA\Get(
     *     path="/api/bank/{bank}/offices",
     *     operationId="getAllBankOffices",
     *     tags={"Bank Infrastructure"},
     *     summary="Получить список всех офисов банка",
     *     description="Возвращает список всех офисов банка",
     *     @OA\Parameter(
     *          name="bank",
     *          in="path",
     *          required=true,
     *          description="id банка",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Не найден банк"
     *      )
     * )
     */
    public function getOfficesForBank(Request $request, Bank $bank): JsonResponse
    {
        $bankEntity = new BankEntity($bank);
        $offices = BankOfficeEntity::findAllForBank($bankEntity->getId());

        return response()->json(BankResourse::collection($offices)->resolve());
    }

    /**
     * @OA\Get(
     *     path="/api/bank/{bank}/can-credit/offices",
     *     operationId="getAllBankCreditOffices",
     *     tags={"Bank Infrastructure"},
     *     summary="Получить список всех офисов банка ( в которых можно взять кредит )",
     *     description="Возвращает список всех офисов банка в которых можно взять кредит",
     *     @OA\Parameter(
     *          name="bank",
     *          in="path",
     *          required=true,
     *          description="id банка",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Не найден банк"
     *      )
     * )
     */
    public function getOfficesCanCreditForBank(Request $request, Bank $bank): JsonResponse
    {
        $bankEntity = new BankEntity($bank);
        $offices = BankOfficeEntity::findAllForBankWhereCanCredit($bankEntity->getId());

        return response()->json(BankResourse::collection($offices)->resolve());
    }
}
