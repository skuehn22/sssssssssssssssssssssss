<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Str;
use ZipArchive;



class AuswertungController extends Controller

{
    public function getAllTask(Request $request)
    {
        try {
            // Helper function to convert the username to the desired format


            // Get the user's name and ID from the authentication
            $name = Auth::user()->name;
            $currentUserId = Auth::id();

            // Use regex to extract the _number pattern
            if (preg_match('/_(\d+)$/', $name, $matches)) {
                $suffix = $matches[0]; // This will contain something like _11499

                // Retrieve all users with names that include this pattern, excluding the currently logged in user
                $usersWithSameSuffix = User::where('name', 'like', '%' . $suffix)
                    ->where('id', '!=', $currentUserId)
                    ->get();

                // Initialize an array to store tasks for each user
                $allTasks = [];

                foreach ($usersWithSameSuffix as $user) {
                    $userTasks = Task::where('user_uid', $user->id)->get();

                    // Group tasks by the task number
                    foreach ($userTasks as $task) {
                        $taskNumber = $task->task;

                        $userName = $this->convertUserName($user->name);  // Convert the username


                        // If the user key doesn't exist yet, initialize it
                        if (!isset($allTasks[$taskNumber][$userName])) {
                            $allTasks[$taskNumber][$userName] = [];
                        }

                        // Append the task to the user's task list
                        $allTasks[$taskNumber][$userName][] = $task;
                    }
                }

                // Return the aggregated result
                return response()->json(['allTasks' => $allTasks]);

            } else {
                return response()->json(['status' => 'error', 'message' => 'Name does not contain expected pattern'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function getClasses(Request $request)
    {
        try {

            $groups = DB::connection('moodle')->table('mdl_groups')->where('description', $_GET['bookingNumber'])->where('courseid', 8)->get();

            $test = response()->json(['classes' => $groups]);


            return response()->json(['classes' => $groups]);
        }
            catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function getAllTaskOntour(Request $request)
    {
        try {

            $groups_member = DB::connection('moodle')->table('mdl_groups_members')->where('groupid', $_GET['classId'])->get();

            $v_code_user = $groups_member[0]->userid;

            foreach ($groups_member as $user) {

               $data = User::where('moodle_uid', $user->userid)->first();

               if($data){
                   $users[] = $data;
               }

            }

            foreach ($users as $user) {

                $userTasks = Task::where('user_uid', $user->id)->get();

                // Group tasks by the task number
                foreach ($userTasks as $task) {
                    $taskNumber = $task->task;
                    $userName = $this->convertUserName($user->name);  // Convert the username

                    if($taskNumber == 10 ){
                        $taskNumber = 1;
                    }

                    if($taskNumber == 20 ){
                        $taskNumber = 2;
                    }

                    if($taskNumber == 30 ){
                        $taskNumber = 7;
                    }

                    if($taskNumber == 40 ){
                        $taskNumber = 8;
                    }

                    if($taskNumber == 50 ){
                        $taskNumber = 3;
                    }


                    // If the user key doesn't exist yet, initialize it
                    if (!isset($allTasks[$taskNumber][$userName])) {
                        $allTasks[$taskNumber][$userName] = [];
                    }

                    // Append the task to the user's task list
                    $allTasks[$taskNumber][$userName][] = $task;
                }
            }




            if (env('APP_ENV') !== 'local1') {

                try {
                    $zip = new ZipArchive();
                    $filename = "./medien_" . $_GET['bookingNumber'] . ".zip";

                    // Delete the ZIP file if it already exists
                    if (file_exists($filename)) {
                        unlink($filename);
                    }

                    if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
                        throw new \Exception("Cannot open <$filename>");
                    }

                    $zipFiles = $allTasks;
                    $missingFiles = []; // Array to store missing files information

                    foreach ($zipFiles as $key => $task) {
                        foreach ($task as $groupName => $group) {

                            $i = 1;
                            foreach ($group as $file_id => $file) {
                                if ($key != 1) {

                                    $filePath = 'uploads/' . $group[$file_id]['value'];
                                    $newZipFilename = "A" . $key . "-" . $groupName . "-" . $i . "-" . basename($filePath);

                                    $i++;

                                    if (file_exists($filePath) && is_file($filePath)) {
                                        $zip->addFile($filePath, $newZipFilename);
                                    } else {
                                        // Instead of throwing an exception, log the missing file
                                        $missingFiles[] = $filePath;
                                    }
                                }
                            }
                        }
                    }

                    $zip->close();

                    // Include missing files information in the response if there are any
                    if (!empty($missingFiles)) {

                    }

                } catch (\Exception $e) {
                    // Handle exceptions related to ZIP file operations
                    return response()->json(['status' => 'error', 'message' => 'ZIP File Operation Failed: ' . $e->getMessage()], 500);
                }
            }



            $data = DB::connection('moodle')->table('mdl_booking_data3')->where('user_id', $v_code_user)->first();
            $test = $data->operators_id;
            $op = DB::connection('moodle')->table('mdl_ext_operators1')->where('id', $test)->first();
            $schuler_names = DB::connection('moodle')->table('mdl_finishing_students')->where('fk_user', $v_code_user)->get();
            $lehrer_names = DB::connection('moodle')->table('mdl_finishing_lehrer')->where('fk_user', $v_code_user)->get();
            $test = $data->user_id;
            $lehrer = DB::connection('moodle')->table('mdl_user')->where('id', $test)->first();

            if(!isset($filename)){
                return response()->json(['zipUrl' => url('./medien_9100.zip'), 'allTasks' => $allTasks, 'schuler' => $schuler_names, 'lehrer' => $lehrer_names, 'data' => $data , 'op' => $op , 'lehrer_data' => $lehrer]);
            }else{
                return response()->json(['zipUrl' => url($filename), 'allTasks' => $allTasks, 'schuler' => $schuler_names, 'lehrer' => $lehrer_names, 'data' => $data , 'op' => $op , 'lehrer_data' => $lehrer]);
            }


        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


    public function deleteZip(Request $request)
    {
        try {
            // Check if the bookingNumber is provided
            if (!$request->has('bookingNumber')) {
                return response()->json(['status' => 'error', 'message' => 'bookingNumber parameter is required.'], 400);
            }

            $filename = "./medien_" . $request->get('bookingNumber') . ".zip";

            // Check if the file exists
            if (file_exists($filename)) {
                // Attempt to delete the file
                if (unlink($filename)) {
                    return response()->json(['status' => 'success', 'message' => 'ZIP file successfully deleted.']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Failed to delete the ZIP file.'], 500);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'ZIP file not found.'], 404);
            }

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }



    public function convertUserName($name) {
        // Match the pattern (g followed by a number)
        if (preg_match('/g(\d+)_/', $name, $matches)) {
            return 'Gruppe ' . $matches[1];
        }
        return $name; // Return original name if no match is found
    }


}
