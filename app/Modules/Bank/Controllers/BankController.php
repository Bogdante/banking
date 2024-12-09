<?php

namespace App\Modules\Bank\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bank\BankEntity;
use App\Modules\Bank\Resources\BankResourse;
use App\Modules\OpenApi\OpenApiDefaults;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankController extends Controller
{
    use OpenApiDefaults;

    /**
     * @OA\Get(
     *      path="/api/banks",
     *      operationId="getBanksList",
     *      tags={"Bank"},
     *      summary="Получаем список всех банков",
     *      description="Возвращает список всех банков",
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function getBanks(Request $request): JsonResponse
    {
        $banks = BankEntity::getAllModels();
        return response()->json(BankResourse::collection($banks)->resolve());
    }
}
