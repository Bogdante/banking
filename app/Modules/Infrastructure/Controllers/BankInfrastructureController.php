<?php

namespace App\Modules\Infrastructure\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bank\Bank;
use App\Modules\Bank\BankEntity;
use App\Modules\Bank\Resources\BankResourse;
use App\Modules\Infrastructure\Entities\BankOfficeEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankInfrastructureController extends Controller
{
    public function getOfficesForBank(Request $request, Bank $bank): JsonResponse
    {
        $bankEntity = new BankEntity($bank);
        $offices = BankOfficeEntity::findAllForBank($bankEntity->getId());

        return response()->json(BankResourse::collection($offices)->resolve());
    }

    public function getOfficesCanCreditForBank(Request $request, Bank $bank): JsonResponse
    {
        $bankEntity = new BankEntity($bank);
        $offices = BankOfficeEntity::findAllForBankWhereCanCredit($bankEntity->getId());

        return response()->json(BankResourse::collection($offices)->resolve());
    }
}
