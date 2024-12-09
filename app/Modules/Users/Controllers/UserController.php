<?php

namespace App\Modules\Users\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Bank\BankEntity;
use App\Modules\Common\Money;
use App\Modules\Infrastructure\Entities\BankOfficeEntity;
use App\Modules\Users\Entities\ClientEntity;
use App\Modules\Users\Entities\EmployeeEntity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/employees",
     *     summary="Создаёт нового сотрудника",
     *     tags={"Employees"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", description="Employee's email address"),
     *             @OA\Property(property="password", type="string", format="password", example="P@$$wOrd", description="Employee's password"),
     *             @OA\Property(property="name", type="string", example="John Doe", description="Employee's full name"),
     *             @OA\Property(property="birthday", type="string", format="date", example="1990-05-10", description="Employee's birthday"),
     *             @OA\Property(property="bank_id", type="integer", example=1, description="ID of the bank the employee works for"),
     *             @OA\Property(property="is_remote", type="boolean", example=true, description="Whether the employee is a remote worker"),
     *             @OA\Property(property="bank_office_id", type="integer", example=1, description="ID of the bank office the employee works for"),
     *             @OA\Property(property="can_credit", type="boolean", example=false, description="Whether the employee can approve credits"),
     *             @OA\Property(property="monthly_salary", type="number", format="float", example=5000.00, description="Employee's monthly salary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="employee has been created")
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
    public function createEmployee(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'name' => 'required|string',
            'birthday' => 'required|date',
            'bank_id' => 'required|numeric|exists:banks,id',
            'is_remote' => 'required|boolean',
            'bank_office_id' => 'required|numeric|exists:bank_offices,id',
            'can_credit' => 'required|boolean',
            'monthly_salary' => 'required|numeric'
        ]);

        $bank = BankEntity::getById($data['bank_id']);
        $bankOffice = BankOfficeEntity::getById($data['bank_office_id']);

        try {
            EmployeeEntity::createForBank(
                $data['email'],
                $data['password'],
                $data['name'],
                $data['birthday'],
                'employee',
                $bank,
                $data['is_remote'],
                $bankOffice,
                $data['can_credit'],
                Money::createFromString($data['monthly_salary'])
            );
        } catch (\Exception $exception) {
            return  response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'employee has been created'
        ], 201);
    }


    /**
     * @OA\Post(
     *     path="/api/clients",
     *     summary="Создаёт нового клиента банка",
     *     tags={"Clients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", description="Client's email address"),
     *             @OA\Property(property="password", type="string", format="password", example="P@$$wOrd", description="Client's password"),
     *             @OA\Property(property="name", type="string", example="John Doe", description="Clients's full name"),
     *             @OA\Property(property="job", type="string", example="Taxist", description="Client's job"),
     *             @OA\Property(property="month_salary", type="float", example="40.000", description="Client's month salary"),
     *             @OA\Property(property="credit_rate", type="int", example="40", description="Client's credit rate")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Employee created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="employee has been created")
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
    public function createClient(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'name' => 'required|string',
            'job' => 'required|string',
            'month_salary' => 'required|numeric',
            'credit_rate' => 'required|numeric'
        ]);

        $monthSalary = Money::createFromString($data['month_salary']);

        try {
            ClientEntity::create(
                $data['email'],
                $data['password'],
                $data['name'],
                $data['job'],
                $monthSalary,
                $data['credit_rate']
            );

        } catch (\Exception $exception) {
            return  response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'client has been created'
        ], 201);
    }
}
