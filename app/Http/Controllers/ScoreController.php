<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use App\Score;

class ScoreController extends Controller
{
    public function index()
    {
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
                -> orderby('total','desc')
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

    public function showGraph()
    {
        return view('score.graph');
    }

    public function getDataOfGraph()
    {
        //前端需要的数据格式：data[[name],[score]]
        $nameResultSet = DB::table('score as a')
                -> select('a.s_id as id','e.s_name as name',DB::Raw('(IFNULL(b.s_score,0)+IFNULL(c.s_score,0)+IFNULL(d.s_score,0)) as total'))
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
                -> orderby('id','asc')
                -> get();
        $names = [];
        $score = [];
        foreach ($nameResultSet as $value) {
            $names[] = $value->name;
            $score[] = $value->total;
        }
        $data = [
            'name'  =>  $names,
            'score' =>  $score
        ];

        return response()->json($data);
    }
}
