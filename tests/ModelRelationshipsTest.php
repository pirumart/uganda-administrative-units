<?php

use Pirumart\Uganda\Locale\Models\County;
use Pirumart\Uganda\Locale\Models\District;
use Pirumart\Uganda\Locale\Models\Parish;
use Pirumart\Uganda\Locale\Models\Region;
use Pirumart\Uganda\Locale\Models\SubCounty;
use Pirumart\Uganda\Locale\Models\Village;

function seedFullHierarchy(): array
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

/**
 * District has both a `region` column (the region name string) and a
 * `region()` relation. Eloquent's attribute accessor always wins over
 * the relation for magic property access, so `$district->region` is
 * the string column, never the related model - the relation must be
 * called explicitly.
 */
it('district belongs to its region', function () {
    $data = seedFullHierarchy();

    expect($data['region']->is($data['district']->region()->first()))->toBeTrue();
});

it('region has many districts', function () {
    $data = seedFullHierarchy();

    expect($data['region']->districts->contains($data['district']))->toBeTrue();
});

it('county belongs to its district', function () {
    $data = seedFullHierarchy();

    expect($data['district']->is($data['county']->district))->toBeTrue();
});

it('district has many counties', function () {
    $data = seedFullHierarchy();

    expect($data['district']->counties->contains($data['county']))->toBeTrue();
});

it('sub county belongs to its district and county', function () {
    $data = seedFullHierarchy();

    expect($data['district']->is($data['subCounty']->district))->toBeTrue();
    expect($data['county']->is($data['subCounty']->county))->toBeTrue();
});

it('district and county have many sub counties', function () {
    $data = seedFullHierarchy();

    expect($data['district']->sub_counties->contains($data['subCounty']))->toBeTrue();
    expect($data['county']->sub_counties->contains($data['subCounty']))->toBeTrue();
});

it('parish belongs to its district county and sub county', function () {
    $data = seedFullHierarchy();

    expect($data['district']->is($data['parish']->district))->toBeTrue();
    expect($data['county']->is($data['parish']->county))->toBeTrue();
    expect($data['subCounty']->is($data['parish']->sub_county))->toBeTrue();
});

it('district county and sub county have many parishes', function () {
    $data = seedFullHierarchy();

    expect($data['district']->parishes->contains($data['parish']))->toBeTrue();
    expect($data['county']->parishes->contains($data['parish']))->toBeTrue();
    expect($data['subCounty']->parishes->contains($data['parish']))->toBeTrue();
});

it('village belongs to its district county sub county and parish', function () {
    $data = seedFullHierarchy();

    expect($data['district']->is($data['village']->district))->toBeTrue();
    expect($data['county']->is($data['village']->county))->toBeTrue();
    expect($data['subCounty']->is($data['village']->sub_county))->toBeTrue();
    expect($data['parish']->is($data['village']->parish))->toBeTrue();
});

it('district county sub county and parish have many villages', function () {
    $data = seedFullHierarchy();

    expect($data['district']->villages->contains($data['village']))->toBeTrue();
    expect($data['county']->villages->contains($data['village']))->toBeTrue();
    expect($data['subCounty']->villages->contains($data['village']))->toBeTrue();
    expect($data['parish']->villages->contains($data['village']))->toBeTrue();
});
