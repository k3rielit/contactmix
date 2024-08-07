<?php

namespace Database\Factories\Webshop;

use App\Models\Webshop\Shoprenter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Webshop\Shoprenter>
 */
class ShoprenterFactory extends Factory
{
    protected $model = Shoprenter::class;

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
