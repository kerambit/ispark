<?php

namespace Database\Factories;

use App\Models\Rating;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mark' => $this->faker->randomDigit(1, 5),
            'ratingable_id' => $this->faker->boolean(50) ? function () {
                return Author::inRandomOrder()->first()->id;
            } : function () {
                return Book::inRandomOrder()->first()->id;
            },
            'ratingable_type' => $this->faker->boolean(50) ? function () {
                return get_class(Author::inRandomOrder()->first());
            } : function () {
                return get_class(Book::inRandomOrder()->first());
            },
        ];
    }
}
