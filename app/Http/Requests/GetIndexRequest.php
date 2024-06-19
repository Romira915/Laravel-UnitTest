<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\DTO\CurrentUserDTO;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $limit
 * @property-read string current_user_id
 * @property-read string current_user_display_name
 * @property-read string current_user_icon_path
 */
class GetIndexRequest extends FormRequest
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
            'limit' => ['integer', 'between:1, 100']
        ];
    }

    public function passedValidation()
    {
        if (isset($this->limit)) {
            $this->merge([
                'limit' => (int)$this->limit,
            ]);
        }
    }
}
