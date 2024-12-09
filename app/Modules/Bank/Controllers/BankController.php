<?php

namespace App\Modules\Bank\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bank\BankEntity;
use App\Modules\Bank\Resources\BankResourse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function getBanks(Request $request): JsonResponse
    {
        $banks = BankEntity::getAllModels();
        return response()->json(BankResourse::collection($banks)->resolve());
    }
}
