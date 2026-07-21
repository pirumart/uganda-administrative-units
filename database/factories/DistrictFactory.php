<?php

namespace Pirumart\Uganda\Locale\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Pirumart\Uganda\Locale\Models\District;

class DistrictFactory extends Factory
{
    protected $model = District::class;

    public function definition()
    {
        return [
            'region' => $this->faker->city(),
            'sub_region' => $this->faker->city(),
            'district_code' => $this->faker->unique()->numerify('D###'),
            'district_name' => $this->faker->unique()->city(),
        ];
    }
}
