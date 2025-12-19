<?php

namespace TomatoPHP\FilamentInvoices\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TomatoPHP\FilamentInvoices\Models\Invoice;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'uuid' => 'INV-' . $this->faker->unique()->randomNumber(6),
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'type' => 'push',
            'status' => $this->faker->randomElement(['draft', 'pending', 'paid', 'overdue']),
            'total' => $this->faker->randomFloat(2, 100, 10000),
            'discount' => 0,
            'vat' => 0,
            'paid' => 0,
            'shipping' => 0,
            'date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'due_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'is_activated' => true,
            'is_offer' => false,
            'send_email' => false,
            'notes' => $this->faker->optional()->sentence(),
            'for_type' => 'App\\Models\\User',
            'for_id' => 1,
            'from_type' => 'App\\Models\\User',
            'from_id' => 1,
            'currency_id' => null,
            'user_id' => 1,
        ];
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'paid',
            'paid' => $attributes['total'],
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'paid' => 0,
        ]);
    }

    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'overdue',
            'due_date' => $this->faker->dateTimeBetween('-30 days', '-1 day'),
            'paid' => 0,
        ]);
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'paid' => 0,
        ]);
    }
}
