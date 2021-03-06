<?php

use App\Article;
use App\Category;
use App\Image;
use App\Video;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

function get_top_categoires($top_categoires)
{
    $categories = [];

    $stick_categories = get_stick_categories(false, true);
    foreach ($top_categoires as $category) {
        $categories[] = $category;
    }

    $categories = array_merge($stick_categories, $categories);
    $categories = new collection($categories);
    $categories = $categories->unique();

    return $categories;
}

function get_top_categories_count()
{
    $categories = [];

    $stick_categories = get_stick_categories();
    $leftCount        = 7 - count($stick_categories);
    return $leftCount;
}

function get_stick_categories($all = false, $index = false)
{
    $categories = [];
    if (Storage::exists("stick_categories")) {
        $json  = Storage::get('stick_categories');
        $items = json_decode($json, true);
        foreach ($items as $item) {
            if (!$all) {
                //expire
                if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                    continue;
                }
            }

            $category = category::find($item['category_id']);

            if ($index && $category) {
                $categories[] = $category;
                continue;
            }
            if ($category) {
                $category->reason     = !empty($item['reason']) ? $item['reason'] : null;
                $category->expire     = $item['expire'];
                $category->stick_time = diffForHumansCN(Carbon::createFromTimestamp($item['timestamp']));
                $categories[]         = $category;
            }
        }
    }
    return $categories;
}

function get_stick_video_categories($all = false, $index = false)
{
    $video_categories = [];
    if (Storage::exists("stick_video_categories")) {
        $json  = Storage::get('stick_video_categories');
        $items = json_decode($json, true);
        foreach ($items as $item) {
            if (!$all) {
                //expire
                if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                    continue;
                }
            }

            $category = category::find($item['category_id']);

            if ($index && $category) {
                $video_categories[] = $category;
                continue;
            }
            if ($category) {
                $category->reason     = !empty($item['reason']) ? $item['reason'] : null;
                $category->expire     = $item['expire'];
                $category->stick_time = diffForHumansCN(Carbon::createFromTimestamp($item['timestamp']));
                $video_categories[]         = $category;
            }
        }
    }
    return $video_categories;
}

function stick_category($data, $auto = false)
{
    $items = [];

    if (Storage::exists("stick_categories")) {
        $json = Storage::get("stick_categories");

        foreach (json_decode($json, true) as $item) {
            //expire
            if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                continue;
            }
            $items[] = $item;
        }
    }

    $data['timestamp'] = time();
    if ($auto) {
        $items[] = $data;
    } else {
        $items = array_merge([$data], $items);
    }
    $json = json_encode($items);
    Storage::put("stick_categories", $json);
}

function stick_video_category($data, $auto = false)
{
    $items = [];

    if (Storage::exists("stick_video_categories")) {
        $json = Storage::get("stick_video_categories");

        foreach (json_decode($json, true) as $item) {
            //expire
            if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                continue;
            }
            $items[] = $item;
        }
    }

    $data['timestamp'] = time();
    if ($auto) {
        $items[] = $data;
    } else {
        $items = array_merge([$data], $items);
    }
    $json = json_encode($items);
    Storage::put("stick_video_categories", $json);
}

function stick_article($data, $auto = false)
{ 
    $items = [];

    $article   = Article::where('id', $data['article_id'])->whereStatus(1)->first();
    //文章状态是否正常 
    if(empty($article)){
        dd("该文章已经删除不能上首页");
    }
    //检查该文章的主配图能否上首页
    if ($data['position'] =='轮播图') {
        $image_url = str_replace('.small', '', $article->image_url);
        $image     = Image::where('path', $image_url)->first();
        if (empty($image) || $image->width < 760) {
            dd("该文章的主配图达不到上首页的标准");
        }
    }

    if (Storage::exists("stick_articles")) {
        $json = Storage::get('stick_articles');
        //auto clear expired items
        foreach (json_decode($json, true) as $item) {
            //expire
            if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                continue;
            }
            $items[] = $item;
        }
    }

    $data['timestamp'] = time();
    if ($auto) {
        $items[] = $data;
    } else {
        $items = array_merge([$data], $items);
    }
    $json = json_encode($items);
    Storage::put("stick_articles", $json);
}

