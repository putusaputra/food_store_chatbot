<?php

use Illuminate\Database\Seeder;

class ItemHistoriesTableSeeder extends Seeder
{
    /**
     * Run thHistorye database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\ItemHistory', 10)->create();
    }
}
