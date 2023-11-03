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
        $topics = Topic::all();

        foreach ($topics as $topic){
            $notes = Note::where('topic_id', $topic->id)->get();
            $topic->notes = $notes;
        }

        return response()->json($topics); // Return all topics
    }


    // Store a new note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $topic = Topic::firstOrCreate(['name' => $request->title]);

        $note = new Note();
        //$note->title = $request->title;
        $note->topic_id = $topic->id;
        $note->content = $request->content;
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

    public function addNote(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'content' => 'required|string',
            'topic_id' => 'required|exists:topics,id' // Ensure the topic exists
        ]);

        // Create a new note
        $note = new Note();

        $note->content = $validatedData['content'];
        $note->topic_id = $validatedData['topic_id'];
        $note->save();

        // Optionally, you can load the topic relationship to return with the note
        $note->load('topic');

        return response()->json($note, 201); // 201 status code for resource creation
    }

    public function storeTopic(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Validation rules
        ]);

        $topic = new Topic();
        $topic->name = $request->name;
        $topic->save();

        return response()->json($topic, 201); // Return the created topic with HTTP status 201 (Created)
    }

    public function destroyTopic(Topic $topic)
    {
        $topic->delete();
        return response()->json(null, 204); // No content response
    }
}
