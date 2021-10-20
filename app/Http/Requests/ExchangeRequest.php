<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'book_id'       => 'required|integer|exists:books,id',
            'book_print'    => 'required|in:original,nilkhet,news',
            'book_age'      => 'required|integer|between:1,100',
            'book_edition'  => 'nullable|integer|min:1|max:20',
            'markings_percentage'   => 'required|integer|between:0,100',
            'markings_density'      => 'required|integer|between:0,100',
            'missing_pages'         => 'nullable|integer|min:0',
            'expected_book_id'      => 'nullable|integer',
            'description'   => 'nullable',
            'previews'      => 'required|exclude',
            'previews.*'    => 'required|image',
        ];
    }
}
