<?php

namespace Database\Factories;

use App\Enums\LoanStatus;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    public function definition(): array
    {
        $loanDate = fake()->dateTimeBetween('-14 days', 'now');

        return [
            'member_id' => Member::factory(),
            'loan_date' => $loanDate,
            'due_date' => fake()->dateTimeBetween($loanDate, '+14 days'),
            'status' => LoanStatus::Borrowed,
            'returned_at' => null,
        ];
    }
}
