<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>1,
            'category_id'=>rand(1,5),
            'title_uz'=>fake()->sentence(),
            'title_ru'=>fake()->sentence(),
            'title_en'=>fake()->sentence(),
            'description_uz'=>fake()->sentence(10),
            'description_ru'=>fake()->sentence(10),
            'description_en'=>fake()->sentence(10),
            'content_uz'=>fake()->paragraph(15),
            'content_ru'=>fake()->paragraph(15),
            'content_en'=>fake()->paragraph(15),
            'photo'=>null,
        ];
    }
}
