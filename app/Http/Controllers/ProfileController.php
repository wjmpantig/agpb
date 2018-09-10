<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
class ProfileController extends Controller
{
    public function get(Request $request){
    	
    	if(!isset($request->slug)){
    		$profiles = Profile::all();
    		return view('profiles',['profiles'=>$profiles]);
    	}
    	$profile = Profile::where('slug',$request->slug)->first();
    	return view('profile',$profile);
    }
}
