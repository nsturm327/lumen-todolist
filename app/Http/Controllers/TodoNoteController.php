<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TodoNote;
use Auth;

class TodoNoteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the todoNote authored by logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $todoNotes = Auth::user()->todoNotes()->get();
        return response()->json(['status' => 'success','todoNotes' => $todoNotes]);
    }
    /**
     * Display a listing of the todoNote authored by arbitrary user.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $todoNotes = TodoNote::where('user_id', $request->input('user_id'))->get();
        return response()->json(['status' => 'success','todoNotes' => $todoNotes]);
    }
    /**
     * Store a newly created todoNote in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);

        if($todoNote = Auth::user()->todoNotes()->create($request->all())) {
            return response()->json(['status' => 'success', 'todoNote' => $todoNote]);
        } else {
            return response()->json(['status' => 'fail']);
        }
    }
    /**
     * Remove the specified todoNote from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(TodoNote::destroy($id)){
             return response()->json(['status' => 'success']);
        }
    }
    /**
     * Mark the specified todoNote as complete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markComplete($id)
    {
        if($todoNote = Auth::user()->todoNotes()->find($id)) {
            $todoNote->completed_at = date("Y-m-d H:i:s");
            $todoNote->save();

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'fail']);
        }
    }
    /**
     * Mark the specified todoNote as incomplete.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function markIncomplete($id)
    {
        if($todoNote = Auth::user()->todoNotes()->find($id)) {
            $todoNote->completed_at = NULL;
            $todoNote->save();

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'fail']);
        }
    }
}