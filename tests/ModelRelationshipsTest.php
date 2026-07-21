<?php

namespace Pirumart\Uganda\Locale\Tests;

use Pirumart\Uganda\Locale\Models\County;
use Pirumart\Uganda\Locale\Models\District;
use Pirumart\Uganda\Locale\Models\Parish;
use Pirumart\Uganda\Locale\Models\Region;
use Pirumart\Uganda\Locale\Models\SubCounty;
use Pirumart\Uganda\Locale\Models\Village;

class ModelRelationshipsTest extends TestCase
{
    protected function seedFullHierarchy(): array
    {
        $region = Region::create([
            'region' => 'Northern',
            'sub_region' => 'Acholi',
        ]);

        $district = District::create([
            'region' => 'Northern',
            'sub_region' => 'Acholi',
            'district_code' => 'D01',
            'district_name' => 'Gulu',
        ]);

        $county = County::create([
            'district_code' => 'D01',
            'county_code' => 'C01',
            'county_name' => 'Aswa',
        ]);

        $subCounty = SubCounty::create([
            'district_code' => 'D01',
            'county_code' => 'C01',
            'sub_county_code' => 'S01',
            'sub_county_name' => 'Bungatira',
        ]);

        $parish = Parish::create([
            'district_code' => 'D01',
            'county_code' => 'C01',
            'sub_county_code' => 'S01',
            'parish_code' => 'P01',
            'parish_name' => 'Paminyai',
        ]);

        $village = Village::create([
            'district_code' => 'D01',
            'county_code' => 'C01',
            'sub_county_code' => 'S01',
            'parish_code' => 'P01',
            'village_code' => 'V01',
            'village_name' => 'Pageya',
        ]);

        return compact('region', 'district', 'county', 'subCounty', 'parish', 'village');
    }

    /** @test */
    public function district_belongs_to_its_region()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['region']->is($data['district']->region));
    }

    /** @test */
    public function region_has_many_districts()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['region']->districts->contains($data['district']));
    }

    /** @test */
    public function county_belongs_to_its_district()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->is($data['county']->district));
    }

    /** @test */
    public function district_has_many_counties()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->counties->contains($data['county']));
    }

    /** @test */
    public function sub_county_belongs_to_its_district_and_county()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->is($data['subCounty']->district));
        $this->assertTrue($data['county']->is($data['subCounty']->county));
    }

    /** @test */
    public function district_and_county_have_many_sub_counties()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->sub_counties->contains($data['subCounty']));
        $this->assertTrue($data['county']->sub_counties->contains($data['subCounty']));
    }

    /** @test */
    public function parish_belongs_to_its_district_county_and_sub_county()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->is($data['parish']->district));
        $this->assertTrue($data['county']->is($data['parish']->county));
        $this->assertTrue($data['subCounty']->is($data['parish']->sub_county));
    }

    /** @test */
    public function district_county_and_sub_county_have_many_parishes()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->parishes->contains($data['parish']));
        $this->assertTrue($data['county']->parishes->contains($data['parish']));
        $this->assertTrue($data['subCounty']->parishes->contains($data['parish']));
    }

    /** @test */
    public function village_belongs_to_its_district_county_sub_county_and_parish()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->is($data['village']->district));
        $this->assertTrue($data['county']->is($data['village']->county));
        $this->assertTrue($data['subCounty']->is($data['village']->sub_county));
        $this->assertTrue($data['parish']->is($data['village']->parish));
    }

    /** @test */
    public function district_county_sub_county_and_parish_have_many_villages()
    {
        $data = $this->seedFullHierarchy();

        $this->assertTrue($data['district']->villages->contains($data['village']));
        $this->assertTrue($data['county']->villages->contains($data['village']));
        $this->assertTrue($data['subCounty']->villages->contains($data['village']));
        $this->assertTrue($data['parish']->villages->contains($data['village']));
    }
}
