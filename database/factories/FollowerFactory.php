<?php
use Faker\Generator as Faker;
//$factory->define(Model::class, function (Faker $faker) {
$factory->define(App\Follower::class, function (Faker $faker) {
    return [
        //
        'follower_id'=> $faker->numberBetween($min=1,$max=1000),
    ];
});