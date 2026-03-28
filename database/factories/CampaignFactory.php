<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'title' => $this->faker->sentence(3),
            'client_name' => $this->faker->name,
            'location' => $this->faker->city,
            'status' => $this->faker->randomElement(['draft', 'active', 'completed', 'archived']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 year'),
            'created_by' => User::factory(),
        ];
    }
}
