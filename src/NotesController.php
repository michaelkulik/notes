<?php

namespace Pinerp\Notes;

use Illuminate\Http\Request;
use Pinerp\Http\Requests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Validator;

class NotesController extends BaseController
{
    /**
     * Display a list of the notes
     * @return Response
     */
    public function index()
    {
        $data = [
            'notes' => Note::orderBy('created_at')
                            ->where('user_id', Auth::user()->id)
                            ->paginate(8)
        ];

        event('erp.view_list', ['notes::log.note.list']);
        return view('notes::index', $data);
    }

    /**
     * Create a new note.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create()
    {
        event('erp.view_one', ['notes::log.note.create']);
        return view('notes::create');
    }

    // Store data into database
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->action('\Pinerp\Notes\NotesController@create')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Alternative variant
//        $inputs = $request->all();
//        $note = Note::create($inputs);

        $note = new Note;
        $note->title = $request->title;
        $note->content = $request->content;
        if (can('notes.note.create_notify')) {
            $note->notify_datetime = $request->notify_datetime;
        } else {
            $note->notify_datetime = null;
        }
        $note->user_id = Auth::user()->id;

        if ($note->save()) {
            event('erp.action', ['notes::log.note.store', $note]);
            return redirect()->action('\Pinerp\Notes\NotesController@index')->withMsg('layout::common.msg.create');
        }

//        return redirect()->route('erp.notes.index');
    }

    // Display details of the note
    public function show($id)
    {
        $note = Note::find($id);
        $user = Auth::user($note->user_id);

        event('erp.view_one', ['notes::log.note.one', $note]);

        return view('notes::show', compact('note', 'user'));
    }


    public function edit($id)
    {
        $note = Note::find($id);

        event('erp.view_one', ['notes::log.note.edit', $note]);

//        return view('notes::edit')->with('note', $note);
        return view('notes::edit', compact('note', $note));
    }

    // Update the note
    public function update(Request $request, $id)
    {
        $note = Note::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->action('\Pinerp\Notes\NotesController@edit', ['id' => $note->id])
                             ->withErrors($validator)
                             ->withInput();
        }

        $note->title = $request->title;
        $note->content = $request->content;
        if (can('notes.note.create_notify')) {
            $note->notify_datetime = $request->notify_datetime;
        } else {
            $note->notify_datetime = null;
        }

        if ($note->save()) {
            event('erp.action', ['notes::log.note.update', $note]);
            return redirect()->action('\Pinerp\Notes\NotesController@index')->withMsg('layout::common.msg.edit');
        }
    }

    public function destroy($id)
    {
        $note = Note::find($id);
        event('erp.action', ['notes::log.note.delete', $note]);
        $note->delete();

        return redirect()->action('\Pinerp\Notes\NotesController@index')->withMsg('layout::common.msg.delete');
    }
}