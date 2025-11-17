<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'dni' => fake()->unique()->numerify('########'),   // DNI único
            'name' => fake()->firstName(),                     // nombre
            'apellido' => fake()->lastName(),                  // apellido
            'telefono' => fake()->phoneNumber(),               // opcional
            'rol' => 'odontologa',                             // por defecto
            'email' => fake()->unique()->safeEmail(),          // 
            'email_verified_at' => now(),
            'password' => bcrypt('password'),                  // o Hash::make
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
