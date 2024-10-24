<?php

namespace App\Modules\Users;
use App\Modules\Users\Client;
use App\Modules\Common\Money;

class ClientEntity 
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public static function create(
        string $email,
        string $password,
        
        string $name,
        string $job,
        Money $monthSalary,
        int $creditRate

    ): self {
        $user = UserEntity::create($email, $password);

        return new self(
            Client::create([
                "user_id" => $user->getId(),
                "name" => $name,
                "job" => $job,
                "month_salary" => $monthSalary->toString(),
                "credit_rate" => $creditRate
            ])
        );
    }

    public static function getByName(string $name): self
    {
        return new self(Client::where('name', $name)->first());
    }

    public function getId(): int
    {
        return $this->client->id;
    }
}