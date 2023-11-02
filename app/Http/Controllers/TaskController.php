<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Auswertung;
use App\Models\AuswertungFeedback;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
class TaskController extends Controller

{

    public function teamsMsg($data, $task){

        $user = Auth::user();

        $client = new Client();

        $response = $client->post('https://ontourmedia.webhook.office.com/webhookb2/198a1ab4-67a6-4c32-b403-b7c42322e805@ec6de3af-6f83-40e0-a7fd-91412aeaa222/IncomingWebhook/b6a65debfb0343e0bef82983ffaa25b3/6501bdec-e4ad-403b-b9ef-407caed792b1', [
            'json' => [
                'text' => "Neuer Upload: ".$task."  \n \n" . $user->name . ': ' . $data

            ]
        ]);
    }

    public function teamsError($error){

        $user = Auth::user();

        $client = new Client();

        $response = $client->post('https://ontourmedia.webhook.office.com/webhookb2/198a1ab4-67a6-4c32-b403-b7c42322e805@ec6de3af-6f83-40e0-a7fd-91412aeaa222/IncomingWebhook/9ab5bf1e63ce4b90b2886c15def3f66e/6501bdec-e4ad-403b-b9ef-407caed792b1', [
            'json' => [
                'text' => "Neuer Fehler: ".$error."  \n \n" . $user->name

            ]
        ]);
    }

