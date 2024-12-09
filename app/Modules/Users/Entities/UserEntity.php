<?php

namespace App\Modules\Users\Entities;
use Illuminate\Support\Facades\Hash;
use App\Modules\Users\Models\User;

class UserEntity
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public static function create(
        string $email,
        string $password
    ): self {
        return new self(
            User::create([
                "email" => $email,
                "password" => Hash::make($password)
            ])
        );
    }

    public function getId(): int
    {
        return $this->user->id;
    }
}
