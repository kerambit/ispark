<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Author;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RatingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Store method.
     *
     * @return void
     */
    public function testStore()
    {
        Author::factory(5)
            ->create();

        Book::factory(5)
            ->create();

        $data = Rating::factory()
            ->make()
            ->toArray();

        $this->post(route('ratings.store'), $data)
            ->assertCreated();

        $this->assertDatabaseHas('ratings', $data);
    }
}
