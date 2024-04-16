<?php

declare(strict_types=1);

namespace Application\Http\Request\User;

use Hyperf\Validation\Request\FormRequest;

class UserAuthRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|size:36',
        ];
    }
}
