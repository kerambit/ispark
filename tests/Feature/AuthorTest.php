<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Index method.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get(route('authors.index'))
            ->assertOk()
            ->assertSee('authors');
    }

    /**
     * Store method.
     *
     * @return void
     */
    public function testStore()
    {
        $author = Author::factory()
            ->make();

        $data = $author->only([
            'first_name', 'last_name'
        ]);

        $this->post(route('authors.index'), $data)
            ->assertRedirect(route('authors.index'));

        $this->assertDatabaseHas('authors', $data);
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

        $author = Author::inRandomOrder()->first()->only(['first_name', 'id']);

        $this->get(route('authors.show', $author['id']))
            ->assertOk()
            ->assertJsonFragment($author);
    }

    /**
     * Update method.
     *
     * @return void
     */
    public function testUpdate()
    {
        $createdAuthor = Author::factory()->create();
        $data = Author::factory()->make()->only([
           'first_name', 'last_name'
        ]);

        $url = route('authors.update', $createdAuthor);

        $this->patch($url, $data)
            ->assertRedirect(route('authors.show', $createdAuthor));

        $this->assertDatabaseHas('authors', $data);
    }

    /**
     * Destroy method.
     *
     * @return void
     */
    public function testDestroy()
    {
        $author = Author::factory()
            ->create();

        $this->delete(route('authors.destroy', $author))
            ->assertRedirect(route('authors.index'));

        $this->assertDeleted('authors', ['id' => $author->id]);
    }
}
