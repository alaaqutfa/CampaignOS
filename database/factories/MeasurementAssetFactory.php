<?php
namespace Database\Factories;

use App\Models\MeasurementAsset;
use App\Models\CampaignItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeasurementAssetFactory extends Factory
{
    protected $model = MeasurementAsset::class;

    public function definition(): array
    {
        return [
            'campaign_item_id' => CampaignItem::factory(),
            'type'             => $this->faker->randomElement(['before', 'after']),
            'file_path'        => 'uploads/demo/' . $this->faker->filePath(),
            'original_name'    => $this->faker->word . '.jpg',
            'mime_type'        => 'image/jpeg',
            'size'             => $this->faker->numberBetween(10000, 5000000),
            'uploaded_by'      => User::factory(),
            'captured_at'      => $this->faker->optional()->dateTimeThisYear(),
        ];
    }
}
