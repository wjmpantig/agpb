<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Profile;
use App\AltName;
use App\Media;

use Log;
class MediaController extends Controller
{

	function __construct(){
		
	}
    


    public function get(Request $request){
    	if(!isset($request->id)){
    		$media = Media::orderBy('created_at','desc')->paginate(15);
    		return view('gallery',['media'=>$media]);
    	}
    	$media = Media::findOrFail($request->id);
    	return view('media',['media'=>$media]);
    }

    public function delete(Request $request){
    	$request->validate([
    		'id'=>'exists:media,id'
    	]);
    }

}
