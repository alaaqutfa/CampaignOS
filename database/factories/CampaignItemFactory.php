<?php
namespace Database\Factories;

use App\Models\Campaign;
use App\Models\CampaignItem;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignItemFactory extends Factory
{
    protected $model = CampaignItem::class;

    public function definition(): array
    {
        $width  = $this->faker->randomFloat(2, 10, 500);
        $height = $this->faker->randomFloat(2, 10, 500);
        $qty    = $this->faker->numberBetween(1, 10);
        $sqm    = ($width * $height * $qty) / 10000;

        return [
            'campaign_id'           => Campaign::factory(),
            'shop_id'               => Shop::factory(),
            'assigned_measurer_id'  => User::factory(),
            'assigned_installer_id' => User::factory(),
            'material'              => $this->faker->randomElement(['Mesh', 'Sticker', 'Parasol Lightbox', 'Backlit Lightbox', 'Flex Frame', 'Foam Sticker']),
            'quantity'              => $qty,
            'width'                 => $width,
            'height'                => $height,
            'unit'                  => $this->faker->randomElement(['cm', 'inch', 'pixel']),
            'text'                  => $this->faker->optional()->sentence,
            'print_file_name'       => $this->faker->optional()->word . '.pdf',
            'sqm'                   => $sqm,
            'status'                => $this->faker->randomElement(['pending', 'measured', 'designed', 'printed', 'installed', 'rejected']),
            'rejection_reason'      => null,
            'recorded_by'           => User::factory(),
            'installed_by'          => null,
            'installed_at'          => null,
            'notes'                 => $this->faker->optional()->sentence,
        ];
    }
}
