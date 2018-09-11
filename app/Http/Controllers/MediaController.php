<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Factories\Search\SearchFactory;
use App\Profile;
use App\AltName;
use App\Media;
use Faker\Factory;
use Carbon\Carbon;
use Log;
class MediaController extends Controller
{
	private $searchFactory;
	function __construct(SearchFactory $factory){
		$this->searchFactory = $factory;
	}
    public function generate(Request $request){
    	
		$faker = Factory::create();
		$profile = Profile::with('altNames')->inRandomOrder()->first();
		
		$q = $profile->name;
		if($faker->boolean){
			$altname = $profile->altNames->random();
			$q = $altname->name;
		}
		// $q = "arimura kasumi";//for debug
		// $result = $this->searchFactory->do($q,0);
		// return response()->json($result);
		$result = $this->searchFactory->do($q);
		if(!$result){
			return null;
		}
		$media = new Media($result);
		$media->profile_id = $profile->id;
		// $media->filename = Storage::putFile('public/photos',$file);
		// $media->filename = $result->media_url;
		
		
			// $file = $this->fetchFile($video->url);
			// $media->video = Storage::putFile('public/videos',$file);
		
		$media->save();
		return $media;
    }

    private function fetchFile($url){
    	$info = pathinfo($url);
		$contents = file_get_contents($url);
		$file = tempnam(sys_get_temp_dir(), 'agpb_');
		file_put_contents($file, $contents);
		return new UploadedFile($file,$info['basename']);
    }


    public function get(Request $request){
    	if(!isset($request->id)){
    		$media = Media::orderBy('created_at','desc')->paginate(15);
    		return view('gallery',['media'=>$media]);
    	}
    }

}
