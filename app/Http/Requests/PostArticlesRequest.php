<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostArticlesRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100'],
            'body' => ['required', 'string', 'max:8000'],
            'thumbnail' => ['required', 'file', 'image', 'mimes:jpeg,png,gif', 'max:4096'],
            'images.*' => 'file|image|mimes:jpeg,png,gif|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルは必須です',
            'title.string' => 'タイトルは文字列で入力してください',
            'title.max' => 'タイトルは100文字以内で入力してください',
            'body.required' => '本文は必須です',
            'body.string' => '本文は文字列で入力してください',
            'body.max' => '本文は8000文字以内で入力してください',
            'thumbnail.required' => 'サムネイルは必須です',
            'thumbnail.file' => 'サムネイルはファイルで入力してください',
            'thumbnail.image' => 'サムネイルは画像で入力してください',
            'thumbnail.mimes' => 'サムネイルはjpeg,png,gif形式で入力してください',
            'thumbnail.max' => 'サムネイルは4MB以内で入力してください',
            'images.*.file' => '画像はファイルで入力してください',
            'images.*.image' => '画像は画像で入力してください',
            'images.*.mimes' => '画像はjpeg,png,gif形式で入力してください',
            'images.*.max' => '画像は4MB以内で入力してください',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'thumbnail_path' => '/storage/' . $this->file('thumbnail')->storePublicly('images/thumbnails', 'public'),
            'image_paths' => collect($this->file('images'))->map(function ($image) {
                return '/storage/' . $image->storePublicly('images/articles', 'public');
            })->toArray(),
        ]);
    }
}
