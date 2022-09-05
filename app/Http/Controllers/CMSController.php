<?php

namespace App\Http\Controllers;

use App\Models\Cms;
use Illuminate\Http\Request;

class CMSController extends Controller
{
    public function getAllPages(Request $request){
        $pages= Cms::all();
        return response()->json($pages, 200);
    }

    public function getPages(Request $request){
        $pages = $request->get('pages');
        if($pages==null){
            return response()->json(['error'=>1, 'message'=>'No pages were provided!',
                'pages'=>[]])->setStatusCode(422);
        }
        $pages = explode(',',$pages);
        $cms_pages = Cms::query()->whereIn('slug',$pages)->select(['slug','text'])->get();
        return response()->json(['error'=>0, 'message'=>'Pages retrieved',
            'pages'=>$cms_pages]);
    }
}
