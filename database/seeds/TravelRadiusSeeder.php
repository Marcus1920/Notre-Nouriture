<?php

use Illuminate\Database\Seeder;
use App\UserTravelRadius;

class TravelRadiusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserTravelRadius::create(['id' => '1','kilometres' => '10 km']);
        UserTravelRadius::create(['id' => '2','kilometres' => '20 km']);
        UserTravelRadius::create(['id' => '3','kilometres' => '30 km']);
        UserTravelRadius::create(['id' => '4','kilometres' => '40 km']);
        UserTravelRadius::create(['id' => '5','kilometres' => '50 km']);
        UserTravelRadius::create(['id' => '6','kilometres' => '60 km']);
        UserTravelRadius::create(['id' => '7','kilometres' => '70 km']);
        UserTravelRadius::create(['id' => '8','kilometres' => '80 km']);
        UserTravelRadius::create(['id' => '9','kilometres' => '90 km']);
        UserTravelRadius::create(['id' => '10','kilometres' => '100 km']);
    }
}
