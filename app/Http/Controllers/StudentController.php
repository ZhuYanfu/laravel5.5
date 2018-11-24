<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = DB::table('student')->where('deleted_at', '=', NULL)->get();
        // var_dump($students);
        return view('student.index',['students'=>$students]);
    }

    public function add()
    {
        return view('student.add');
    }

    public function show($id)
    {
        $data = DB::table('student')->where('s_id','=',$id)->first();
        // var_dump($data);
        return view('student.show',['data' => $data]);
    }

    public function save(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request -> input();
            $username = $input['username'];
            $birthday = $input['birthday'];
            $gender = $input['gender'] == '0' ? '女' : '男';
            // var_dump($gender);
            /*$data = $request->all();
            var_dump($data);*/
            //这里input和all打出来的数据是一模一样的
            if ($input['id']) {
                //修改
                $res = DB::table('student')->where('s_id', '=', $input['id'])->update(['s_name' => $username,'s_birth' => $birthday,'s_sex' => $gender]);
            } else {
                //新增
                $lastId = DB::table('student')->max('s_id');
                $currentId = abs($lastId) + 1;
                if ($currentId < 10) {
                    $currentId = '0'.$currentId;
                }
                var_dump(abs($lastId));
                $res = DB::insert('insert into student(s_id,s_name,s_birth,s_sex) values (?,?,?,?)',[$currentId,$username,$birthday,$gender]);
            }

            if ($res) {
                return redirect()->route('student.index');
            } else {
                return '';
            }
    }
    }

    public function delete($id)
    {
        //假删除，实际上就是update指定的字段
        $res = DB::table('student')->where('s_id', '=', $id)->update(['deleted_at' => time()]);
        if ($res) {
            $code = 200;
            $msg = 'successfully';
        } else {
            $code = 100;
            $msg = 'failed';
        }

        $data = [
            'code'  =>  $code,
            'msg'   =>  $msg
        ];
        
        return $data;
    }
}
