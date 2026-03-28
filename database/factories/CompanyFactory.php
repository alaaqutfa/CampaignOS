<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'commercial_name' => $this->faker->companySuffix,
            'logo' => null,
            'contact_info' => [
                'phone' => $this->faker->phoneNumber,
                'email' => $this->faker->companyEmail,
                'address' => $this->faker->address,
            ],
            'status' => true,
        ];
    }
}
