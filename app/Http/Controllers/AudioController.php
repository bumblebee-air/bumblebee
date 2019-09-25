<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use User;
use Storage;
use File;

class AudioController extends Controller
{

    public function index() {
        $user = null;
        $api_key = env('API_KEY');
        return view('record_audio', ['user'=> $user, 'api_key'=> $api_key]);
    }

    public function save_recorded_audio(Request $request) {
        
        if ($request->has('file') && $request->file_name != '' && $request->file_name != NULL) {
            // Get image file
            $audio_file = $request->file('file');
            // Make a image name based on user name and current timestamp
            $name = 'audio' . '_' . time();
            // Define folder path
            $folder = '/uploads/audio_files/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name . '.' . 'mp3';
            // Upload image
            $this->uploadOne($audio_file, $folder, 'public', $name);
            // Set user profile image path in database to filePath

            $apiKey = env('API_KEY');
            $audioFile = Storage::disk('public')->path('uploads/audio_files/') .$name.'.mp3';
            // $audioFile = Storage::disk('public')->path('uploads/audio_files/') .'test_1569301996.mp3';
            $url="https://speech.googleapis.com/v1p1beta1/speech:recognize?key=".$apiKey;
            $audioFileResource = fopen($audioFile, 'r');
            $base64Audio = base64_encode(stream_get_contents($audioFileResource));
            $settings=array(
                'config'=> array(
                    'encoding'=> 'MP3',
                    'sampleRateHertz' => 44100,
                    'languageCode' => 'en-US',
                    "maxAlternatives" => 1,
                    "audioChannelCount" => 2,
                    "enableSeparateRecognitionPerChannel"=> false,
                    "enableAutomaticPunctuation" => true,
                    "model"=> 'command_and_search'
                ),
                'audio'=>array(
                    'content'=>$base64Audio
                )
            );
            $json=json_encode($settings);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,            $url );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt($ch, CURLOPT_POST,           1 );
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $json ); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 

            $result=curl_exec ($ch);
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            }
            $data = json_decode($result, true);
            $transcript = '';
            if(array_key_exists('results', $data)) {
                foreach($data['results'] as $results) {
                    foreach($results['alternatives'] as $trans) {
                        $transcript = $trans['transcript'];  
                    }
                }
            } else {
                $transcript = 'Please try again';
            }
            
            return $transcript;   
        }
    }

     // function to upload the file at specific location
     public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
     {
         $name = !is_null($filename) ? $filename : str_random(25);
 
         $file = $uploadedFile->storeAs($folder, $name . '.' . 'mp3', $disk);
 
         return $file;
     }
}
