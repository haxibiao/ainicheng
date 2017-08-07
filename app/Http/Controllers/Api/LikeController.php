<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Controllers\Controller;
use App\Like;
use App\Video;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function save(Request $request, $id, $type)
    {
        $like = Like::firstOrNew([
            'user_id'   => $request->user()->id,
            'object_id' => $id,
            'type'      => $type,
        ]);
        $like->save();
        $this->updateLikes($type, $id, 1);
        return $this->get($request, $id, $type);
    }

    public function delete(Request $request, $id, $type)
    {
        $like = Like::firstOrNew([
            'user_id'   => $request->user()->id,
            'object_id' => $id,
            'type'      => $type,
        ]);
        $like->delete();
        $this->updateLikes($type, $id, -1);
        return $this->get($request, $id, $type);
    }

    public function get(Request $request, $id, $type)
    {
        $like = Like::firstOrNew([
            'user_id'   => $request->user()->id,
            'object_id' => $id,
            'type'      => $type,
        ]);
        $data['is_liked'] = $like->id;
        $data['likes']    = 0;
        if ($type == 'article') {
            $article = Article::find($id);
            if ($article) {
                $data['likes'] = $article->likes;
            }
        }
        if ($type == 'video') {
            $video = Video::find($id);
            if ($video) {
                $data['likes'] = $video->likes;
            }
        }
        return $data;
    }

    public function updateLikes($type, $id, $num)
    {

        if ($type == 'article') {
            $article = Article::find($id);
            if ($article) {
                $article->likes += $num;
                $article->save();
            }
        }
        if ($type == 'video') {
            $video = Video::find($id);
            if ($video) {
                $video->likes += $num;
                $video->save();
            }
        }
    }
}
