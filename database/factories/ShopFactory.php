<?php
namespace Database\Factories;

use App\Models\Shop;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShopFactory extends Factory
{
    protected $model = Shop::class;

    public function definition(): array
    {
        return [
            'company_id' => City::factory()->create()->company_id, // لتجنب إنشاء شركة جديدة لكل محل، يمكن استخدام شركة المدينة
            'city_id'    => City::factory(),
            'name'       => $this->faker->company,
            'address'    => $this->faker->streetAddress,
        ];
    }
}
