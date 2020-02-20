<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keyword;
use Validator;
use Redirect;
use Input;
use Session;

class KeywordsController extends Controller
{
    public function index()
    {
        $keywords = Keyword::paginate(5);
        return view('admin.keywords.index', ['keywords' => $keywords]);
    }

    public function addKeyword()
    {
        return view('admin.keywords.add');
    }

    public function removeAudio(Request $request)
    {
        $keyword = Keyword::find($request->keywordId);

        if (!empty($keyword->audio)) {
            unlink(base_path('public/' . $keyword->audio));
            $keyword->audio = null;
            $keyword->save();
            return response()->json(['status' => 'success', 'message' => 'Audio deleted successfully']);
        }
        return response()->json(['status' => 'fail', 'message' => 'something went wrong']);
    }

    public function store(Request $request)
    {
        if (($validation_message_bag = $this->validateForm($request)) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }
        $audio = $request->file('audio');

        if ($audio) {
            $audioName = $request->keyword . '_' . time() . '.' . $audio->getClientOriginalExtension();
            $audioPath = 'uploads/audios/' . $audioName;
            $audio->move(base_path() . '/public/uploads/audios/', $audioName);
        }
        $keyword = new Keyword();
        $keyword->keyword = $request->keyword;
        $keyword->weight = $request->weight;
        $keyword->audio = !empty($audioPath) ? $audioPath : null;
        $keyword->save();

        Session::flash('success', 'New keyword was added successfully!');

        return Redirect::route('keywords');
    }

    public function edit(Keyword $keyword)
    {
        return view('admin.keywords.edit', [
            'keyword' => $keyword
        ]);
    }

    public function update(Request $request, Keyword $keyword)
    {
        if (($validation_message_bag = $this->validateForm($request)) !== true) {
            return redirect()->back()->withErrors($validation_message_bag)->withInput();
        }

        $audio = $request->file('audio');

        if ($audio) {
            // upload new audio file
            $audioName = $request->keyword . '_' . time() . '.' . $audio->getClientOriginalExtension();
            $audioPath = 'uploads/audios/' . $audioName;
            $audio->move(base_path() . '/public/uploads/audios/', $audioName);

            // delete old audio file
            if (!empty($keyword->audio) && file_exists(public_path("{$keyword->audio}"))) {
                $oldAudio = $keyword->audio;
                unlink(base_path('public/' . $oldAudio));
            }

            $keyword->audio = !empty($audioPath) ? $audioPath : null;
        }
        $keyword->keyword = $request->keyword;
        $keyword->weight = $request->weight;
        $keyword->update();

        Session::flash('success', 'Keyword was updated successfully!');

        return Redirect::route('keywords');
    }

    public function destroy(Keyword $keyword)
    {
        if ($keyword->audio && file_exists(public_path("{$keyword->audio}"))) {
            unlink(base_path('public/' . $keyword->audio));
        }
        $keyword->delete();

        Session::flash('success', 'Keyword was deleted successfully!');

        return Redirect::route('keywords');
    }

    private function validateForm($request)
    {
        $rules = [
            'keyword' => 'required',
            'weight' => 'numeric|min:0|max:100',
        ];

        if ($request->hasFile('audio')) {
            $rules['audio'] = 'mimes:audio/mpeg,mpga,mp3,wav,audio/ogg';
        }

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }
}
