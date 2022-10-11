<?php

namespace App\Http\Controllers\Routine;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;

class RoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getSubject(Request $request)
    {
        $array = [];
        $batchs = Batch::whereIn('id', $request->batchId)->select('subject_id')->get();
        foreach($batchs as $batch) {
            $array[] = json_decode($batch->subject_id);
        }
        $batchIds = array_unique(call_user_func_array('array_merge', $array));

        $subjects = Subject::whereIn('id', $batchIds)->get();
        return $subjects;
    }

    public function create()
    {
        $batches = Batch::all();
        return view('dashboard.routine.create',compact('batches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
