<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        // Generate a student number: 220 + 7 random digits
        $studentNumber = '220' . str_pad(fake()->unique()->numberBetween(0, 9999999), 7, '0', STR_PAD_LEFT);
        
        return [
            'name' => fake()->name(),
            'email' => $studentNumber . '@student.buksu.edu.ph',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
