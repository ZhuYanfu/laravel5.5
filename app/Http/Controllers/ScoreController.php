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
    			-> select('a.s_id as id','e.s_name as name',DB::Raw('IFNULL(b.s_score,0) as Chinese'),DB::Raw('IFNULL(c.s_score,0) as Math'),DB::Raw('IFNULL(d.s_score,0) as English'),DB::Raw('(IFNULL(b.s_score,0)+IFNULL(c.s_score,0)+IFNULL(d.s_score,0)) as total'))
    			-> leftJoin('student AS e','e.s_id','=','a.s_id')
                -> leftJoin('score as b', function ($join) {
                    $join->on('b.s_id', '=', 'a.s_id')
                         ->where('b.c_id', '=', '01');
                   })
                -> leftJoin('score as c', function ($join) {
                    $join->on('c.s_id', '=', 'a.s_id')
                         ->where('c.c_id', '=', '02');
                    })
                -> leftJoin('score as d', function ($join) {
                    $join->on('d.s_id', '=', 'a.s_id')
                         ->where('d.c_id', '=', '03');
                    })
                -> groupby('id')
                -> orderby('Math','desc')
                -> get();
                // -> tosql();
        // dd($scores);
    			// -> orderby('a.s_id','asc')
                // -> orderby('总分')
        // var_dump($scores);
        // ,'IFNULL(c.s_score,0) Math','IFNULL(d.s_score,0) English')
        //, '(IFNULL(b.s_score,0)+IFNULL(c.s_score,0)+IFNULL(d.s_score,0)) as 总分'
    	// return view('score.index',['scores'	=>	$score]);
    	return view('score.index', compact('scores'));
    }
}
