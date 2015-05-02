<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class JunkSeeder extends Seeder {

    public static $category = array(
        "Wet Suits",
        "Dry Suits",
        "Regulators",
        "Buoyancy Compensators",
        "Tanks",
        "Lights",
        "Cameras"
    );

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();
    }

}
