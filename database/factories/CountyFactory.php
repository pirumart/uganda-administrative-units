<?php

namespace Pirumart\Uganda\Locale\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pirumart\Uganda\Locale\Models\County;

class CountyFactory extends Factory
{
    protected $model = County::class;

    public function definition()
    {
        return [
            'district_code' => $this->faker->numerify('D###'),
            'county_code' => $this->faker->unique()->numerify('C###'),
            'county_name' => $this->faker->unique()->city().' COUNTY',
        ];
    }
}
