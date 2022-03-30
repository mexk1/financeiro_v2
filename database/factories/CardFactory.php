<?php

namespace Database\Factories;

use App\Models\BankAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card>
 */
class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "bank_account_id" => BankAccount::factory(),
            "last_digits" => ( string ) $this->faker->randomNumber( 4 ),
            "mode" => $this->faker->randomElement( ["both", "credit", "debit" ] ),
            "bill_close_day" => $this->faker->date("d"),
            "limit" => rand( 200, 3000 )
        ];
    }
}
