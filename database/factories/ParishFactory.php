<?php

namespace Pirumart\Uganda\Locale\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pirumart\Uganda\Locale\Models\Parish;

class ParishFactory extends Factory
{
    protected $model = Parish::class;

    public function definition()
    {
        return [
            'district_code' => $this->faker->numerify('D###'),
            'county_code' => $this->faker->numerify('C###'),
            'sub_county_code' => $this->faker->numerify('S###'),
            'parish_code' => $this->faker->unique()->numerify('P####'),
            'parish_name' => $this->faker->unique()->city(),
        ];
    }
}
