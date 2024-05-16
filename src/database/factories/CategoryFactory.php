<?php

namespace Database\Factories;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->unique()->word(),
            "slug" => $this->faker->unique()->slug(),
            "description" => $this->faker->text(),
            "titleSEO" => $this->faker->sentence(),
            "descriptionSEO" => $this->faker->sentence(),
            "keywordsSEO" => $this->faker->sentence(),
            "status" => array_column(CategoryStatus::cases(), 'value')[$this->faker->numberBetween(0, 2)],        ];
    }
}
