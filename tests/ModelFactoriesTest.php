<?php

use Pirumart\Uganda\Locale\Models\County;
use Pirumart\Uganda\Locale\Models\District;
use Pirumart\Uganda\Locale\Models\Parish;
use Pirumart\Uganda\Locale\Models\Region;
use Pirumart\Uganda\Locale\Models\SubCounty;
use Pirumart\Uganda\Locale\Models\Village;

it('creates a region via its factory', function () {
    $region = Region::factory()->create();

    expect($region)->toBeInstanceOf(Region::class)
        ->and($region->exists)->toBeTrue()
        ->and($region->region)->not->toBeEmpty()
        ->and($region->sub_region)->not->toBeEmpty();
});

it('creates a district via its factory', function () {
    $district = District::factory()->create();

    expect($district)->toBeInstanceOf(District::class)
        ->and($district->exists)->toBeTrue()
        ->and($district->district_code)->not->toBeEmpty()
        ->and($district->district_name)->not->toBeEmpty();
});

it('creates a county via its factory', function () {
    $county = County::factory()->create();

    expect($county)->toBeInstanceOf(County::class)
        ->and($county->exists)->toBeTrue()
        ->and($county->county_code)->not->toBeEmpty()
        ->and($county->county_name)->not->toBeEmpty();
});

it('creates a sub county via its factory', function () {
    $subCounty = SubCounty::factory()->create();

    expect($subCounty)->toBeInstanceOf(SubCounty::class)
        ->and($subCounty->exists)->toBeTrue()
        ->and($subCounty->sub_county_code)->not->toBeEmpty()
        ->and($subCounty->sub_county_name)->not->toBeEmpty();
});

it('creates a parish via its factory', function () {
    $parish = Parish::factory()->create();

    expect($parish)->toBeInstanceOf(Parish::class)
        ->and($parish->exists)->toBeTrue()
        ->and($parish->parish_code)->not->toBeEmpty()
        ->and($parish->parish_name)->not->toBeEmpty();
});

it('creates a village via its factory', function () {
    $village = Village::factory()->create();

    expect($village)->toBeInstanceOf(Village::class)
        ->and($village->exists)->toBeTrue()
        ->and($village->village_code)->not->toBeEmpty()
        ->and($village->village_name)->not->toBeEmpty();
});
