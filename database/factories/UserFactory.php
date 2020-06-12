<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\CustomerCategory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'person_name'=>$faker->name,
        'mobile1'=>$faker->randomNumber($nbDigits = 5, $strict = true).$faker->randomNumber($nbDigits = 5, $strict = true),
        'mobile2'=>$faker->randomNumber($nbDigits = 5, $strict = true).$faker->randomNumber($nbDigits = 5, $strict = true),
        'email'=>$faker->email,
        'password'=> '81dc9bdb52d04dc20036dbd8313ed055',
        'person_type_id'=>10,

        'address1'=>$faker->address,
        'address2'=>$faker->secondaryAddress,
        'state'=>'West Bengal',
        'po'=>$faker->streetName,
        'area'=>$faker->cityPrefix,
        'city'=>$faker->city,
        'pin'=>$faker->postcode,


        'customer_category_id'=>function(){
            return CustomerCategory::all()->where('id','>',1)->random();
        },
    ];
});
