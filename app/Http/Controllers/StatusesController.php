<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class StatusesController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'content' => 'required|max:500'
        ]);
        Auth::User()->statuses()->create([
            'content' => $request['content'],

        ]);
        session()->flash('success', '发表成功');
        return back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success', '您已经成功删除');
        return back();
    }
}
