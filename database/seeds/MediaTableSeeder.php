<?php

use Illuminate\Database\Seeder;
use App\Factories\Search\SearchFactory;
use App\Profile;
use App\Media;
use Faker\Factory;
class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    function __construct(SearchFactory $factory){
    	$this->searchFactory = $factory;
    }
    public function run()
    {
        $profiles = Profile::all();
        $max = 10;
        $faker = Factory::create();
        foreach($profiles as $profile){
        	$out = Artisan::call("media:generate",[
        		"--profile"=>$profile->id,
        		"--count"=>$max
        		]);
        	$this->command->info($out);
        }
    }
}
