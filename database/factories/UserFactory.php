<?php

namespace Database\Factories;

use App\Models\User; // Import du modèle User
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Role;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'gender' => $this->faker->randomElement(['male', 'female']), // Ajout du genre avec des valeurs aléatoires 'male' ou 'female'
            'birth_date' => $this->faker->date(), // Ajout de la date de naissance avec une date aléatoire
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(15),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    // MÉTHODE POUR ATTRIBUER DES RÔLES AUX UTILISATEURSS
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Récupérer le rôle par défaut
            $defaultRole = Role::where('name', 'user')->first();

            // Associer le rôle à l'utilisateur via la table de pivot
            if ($defaultRole) {
                $user->roles()->attach($defaultRole);
            }
        });
    }
}

