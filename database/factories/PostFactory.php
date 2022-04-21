<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * the name of the factory's corresponding model
     *    @var string 
     */

    protected $model = \App\Models\Post::class;

    /**
     * Define the model's default state.
     *  * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'slug' => Str::of('{$this->faker->title()}')->slug(('-')),
            'description' => $this->faker->paragraph(),
            'created_at' => now(),
            'user_id' => $this->faker->numberBetween(1, 100),

        ];
    }
}
