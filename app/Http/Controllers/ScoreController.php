<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Score;

class ScoreController extends Controller
{
    public function index()
    {
    	// $data = DB::table('score')->get();
    	/*$data = Score::where('s_id','01')->get();
    	foreach ($data as $value) {
    		var_dump($value->s_score);
    	}*/

    	//不使用ORM
    	$scores = DB::table('score as a')
    			-> select('a.s_id','b.s_name','c.c_name','a.s_score')
    			-> leftJoin('student AS b','b.s_id','=','a.s_id')
    			-> leftJoin('course AS c','c.c_id','=','a.c_id')
    			-> orderby('a.s_id','asc')
    			-> get();
    	// return view('score.index',['scores'	=>	$score]);
    	return view('score.index', compact('scores'));
    }
}
