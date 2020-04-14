<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Validator;
use Illuminate\Support\Facades\DB;


class HelloController extends Controller
{
    public function index(Request $request)
    {
        $items = DB::table('people')
            ->orderBy('age', 'asc')
            ->get();
        return view('hello.index', ['items' => $items]);
    }

    public function post(Request $request)
    {
        $validate_rule = [
            'msg' => 'required',
        ];
        $this->validate($request, $validate_rule);
        $msg = $request->msg;
        $response = response()->view('hello.index', ['msg'=>'「'. $msg . '」クッキーを保存しました。']);
        $response->cookie('msg', $msg, 100);
        return $response;
    }

    public function add(Request $request)
    {
        return view('hello.add');
    }

    public function create(Request $request)
    {
        $param = [
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        DB::table('people')->insert($param);
        return redirect('/hello');
    }

    public function edit(Request $request)
    {
        $param = ['id' => $request->id];
        $item = DB::table('people')
            ->where('id', $param)
            ->first();
        return view('hello.edit', ['form' => $item]);

    }

    public function update(Request $request)
    {
        $param = [
            'id' => $request->id,
            'name' => $request->name,
            'mail' => $request->mail,
            'age' => $request->age,
        ];
        DB::table('people')
            ->where('id', $request->id)
            ->update($param);
        return redirect('/hello');
    }

    public function del(Request $request)
    {
        $item =DB::table('people')
            ->where('id', $request->id)
            ->first();
        return view('hello.del', ['form' => $item]);
    }

    public function remove(Request $request)
    {
        DB::table('people')
            ->where('id', $request->id)
            ->delete();
        return redirect('/hello');

    }

    public function show(Request $request)
    {
        $page = $request->page;
        $items = DB::table('people')
            ->offset($page * 3)
            ->limit(3)
            ->get();
        return view('hello.show', ['items' => $items]);
    }

    public function rest(Request $request)
    {
        return view('hello.rest');
    }

    public function ses_get(Request $request)
    {
        $ses_data = $request->session()->get('msg');
        return view('hello.session', ['session_data' => $ses_data]);
    }

    public function ses_put(Request $request)
    {
        $request->session()->put('msg', $request->input);
        return redirect ('hello/session');
    }
}
