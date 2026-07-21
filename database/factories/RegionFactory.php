<?php

namespace Pirumart\Uganda\Locale\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pirumart\Uganda\Locale\Models\Region;

class RegionFactory extends Factory
{
    protected $model = Region::class;

    public function definition()
    {
        return [
            'region' => $this->faker->city(),
            'sub_region' => $this->faker->unique()->city(),
        ];
    }
}
