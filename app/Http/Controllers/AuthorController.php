<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authors = Author::query()
            ->with('marks')
            ->when(request('search'), function ($q, $search){
                return $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            })
            ->paginate();

        return $authors;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAuthorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorRequest $request)
    {
        $input = $request->validated();

        Author::create($input);

        return redirect()
            ->route('authors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        $author->load(['books', 'marks']);

        return $author;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAuthorRequest  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $input = $request->validated();

        $author->update($input);

        return redirect()
            ->route('authors.show', $author);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()
            ->route('authors.index');

    }
}
