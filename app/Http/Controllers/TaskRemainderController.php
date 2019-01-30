<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use App\TaskRemainder;
use Illuminate\Support\Facades\DB;

class TaskRemainderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TaskRemainder::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = new TaskRemainder();
        $task->from_user = $request->input('from_user');
        $task->to_user = $request->input('to_user');
        $task->task_name = $request->input('task_name');
        $task->rem_time = $request->input('rem_time');

        $task->save();

        return new TaskResource($task);

    }

    /**
     * Display the specified resource.
     *
     * @param  @int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $tasks=  DB::collection('task_remainders')->where('_id', $id)->get();

        return response()->json($tasks, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::table('task_remainders')->where('_id',$id)->update(array(
            'from_user'=>$request->from_user,
            'to_user'=>$request->to_user,
            'task_name'=>$request->task_name,
            'rem_time'=>$request->rem_time,
        ));

        $task = DB::collection('task_remainders')->where('_id', $id)->get();

        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::collection('task_remainders')->where('_id', $id)->delete();

        return response()->json(null, 204);

    }
}
