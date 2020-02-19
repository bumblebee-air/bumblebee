<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Response;
use App\Keyword;
use Redirect;
use Session;
use Validator;
use Input;
use App\Util\ConcatAudioFilter;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::paginate(5);
        return view('admin.responses.index', ['responses' => $responses]);
    }

    public function create()
    {
        $keywords = Keyword::where('audio', '!=', null)->get();
        return view('admin.responses.create', [
            'keywords' => $keywords
        ]);
    }

    public function store(Request $request)
    {
        $keywordsArr = explode(',', $request->audio_keywords);

        if (($validation_message_bag = $this->validateForm()) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $keywords = Keyword::whereIn('id', $keywordsArr)->get();
        $audios = [];

        $firstKeyword = null;

        if ($keywords) {
            $responseName = [];
            foreach ($keywordsArr as $key => $value) {
                foreach ($keywords as $keyword) {
                    if ($value == $keyword->id) {
                        if ($key === 0) {
                            $firstKeyword = $keyword;
                        } else {
                            $audios[] = public_path($keyword->audio);
                        }
                        $responseName[] = $keyword->keyword;
                    }
                }
            }

            // Merge audio files
            $ffmpeg = \FFMpeg\FFMpeg::create(config('ffmpeg'));
            $audio = $ffmpeg->open(public_path($firstKeyword->audio));

            if (count($audios) > 0) {
                $filter = new ConcatAudioFilter();
                $filter->addFiles($audios);
            }

            $audioName = 'output-' . time() . '.mp3';
            $audioPath = 'uploads/responses/'  . $audioName;
            $format = new \FFMpeg\Format\Audio\Mp3();
            $audio->addFilter($filter);
            $audio->save($format, base_path() . '/public/uploads/responses/' . $audioName);

            $response = new Response();
            $response->keywords = json_encode($responseName);
            $response->audio = $audioPath;
            $response->save();

            Session::flash('success', 'New response was added successfully!');
        }
        return Redirect::route('responses');
    }

    public function edit(Response $response)
    {
        $keywords = Keyword::where('audio', '!=', null)->get();

        return view('admin.responses.edit', [
            'response' => $response,
            'keywords' => $keywords
        ]);
    }

    public function update(Request $request, Response $response)
    {
        if ($request->audio_keywords != implode(',', $response->keywords)) {

            if (($validation_message_bag = $this->validateForm()) !== true) {
                return redirect()->back()->withErrors($validation_message_bag)->withInput();
            }

            $keywordsArr = explode(',', $request->audio_keywords);

            $keywords = Keyword::whereIn('id', $keywordsArr)->get();

            $audios = [];
            $firstKeyword = null;
            $responseName = [];
            foreach ($keywordsArr as $key => $value) {
                foreach ($keywords as $keyword) {
                    if ($value == $keyword->id) {
                        if ($key === 0) {
                            $firstKeyword = $keyword;
                        } else {
                            $audios[] = public_path($keyword->audio);
                        }
                        $responseName[] = $keyword->keyword;
                    }
                }
            }

            // Merge audio files
            $ffmpeg = \FFMpeg\FFMpeg::create(config('ffmpeg'));
            $audio = $ffmpeg->open(public_path($firstKeyword->audio));

            if (count($audios) > 0) {
                $filter = new ConcatAudioFilter();
                $filter->addFiles($audios);
            }

            $audioName = 'output-' . time() . '.mp3';
            $audioPath = 'uploads/responses/'  . $audioName;
            $format = new \FFMpeg\Format\Audio\Mp3();
            $audio->addFilter($filter);
            $audio->save($format, base_path() . '/public/uploads/responses/' . $audioName);

            // delete old response audio file
            if (!empty($response->audio) && file_exists(public_path("{$response->audio}"))) {
                $oldAudio = $response->audio;
                unlink(base_path('public/' . $oldAudio));
            }

            $response->keywords = json_encode($responseName);
            $response->audio = $audioPath;
            $response->save();

            Session::flash('success', 'Response was updated successfully!');
        }

        return Redirect::route('responses');
    }

    public function destroy(Response $response)
    {
        if ($response->audio && file_exists(public_path("{$response->audio}"))) {
            unlink(base_path('public/' . $response->audio));
        }
        $response->delete();

        Session::flash('success', 'Response was deleted successfully!');

        return Redirect::route('responses');
    }

    private function validateForm()
    {
        $rules = [
            'keywords' => 'required|array|min:2',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }
}
