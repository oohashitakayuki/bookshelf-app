<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $book = $this->route('book');

        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|digits:13|unique:books,isbn',
            'published_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:255',
            'genres' => 'required|array|min:1',
            'genres.*' => 'required|integer|exists:genres,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'author.required' => '著者名を入力してください。',
            'author.max' => '著者名は255文字以内で入力してください。',
            'isbn.required' => 'ISBNを入力してください。',
            'isbn.digits' => 'ISBNは13桁の数字で入力してください。',
            'isbn.unique' => 'このISBNは既に登録されています。',
            'published_date.required' => '出版日を入力してください。',
            'published_date.date' => '有効な出版日を入力してください。',
            'description.max' => '説明は255文字以内で入力してください。',
            'image_url.url' => '画像URLは正しいURL形式で入力してください。',
            'image_url.max' => '画像URLは255文字以内で入力してください。',
            'genres.required' => 'ジャンルを1つ以上選択してください。',
            'genres.array' => 'ジャンルは配列形式で指定してください。',
            'genres.min' => 'ジャンルを1つ以上選択してください。',
            'genres.*.required' => 'ジャンルを選択してください。',
            'genres.*.integer' => 'ジャンルの指定が正しくありません。',
            'genres.*.exists' => '選択されたジャンルが存在しません。',
        ];
    }
}
