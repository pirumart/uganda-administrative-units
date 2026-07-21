<?php

namespace Pirumart\Uganda\Locale\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pirumart\Uganda\Locale\Models\SubCounty;

class SubCountyFactory extends Factory
{
    protected $model = SubCounty::class;

    public function definition()
    {
        return [
            'district_code' => $this->faker->numerify('D###'),
            'county_code' => $this->faker->numerify('C###'),
            'sub_county_code' => $this->faker->unique()->numerify('S###'),
            'sub_county_name' => $this->faker->unique()->city(),
        ];
    }
}