    public function save(Request $request)
    {
        try {
            $user_uid = Auth::id();
            $value = $request->input('teamname');
            $task_number = $request->input('value');

            $task = Task::updateOrCreate(
                ['user_uid' => $user_uid, 'task' => $task_number],
                ['value' => $value]
            );

            switch ($task_number) {
                case 1:
                    $taskName = "Teamname";
                    break;
                case 10:
                    $taskName = "Lehrer Teamname";
                    break;
                default:
                    $taskName =  "Unbekannt";
            }

            $this->teamsMsg($value, $taskName);

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getOneTask(Request $request)
    {
        try {
            $user_uid = Auth::id();
            $task_number = $request->input('task');
            $trigger = $request->input('trigger');

            // Find the task associated with the current user and task number
            $task = Task::where('user_uid', $user_uid)
                ->where('task', $task_number)
                ->first();

            // Handle cases for task_number 2 which don't depend on task existence
            if ($task_number == 2) {
                if (!$task && ($trigger != "overview" || !$trigger)) {
                    return response()->json(['teamname' => '']);
                }
            }

            // If there is no task, return default responses
            if (!$task) {
                if ($trigger != "task1" && $trigger != "overview") {
                    return response()->json(['teamname' => Auth::user()->group_name]);
                }
                return response()->json(['teamname' => '']);
            }

            // Handle responses for specific task_numbers with a task
            $responses = [
                30 => ['teamname' => '/uploads/' . $task->value, 'id' => $task->id],
                4 => ['teamname' => '' . $task->value, 'id' => $task->id],
                2 => ['teamname' => '/uploads/' . $task->value],
                20 => ['teamname' => '/uploads/' . $task->value]
            ];

            if (array_key_exists($task_number, $responses)) {
                return response()->json($responses[$task_number]);
            }

            if ($task->value) {
                return response()->json(['teamname' => $task->value]);
            }

            // Fallback to default responses if no conditions match
            if ($trigger != "task1" && $trigger != "overview") {
                return response()->json(['teamname' => Auth::user()->group_name]);
            }

            return response()->json(['teamname' => '']);
        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function getAllTask(Request $request)
    {
        try {
            $user_uid = Auth::id();
            $task_number = $request->input('task');

            // Find the task associated with the current user and task number
            $tasks = Task::where('user_uid', $user_uid)
                ->where('task', $task_number)
                ->get();

            // Return tasks and their count
            $count = $tasks->count();
            return response()->json(['tasks' => $tasks, 'count' => $count]);

        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /*
    public function getTask8(Request $request)
    {
        try {
            $user_uid = Auth::id();
            $task_number = 8;

            // Find the task associated with the current user and task number
            $tasks = Task::where('user_uid', $user_uid)
                ->where('task', $task_number)
                ->get();

            // Return tasks and their count
            $count = $tasks->count();
            return response()->json(['tasks' => $tasks, 'count' => $count]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    */


    public function saveTask8(Request $request)
    {
        try {
            // Get the user's ID
            $user_uid = Auth::id();

            // If kiez entry exists for the user, update it. Otherwise, create it.
            Auswertung::updateOrCreate(
                ['user_uid' => $user_uid, 'question' => 'kiez'],
                ['option' => $request->input('kiez')]
            );

            // If feedback entry exists for the user, update it. Otherwise, create it.
            Auswertung::updateOrCreate(
                ['user_uid' => $user_uid, 'question' => 'feedback'],
                ['option' => $request->input('feedback')]
            );

            // If feedbackText entry exists for the user in AuswertungFeedback table, update it. Otherwise, create it.
            AuswertungFeedback::updateOrCreate(
                ['user_uid' => $user_uid],
                ['text' => $request->input('feedbackText')]
            );


            $this->teamsMsg('Neue Bewertung', "Auswertung");


            return response()->json(['status' => 'success', 'message' => 'Data saved successfully.']);

        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    //FEEDBACKTASK
    public function getUserData(Request $request) {
        try {
            $user_uid = Auth::id();

            $auswertungKiez = Auswertung::where('user_uid', $user_uid)->where('question', 'kiez')->first();
            $auswertungFeed = Auswertung::where('user_uid', $user_uid)->where('question', 'feedback')->first();
            $auswertungFeedback = AuswertungFeedback::where('user_uid', $user_uid)->first();

            $response_data['status'] = 'nofill';

            if ($auswertungKiez && $auswertungKiez->option != '') {
                $response_data['kiez'] = $auswertungKiez->option;
                $response_data['status'] = 'success';
            }

            if ($auswertungFeed && $auswertungFeed->option != '') {
                $response_data['feedback'] = $auswertungFeed->option;
                $response_data['status'] = 'success';
            }

            if ($auswertungFeedback && $auswertungFeedback->text != '') {
                $response_data['feedbackText'] = $auswertungFeedback->text;
                $response_data['status'] = 'success';
            }

            // Check if any data was added to the response
            if (isset($response_data['kiez']) || isset($response_data['feedback']) || isset($response_data['feedbackText'])) {
                return response()->json($response_data);
            }

            return response()->json($response_data);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }



    public function saveTask8Feed(Request $request)
    {
        try {


        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function saveVideo(Request $request)
    {
        try {
            if($request->hasFile('video')) {

                $mimeType = $request->file('video')->getMimeType();

                // If the MIME type indicates it's an image, delegate to the saveImage function
                if (strpos($mimeType, 'image/') === 0) {
                    return $this->saveFile($request);
                }

                $user_uid = Auth::id();
                $task_number = $request->input('task_number');
                $type = $request->input('type'); // fetch type from the request

                // Get the count of existing tasks
                $taskCount = Task::where('user_uid', $user_uid)->where('task', $task_number)->count();

                if($taskCount < 5) {
                    // If there are less than 3 tasks, create a new one
                    $task = new Task;
                    $task->user_uid = $user_uid;
                    $task->task = $task_number;

                    if($type == 'video-uploaded') {
                        // Get original file extension
                        $extension = $request->file('video')->getClientOriginalExtension();

                        // Save the video file to the 'videos' directory in the public disk with the original extension
                        $path = $request->file('video')->storeAs('stadtteil', time().".".$extension, 'uploads');
                        $task->type = 'video-uploaded';
                    } else {
                        // Save the video file to the 'videos' directory in the public disk

                        $path = $request->file('video')->store('stadtteil', 'uploads');
                        $task->type = 'video-recorded';
                    }

                    $task->value = str_replace("videos/", "", $path);;
                    $task->save();

                    switch ($task_number) {
                        case 3:
                            $taskName = "Erinnerungsvideo";
                            break;
                        case 30:
                            $taskName = "Lehrer Videobotschaft";
                            break;
                        case 5:
                            $taskName =  "Stadtteilvideos";
                            break;
                        case 50:
                            $taskName =  "Lehrer Erinnerungsvideo";
                            break;
                        case 6:
                            $taskName = "Outtakes";
                            break;
                        default:
                            $taskName =  "Unbekannt";
                    }


                    $this->teamsMsg(env('APP_URL') . "//uploads/" . $task->value, $taskName);


                    // Return the path of the video file
                    return response()->json(['status' => 'success', 'path' => $path]);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Cannot create more than 3 tasks for the given user and task number.'], 400);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'Kein Videoformat'], 400);
            }
        } catch (\Exception $e) {

            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function saveImage(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $user_uid = Auth::id();
                $task_number = $request->input('task_number');

                $task = new Task;
                $task->user_uid = $user_uid;
                $task->task = $task_number;
                $task->type = 'image-uploaded';
                $extension = $request->file('image')->getClientOriginalExtension();

                //40 = Klassenfoto
                if($task_number == 40){
                    $path = $request->file('image')->storeAs('klassenfotos', time().".".$extension, 'uploads');
                    $task->value = str_replace("public/klassenfotos", "", $path);
                }else{
                    $path = $request->file('image')->storeAs('teamfotos', time().".".$extension, 'uploads');
                    $task->value = str_replace("public/teamfotos", "", $path);
                }

                $task->save();

                switch ($task_number) {
                    case 2:
                        $taskName = "Teamfoto";
                        break;
                    case 6:
                        $taskName =  "Outtakes";
                        break;
                    case 20:
                        $taskName = "Lehrer Teamfoto";
                        break;
                    case 40:
                        $taskName = "Klassenfoto";
                        break;
                    default:
                        $taskName =  "Unbekannt";
                }


                $this->teamsMsg(env('APP_URL') . "/uploads/" . $task->value, $taskName);


                return response()->json(['status' => 'success', 'path' => $path]);

            } else {
                return response()->json(['status' => 'error', 'message' => 'Keine Bilddatei'], 400);
            }
        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function saveFile(Request $request)
    {
        try {
            $user_uid = Auth::id();
            $task_number = $request->input('task_number');

            $file = $request->file('file'); // Try to fetch a file with the name 'file'

            if (!$file) {
                $file = $request->file('video'); // If that fails, try to fetch a file with the name 'video'
            }




            if (!$file instanceof \Illuminate\Http\UploadedFile) {
                return response()->json(['status' => 'error', 'message' => 'Die Datei ist ungültig.'], 400);
            }

            $extension = $file->getClientOriginalExtension();
            $fileType = $file->getMimeType();

            $task = new Task;
            $task->user_uid = $user_uid;
            $task->task = $task_number;

            if (strpos($fileType, 'image/') === 0) {
                $path = $file->storeAs('outtakes', time().".".$extension, 'uploads');
                $task->type = 'image-uploaded';
                $task->value = str_replace("public/images/outtakes", "", $path);
            } elseif (strpos($fileType, 'video/') === 0 && $task_number != "4") {
                if ($request->input('type') == 'video-uploaded') {

                    $path = $file->storeAs('outtakes', time().".".$extension, 'uploads');
                    $task->type = 'video-uploaded';
                    $task->value = str_replace("public/images/outtakes/", "", $path);
                } else {

                    $path = $file->store('outtakes', 'uploads');
                    $task->type = 'video-recorded';
                    $task->value = str_replace("public/images/outtakes/", "", $path);
                }
            } elseif (strpos($fileType, 'audio/') === 0 || $task_number == "4" || $fileType === 'video/mp4') {

                if ($fileType === 'audio/wav') {
                    $extension = "wav";
                } else if ($fileType === 'audio/mp3') {
                    $extension = "mp3";
                } else if ($fileType === 'video/mp4') {
                    $extension = "mp4";
                } else {
                    if ($fileType === 'video/webm') {
                        $extension = "webm";
                    } else {
                        $extension = $file->getClientOriginalExtension();
                    }
                }
                //$path = $file->storeAs('videos', time().".".$extension, 'public');
                $path = $file->storeAs('audios', time().".".$extension, 'uploads');


                $task->type = 'audio-recorded';
                $task->value = str_replace("public/videos/", "", $path);
            }
            else {
                return response()->json(['status' => 'error', 'message' => 'Das ist kein Video oder Bild.'], 400);
            }

            $task->save();

            switch ($task_number) {
                case 4:
                    $taskName = "Sprachnotiz";
                    break;
                case 6:
                    $taskName =  "Outtakes";
                    break;
                default:
                    $taskName =  "Unbekannt";

            }


            $this->teamsMsg(env('APP_URL') . "/uploads/" . $task->value, $taskName);

            return response()->json(['status' => 'success', 'path' => $path]);
        } catch (\Exception $e) {
            $error = $e->getMessage();
            $err = "Es ist ein Fehler aufgetreten";
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $err], 500);
        }
    }


    public function deleteVideo($id)
    {
        try {
            // Find the task by its id
            $task = Task::find($id);

            // If a task was found, delete the video file and then delete the task
            if ($task) {
                // Delete the video file from the 'videos' directory in the public disk
                Storage::disk('public')->delete($task->value);

                // Delete the task
                $task->delete();

                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'No task found for the provided ID.'], 404);
            }
        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function deleteImage(Request $request, $fileName)
    {
        try {

            $taskNumber = $request->input('task');

            if ($taskNumber == 40) {
                $path = 'klassenfotos/' . $fileName;
            } else {
                $path = 'teamfotos/' . $fileName;
            }

            // Delete the image from the storage
            Storage::disk('uploads')->delete($path);

            // Delete the task from the database
            $user_uid = Auth::id();
            $task = Task::where('user_uid', $user_uid)
                ->where('value', $path)
                ->first();

            if ($task) {
                $task->delete();
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteAudio($fileName)
    {
        try {
            $path = 'audios/' . $fileName;

            // Delete the image from the storage
            Storage::disk('public')->delete($path);

            // Delete the task from the database
            $user_uid = Auth::id();
            $task = Task::where('user_uid', $user_uid)
                ->where('value', $path)
                ->first();

            if ($task) {
                $task->delete();
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getContent($id)
    {

        switch($id) {
            case 1:
                $c_id = 49;
                break;
            case 2:
                $c_id = 54;
                break;
            case 3:  // Erinnerungsvideos
                $c_id = 101;
                break;
            case 4:
                $c_id = 103;
                break;
            case 5: //Stadtteilvideos
                $c_id = 105;
                break;
            case 6: // Outtakes
                $c_id = 102;
                break;
            case 9: // Navigation
                $c_id = 104;
                break;
            case 10:
                $c_id = 95;
                break;
            case 20:
                $c_id = 106;
                break;
            case 30:
                $c_id = 96;
                break;
            case 40:
                $c_id = 97;
                break;
            case 50:
                $c_id = 98;
                break;
            case 60:
                $c_id = 99;
                break;
            case 70:
                $c_id = 100;
                break;
            case 7:
                echo "It's Sunday.";
                break;
            default:
                $c_id = 0;
                break;
        }



        try {



            $content = DB::connection('moodle')->table('mdl_assign')->where('id', $c_id)->first();

            // If a task was found, delete the video file and then delete the task
            if ($content) {
                return response()->json([
                    'status' => 'success',
                    'intro' => $content->intro, // return intro
                    'title' => $content->name, // return title
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'intro' => "Diese Aufgabe konnte nicht gefunden werden",
                    'title' => "Schade",
                 ]);
            }
        } catch (\Exception $e) {
            $this->teamsError($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

}
