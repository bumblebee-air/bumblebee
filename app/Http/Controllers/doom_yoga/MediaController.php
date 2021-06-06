<?php
namespace App\Http\Controllers\doom_yoga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{

    public function getVideosList()
    {
        $videoData1 = new VideoData(1, "Mental Training", "images/wheat-field.mp4", "images/doom-yoga/doom-yoga-logo.png", "04 Min 20 Sec", 1, "Category 1");
        $videoData2 = new VideoData(2, "For Losing Weight", "images/wheat-field.mp4", "images/doom-yoga/doom-yoga-logo.png", "12 Min 20 Sec", 2, "Category 2");

        $videos = array(
            $videoData1,
            $videoData2
        );

        return view('admin.doom_yoga.media.video_list', [
            'videos' => $videos
        ]);
    }

    public function postDeleteVideo(Request $request)
    {
        // dd($request);
        alert()->success('The video deleted successfully');
        return redirect()->back();
    }

    public function getEditVideo($clientName, $id)
    {
        // dd("get edit video ". $id);
        $videoData = new VideoData($id, "Mental Training", "images/wheat-field.mp4", "images/doom-yoga/Doomyoga-logo-black.png", "04 Min 20 Sec", 2, "Category 2");

        $category1 = new CategoryData(1, "category 1");
        $category2 = new CategoryData(2, "category 2");
        $category3 = new CategoryData(3, "category 3");
        $categoryList = array(
            $category1,
            $category2,
            $category3
        );

        return view('admin.doom_yoga.media.edit_video', [
            'categoryList' => $categoryList,
            'video' => $videoData
        ]);
    }

    public function postEditVideo(Request $request)
    {
        // dd($request->all());
        alert()->success('The video updated successfully');
        return redirect()->back();
    }

    public function getAddVideo()
    {
        $category1 = new CategoryData(1, "category 1");
        $category2 = new CategoryData(2, "category 2");
        $category3 = new CategoryData(3, "category 3");
        $categoryList = array(
            $category1,
            $category2,
            $category3
        );

        return view('admin.doom_yoga.media.add_video', [
            'categoryList' => $categoryList
        ]);
    }

    public function postAddVideo(Request $request)
    {
        // dd($request->all());
        alert()->success('The video uploaded successfully');
        return redirect()->back();
    }

    /**
     * ********************* audio ************************
     */
    public function getAudioList()
    {
        $audioData1 = new AudioData(11, 1, "Audio 1", "0:03", "audio/notification.mp3");
        $audioData2 = new AudioData(12, 2, "Audio 2", "00:04", "audio/update.mp3");
        $audios = array(
            $audioData1,
            $audioData2
        );

        return view('admin.doom_yoga.media.audio_list', [
            'audios' => $audios
        ]);
    }

    public function postDeleteAudio(Request $request)
    {
        // dd($request);
        alert()->success('The audio deleted successfully');
        return redirect()->back();
    }

    public function getEditAudio($clientName, $id)
    {
        // dd("get edit video ". $id);
        
        $audioData = new AudioData($id,1, "Audio 1", "0:03", "audio/notification.mp3");

        return view('admin.doom_yoga.media.edit_audio', [
            'audio' => $audioData
        ]);
    }

    public function postEditAudio(Request $request)
    {
        //dd($request->all());
        alert()->success('The audio updated successfully');
        return redirect()->back();
    }

    public function getAddAudio()
    {
        return view('admin.doom_yoga.media.add_audio');
    }

    public function postAddAudio(Request $request)
    {
        // dd($request->all());
        alert()->success('The audio uploaded successfully');
        return redirect()->back();
    }
}

class VideoData
{

    public $id, $title, $videoUrl, $posterImageUrl, $duration, $categoryId, $categoryName;

    function __construct($id, $title, $videoUrl, $posterImageUrl, $duration, $categoryId, $categoryName)
    {
        $this->id = $id;
        $this->title = $title;
        $this->videoUrl = $videoUrl;
        $this->posterImageUrl = $posterImageUrl;
        $this->duration = $duration;
        $this->categoryId = $categoryId;
        $this->categoryName = $categoryName;
    }
}

class CategoryData
{

    public $id, $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class AudioData
{

    public $id, $track, $name, $length, $file;

    function __construct($id, $track, $name, $length, $file)
    {
        $this->id = $id;
        $this->track = $track;
        $this->name = $name;
        $this->length = $length;
        $this->file = $file;
    }
}
