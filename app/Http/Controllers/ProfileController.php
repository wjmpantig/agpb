<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\Media;
class ProfileController extends Controller
{
    public function get(Request $request){
    	
    	if(!isset($request->slug)){
    		$profiles = Profile::all();
    		foreach($profiles as $profile){
    			if(is_null($profile->thumbnail)){
    				$media = Media::where('profile_id',$profile->id)->first();
    				if($media){
    					$profile->thumbnail = $media->filename;
    				}
    			}
    		}
    		return view('profiles',['profiles'=>$profiles]);
    	}
    	$profile = Profile::where('slug',$request->slug)->firstOrFail();
    	return view('profile',['profile'=>$profile]);
    }
}
