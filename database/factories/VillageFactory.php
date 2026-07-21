<?php

namespace Pirumart\Uganda\Locale\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pirumart\Uganda\Locale\Models\Village;

class VillageFactory extends Factory
{
    protected $model = Village::class;

    public function definition()
    {
        return [
            'district_code' => $this->faker->numerify('D###'),
            'county_code' => $this->faker->numerify('C###'),
            'sub_county_code' => $this->faker->numerify('S###'),
            'parish_code' => $this->faker->numerify('P####'),
            'village_code' => $this->faker->unique()->numerify('V#####'),
            'village_name' => $this->faker->unique()->city(),
        ];
    }
}
