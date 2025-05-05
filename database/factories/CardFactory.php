<?php

namespace Database\Factories;

use App\Enums\CardStatusEnum;
use App\Enums\WorkStatusEnum;
use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Card> */
class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'national_id' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'card_number' => $this->faker->word(),
            'pin' => $this->faker->word(),
            'status' => $this->faker->randomElement(
                WorkStatusEnum::values()
            ),
            'matching_state' => $this->faker->randomElement(
                CardStatusEnum::values()
            ),
            'notes' => $this->faker->word(),
            'purchase_price' => $this->faker->randomFloat(2, 10, 100),
            'account_number' => $this->faker->word(),
            'contact_phone' => $this->faker->phoneNumber
        ];
    }
}
