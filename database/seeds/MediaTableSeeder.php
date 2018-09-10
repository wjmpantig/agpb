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
        $profiles = Profile::with('media')->get();
        $max = 10;
        $faker = Factory::create();
        foreach($profiles as $profile){
        	for($i=0;$i<$max;$i++){
        		$name = $profile->name;
        		if($faker->boolean){
        			$altname = $profile->altNames->random();
					$name = $altname->name;
        		}
        		$result = $this->searchFactory->do($name);
				if(!$result){
					continue;
				}
				$media = new Media();
				$media->profile_id = $profile->id;
				$media->type = $result->type;
				$media->description = $result->description;
				
				// $file = $this->fetchFile($resultMedia->media_url);
				// $media->filename = Storage::putFile('public/photos',$file);
				$media->filename = $result->media_url;
				$media->url = $result->url;
				if($media->type=='video'){
					$media->video = $result->video_url;
					// $file = $this->fetchFile($video->url);
					// $media->video = Storage::putFile('public/videos',$file);
				}
				$media->save();

        	}
        }
    }
}