function get_top_articles()
{
    $articles        = [];
    $stick_articles  = get_stick_articles('轮播图');

     $stick_article_ids = array_column( $stick_articles, 'id' );

    $leftCount       = 8 - count($stick_articles);
    $topped_articles = Article::where('is_top', 1)
        ->where('image_top', '<>', '')
        ->where('status', '>', '0')
        ->whereNotIn('id', $stick_article_ids)
        ->orderBy('id', 'desc')
        ->take($leftCount)->get();  
    
    foreach ($topped_articles as $item) {
        $articles[] = $item;
    }
    
    $articles = array_merge($stick_articles, $articles);
    return $articles;
}

function get_stick_articles($position = '', $all = false)
{
    $articles = [];
    if (Storage::exists("stick_articles")) {
        $json  = Storage::get('stick_articles');
        $items = json_decode($json, true);
        foreach ($items as $item) {
            if (!$all) {
                //position
                if (!empty($position) && $position != $item['position']) {
                    continue;
                }
                //expire
                if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                    continue;
                }
            }

            $article = Article::find($item['article_id']);
            if ($article) {
                $article->reason     = !empty($item['reason']) ? $item['reason'] : null;
                $article->expire     = $item['expire'];
                $article->position   = $item['position'];
                $article->stick_time = diffForHumansCN(Carbon::createFromTimestamp($item['timestamp']));
                $articles[]          = $article;
            }
        }
    }
    return $articles;
}

function get_stick_videos($position = '', $all = false)
{
    $videos = [];
    if (Storage::exists("stick_videos")) {
        $json  = Storage::get('stick_videos');
        $items = json_decode($json, true);
        foreach ($items as $item) {
            if (!$all) {
                //position
                if (!empty($position) && $position != $item['position']) {
                    continue;
                }
                //expire
                if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                    continue;
                }
            }

            $video = Video::find($item['video_id']);
            if ($video) {
                $video->reason     = !empty($item['reason']) ? $item['reason'] : null;
                $video->expire     = $item['expire'];
                $video->position   = $item['position'];
                $video->stick_time = diffForHumansCN(Carbon::createFromTimestamp($item['timestamp']));
                $videos[]          = $video;
            }
        }
    }
    return $videos;
}

function stick_video($data, $auto = false)
{ 
    $items = [];

    $video   = Video::where('id', $data['video_id'])->whereStatus(1)->first();
    //视频状态是否正常 
    if(empty($video)){
        dd("该视频已经删除不能上首页");
    }

    if (Storage::exists("stick_videos")) {
        $json = Storage::get('stick_videos');
        //auto clear expired items
        foreach (json_decode($json, true) as $item) {
            //expire
            if (Carbon::createFromTimestamp($item['timestamp'])->addDays($item['expire']) < Carbon::now()) {
                continue;
            }
            $items[] = $item;
        }
    }

    $data['timestamp'] = time();
    if ($auto) {
        $items[] = $data;
    } else {
        $items = array_merge([$data], $items);
    }
    $json = json_encode($items);
    Storage::put("stick_videos", $json);
}

function get_seo_meta()
{
    $meta = '';
    if (Storage::exists("seo_config")) {
        $json   = Storage::get('seo_config');
        $config = json_decode($json);
        $meta   = $config->seo_meta;
    }
    return $meta;
}

function get_seo_push()
{
    $push = '';
    if (Storage::exists("seo_config")) {
        $json   = Storage::get('seo_config');
        $config = json_decode($json);
        $push   = $config->seo_push;
    }
    return $push;
}

function get_seo_tj()
{
    $tj = '';
    if (Storage::exists("seo_config")) {
        $json   = Storage::get('seo_config');
        $config = json_decode($json);
        $tj     = $config->seo_tj;
    }
    return $tj;
}
