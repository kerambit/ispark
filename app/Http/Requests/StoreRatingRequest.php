<?php

namespace App\Http\Requests;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRatingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mark' => ['required', 'integer', 'min:1', 'max:5'],
            'ratingable_type' => ['required', Rule::in([Author::class, Book::class])],
            'ratingable_id' => ['required', 'integer']
        ];
    }
}
