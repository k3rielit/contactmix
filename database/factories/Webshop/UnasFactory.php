<?php

namespace Database\Factories\Webshop;

use App\Models\Webshop\Unas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Webshop\Unas>
 */
class UnasFactory extends Factory
{
    protected $model = Unas::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'checked' => false,
        ];
    }

}
