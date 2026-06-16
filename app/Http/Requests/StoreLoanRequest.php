<?php

namespace App\Http\Requests;

use App\Enums\LoanStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create loans') ?? false;
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required', 'exists:members,id'],
            'loan_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:loan_date'],
            'status' => ['required', Rule::enum(LoanStatus::class)],
            'details' => ['required', 'array', 'min:1'],
            'details.*.book_id' => ['required', 'exists:books,id'],
            'details.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
