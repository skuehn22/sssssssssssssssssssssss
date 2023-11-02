<?php

namespace App\Http\Controllers;
use App\Models\Note;
use App\Models\Topic;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    // Retrieve all notes
    public function index()
    {
        // Eager load the 'topic' relationship
        $notes = Note::with('topic')->get();
        return response()->json($notes);
    }


    // Store a new note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic_id' => 'nullable|exists:topics,id'
        ]);

        if ($request->has('topic_id')) {
            // If topic_id is provided, use the existing topic
            $topic = Topic::findOrFail($request->topic_id);
        } else {
            // If topic_id is not provided, create a new topic
            $topic = Topic::firstOrCreate(['name' => $request->title]);
        }

        $note = new Note();
        $note->content = $request->content;
        $note->topic_id = $topic->id;
        $note->save();

        return response()->json($note, 201);
    }



    // Update an existing note
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->title = $request->title;
        $note->content = $request->content;
        $note->save();

        return response()->json($note);
    }

    // Delete a note
    public function destroy(Note $note)
    {
        $note->delete();
        return response()->json(null, 204);
    }
}
