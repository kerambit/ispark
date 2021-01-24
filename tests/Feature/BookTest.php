<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index method.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('books');
    }

    /**
     * Store method.
     *
     * @return void
     */
    public function testStore()
    {
        Author::factory(5)
            ->create();

        $book = Book::factory()
            ->make();

        $data = $book->only([
           'title', 'annotation', 'author_id'
        ]);

        $this->post(route('books.store'), $data)
            ->assertRedirect(route('books.index'));

        $this->assertDatabaseHas('books', $data);
    }

    /**
     * Show method.
     *
     * @return void
     */
    public function testShow()
    {
        Author::factory(5)
            ->create();

        Book::factory(5)
            ->create();

        $book = Book::inRandomOrder()->first()->only(['title', 'id']);

        $this->get(route('books.show', $book['id']))
            ->assertOk()
            ->assertJsonFragment($book);
    }

    /**
     * Update method.
     *
     * @return void
     */
    public function testUpdate()
    {
        Author::factory(5)
            ->create();

        $createdBook = Book::factory()
            ->create();

        $data = Book::factory()
            ->make()
            ->toArray();

        $url = route('books.update', $createdBook);

        $this->patch($url, $data)
            ->assertRedirect(route('books.show', $createdBook));

        $this->assertDatabaseHas('books', $data);
    }

    /**
     * Destroy method.
     *
     * @return void
     */
    public function testDestroy()
    {
        Author::factory(5)
            ->create();

        $book = Book::factory()
            ->create();

        $resp = $this->delete(route('books.destroy', $book))
            ->assertRedirect(route('books.index'));

        $this->assertDeleted('books', ['id' => $book->id]);
    }
}
