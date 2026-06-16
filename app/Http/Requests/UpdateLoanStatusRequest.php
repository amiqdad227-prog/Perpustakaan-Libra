<?php

namespace App\Http\Requests;

use App\Enums\LoanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLoanStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update loans') ?? false;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::enum(LoanStatus::class)],
        ];
    }
}
