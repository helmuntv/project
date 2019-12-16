<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use App\Video;
use App\Comment;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class TagController extends BaseController
{
    use ApiResponser;

    public function showTagPost(Request $request, $id){

        $post = Post::find($id);

        return $post->tags;
               
    }

    public function showTagVideo(Request $request, $id){

        $video = Video::find($id);

        return $video->tags;
               
    }

    public function storeTagPost(Request $request, $id){

        $post = Post::find($id);

        $tag = $post->tags()->attach([$request->tag_id]);
               
    }

    public function storeTagVideo(Request $request, $id){

        $video = Video::find($id);

        $tag = $video->tags()->attach([$request->tag_id]);
               
    }
}
