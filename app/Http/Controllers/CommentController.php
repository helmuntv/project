<?php

namespace App\Http\Controllers;

use App\Post;
use App\Video;
use App\Comment;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class CommentController extends BaseController
{
    use ApiResponser;

    public function showCommentPost(Request $request, $id){
    
        $post = Post::find($id);

        return $post->comments;
               
    }

    public function showCommentVideo(Request $request, $id){

        $video = Video::find($id);

        return $video->comments;
               
    }

    public function storeCommentPost(Request $request, $id){

        $comment = new Comment(array('content' => $request->content));

        $post = Post::find($id);

        $comment = $post->comments()->save($comment);
               
    }

    public function storeCommentVideo(Request $request, $id){

        $comment = new Comment(array('content' => $request->content));

        $video = Video::find($id);

        $comment = $video->comments()->save($comment);
               
    }
}
