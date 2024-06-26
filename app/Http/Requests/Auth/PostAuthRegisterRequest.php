<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * @property-read string $display_name
 * @property-read string $password
 * @property-read string $icon_path
 */
class PostAuthRegisterRequest extends FormRequest
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
            'display_name' => ['required', 'string', 'max:100', 'regex:/\A[a-zA-Z0-9_-]+\z/u', 'unique:user_details,display_name'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->max(30)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'user_icon' => ['required', 'file', 'image', 'mimes:jpeg,png,gif', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'display_name.required' => '表示名は必須です',
            'display_name.string' => '表示名は文字列で入力してください',
            'display_name.max' => '表示名は100文字以内で入力してください',
            'password.required' => 'パスワードは必須です',
            'password.string' => 'パスワードは文字列で入力してください',
            'password.confirmed' => 'パスワードが一致しません',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは30文字以内で入力してください',
            'password.letters' => 'パスワードは英字を含めてください',
            'password.mixed' => 'パスワードは大文字と小文字を含めてください',
            'password.numbers' => 'パスワードは数字を含めてください',
            'password.symbols' => 'パスワードは記号を含めてください',
            'password.uncompromised' => 'パスワードが簡単すぎます',
            'user_icon.required' => 'アイコンは必須です',
            'user_icon.file' => 'アイコンはファイルで入力してください',
            'user_icon.image' => 'アイコンは画像で入力してください',
            'user_icon.mimes' => 'アイコンはjpeg,png,gif形式で入力してください',
            'user_icon.max' => 'アイコンは4MB以内で入力してください',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'icon_path' => '/storage/' . $this->file('user_icon')->storePublicly('images/icons', 'public'),
        ]);
    }
}
