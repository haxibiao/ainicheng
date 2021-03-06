<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        $users = User::orderBy('id', 'desc')->paginate(50);
        return view('admin.users')->withUsers($users);
    }

    public function usersSearch()
    {
        // dd(request()->all());
        $query = User::orderBy('id', 'desc');
        if (!empty($name = request('name_email'))) {
            $query = $query->orWhere('name', 'like', "%$name%")->orWhere('email', 'like', "%$name%");
        }
        if (request('is_admin')) {
            $query = $query->where('is_admin', 1);
        }
        if (request('is_editor')) {
            $query = $query->where('is_editor', 1);
        }
        if (request('is_signed')) {
            $query = $query->where('is_signed', 1);
        }
        $users = $query->paginate(50);
        return view('admin.users')->withUsers($users);
    }

    public function categorySticks()
    {
        $categories = get_stick_categories(true);
        return view('admin.stick_categories')->withCategories($categories);
    }

    public function categoryStick()
    {
        $data = request()->all();

        if (count(get_stick_categories()) >= 5) {
            dd("添加的专题太多了,首页置顶的专题不允许超过5个");
        }

        $qb = Category::where('name', $data['category_name']);
        if ($qb->count()) {
            $data['category_id'] = $qb->pluck('id')->first();
            stick_category($data);
        } else {
            dd("专题不存在");
        }
        return redirect()->back();
    }

    public function videoCategorySticks()
    {
        $video_categories = get_stick_video_categories(true);
        return view('admin.stick_video_categories')->withVideoCategories($video_categories);
    }

    public function videoCategoryStick()
    {
        $data = request()->all();
        if (count(get_stick_video_categories()) >= 3) {
            dd("添加的专题太多了,视频置顶的专题不允许超过3个");
        }

        $qb = Category::where('name', $data['category_name']);
        if ($qb->count()) {
            $data['category_id'] = $qb->pluck('id')->first();
            stick_video_category($data);
        } else {
            dd("专题不存在");
        }

        return redirect()->back();
    }

    public function deleteStickCategory()
    {
        $category_id = request()->get('category_id');
        $items       = [];

        if (Storage::exists("stick_categories")) {
            $json  = Storage::get('stick_categories');
            $items = json_decode($json, true);
        }

        $left_items = [];
        foreach ($items as $item) {
            if ($item['category_id'] != $category_id) {
                $left_items[] = $item;
            }
        }

        $json = json_encode($left_items);
        Storage::put("stick_categories", $json);
        return redirect()->back();
    }

    public function deleteStickVideoCategory()
    {
        $category_id = request()->get('category_id');
        $items       = [];

        if (Storage::exists("stick_video_categories")) {
            $json  = Storage::get('stick_video_categories');
            $items = json_decode($json, true);
        }

        $left_items = [];
        foreach ($items as $item) {
            if ($item['category_id'] != $category_id) {
                $left_items[] = $item;
            }
        }

        $json = json_encode($left_items);
        Storage::put("stick_video_categories", $json);
        return redirect()->back();
    }

    public function articleSticks()
    {
        $articles = get_stick_articles('', true);
        return view('admin.stick_articles')->withArticles($articles);
    }

    public function articleStick()
    {
        $data = request()->all();
        stick_article($data);
        return redirect()->back();
    }

    public function videoSticks()
    {
        $videos = get_stick_videos('', true);
        return view('admin.stick_videos')->withVideos($videos);
    }

    public function videoStick()
    {
        $data = request()->all();
        stick_video($data);
        return redirect()->back();
    }

    public function deleteStickVideo()
    {
        $video_id = request()->get('video_id');
        $items    = [];
        if (Storage::exists("stick_videos")) {
            $json  = Storage::get('stick_videos');
            $items = json_decode($json, true);
        }
        $left_items = [];

        //找到需要删除的元素就跳出,不必要全部递归
        foreach ($items as $index => $item) {
            if ($item['video_id'] == $video_id) {
                array_splice($items, $index, 1);
                break;
            }
        }

        //这里重新装车一遍,否则容易造成全部删除的情况
        $left_items = $items;

        $json = json_encode($left_items);
        Storage::put("stick_videos", $json);
        return redirect()->back();
    }

    public function deleteStickVideos()
    {
        $video_id = request()->get('video_id');
        $items    = [];
        if (Storage::exists("stick_videos")) {
            $json  = Storage::get('stick_videos');
            $items = json_decode($json, true);
        }
        $left_items = [];

        //找到需要删除的元素就跳出,不必要全部递归
        foreach ($items as $index => $item) {
            if ($item['video_id'] == $video_id) {
                array_splice($items, $index, 1);
                break;
            }
        }

        //这里重新装车一遍,否则容易造成全部删除的情况
        $left_items = $items;

        $json = json_encode($left_items);
        Storage::put("stick_videos", $json);
        return redirect()->back();
    }

    public function deleteStickArticle()
    {
        $article_id = request()->get('article_id');
        $items      = [];
        if (Storage::exists("stick_articles")) {
            $json  = Storage::get('stick_articles');
            $items = json_decode($json, true);
        }
        $left_items = [];

        //找到需要删除的元素就跳出,不必要全部递归
        foreach ($items as $index => $item) {
            if ($item['article_id'] == $article_id) {
                array_splice($items, $index, 1);
                break;
            }
        }

        //这里重新装车一遍,否则容易造成全部删除的情况
        $left_items = $items;

        $json = json_encode($left_items);
        Storage::put("stick_articles", $json);
        return redirect()->back();
    }

    public function seoConfig()
    {
        $config           = (object) [];
        $config->seo_meta = '';
        $config->seo_push = '';
        $config->seo_tj   = '';
        if (Storage::exists("seo_config")) {
            $json   = Storage::get('seo_config');
            $config = json_decode($json);
        }
        return view('admin.seo_config')->withConfig($config);
    }

    public function saveSeoConfig()
    {
        $config = request()->all();
        $json   = json_encode($config);
        Storage::put("seo_config", $json);
        return redirect()->back()->with('saved', true);
    }

    public function friendLinks()
    {
        $links = [];
        if (Storage::exists("friend_links")) {
            $json  = Storage::get('friend_links');
            $links = json_decode($json, true);
        }
        return view('admin.friend_links')->withLinks($links);
    }

    public function addFriendLink()
    {
        $newLinkData = request()->all();
        $links       = [];
        if (Storage::exists("friend_links")) {
            $json  = Storage::get('friend_links');
            $links = json_decode($json, true);
        }
        $links[] = $newLinkData;
        $json    = json_encode($links);
        Storage::put("friend_links", $json);
        return redirect()->back();
    }

    public function deleteFriendLink()
    {
        $deleteDomain = request()->get('website_domain');
        $links        = [];
        if (Storage::exists("friend_links")) {
            $json  = Storage::get('friend_links');
            $links = json_decode($json, true);
        }
        $left_links = [];
        foreach ($links as $link) {
            if ($link['website_domain'] != $deleteDomain) {
                $left_links[] = $link;
            }
        }
        $json = json_encode($left_links);
        Storage::put("friend_links", $json);
        return redirect()->back();
    }

    public function article_push()
    {
        return view('admin.article_push');
    }

    public function push_article(Request $request)
    {
        $urls   = [];
        $number = $request->number;
        $type   = $request->type;

        switch ($type) {
            case 'pandaNumber':
                $appid = config('seo.' . get_domain_key() . '.articlePush.pandaNumber.appid');
                $token = config('seo.' . get_domain_key() . '.articlePush.pandaNumber.token');
                $api   = 'http://data.zz.baidu.com/urls?appid=' . $appid . '&token=' . $token . '&type=realtime';
                break;
            case 'baiduNumber':
                $token = config('seo.' . get_domain_key() . '.articlePush.baiduNumber.token');
                $api   = 'http://data.zz.baidu.com/urls?site=' . env('APP_URL') . '&token=' . $token;
                break;
            default:
                dd('提交的类型错误 没有这个类型');
                break;
        }

        $articles = Article::orderBy('id', 'desc')
            ->where('status', '>', 0)
            ->whereType('article')
            ->take($number)->get();

        foreach ($articles as $article) {
            $urls[] = config('app.url') . '/article/' . $article->id;
        }

        $ch      = curl_init();
        $options = array(
            CURLOPT_URL            => $api,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS     => implode("\n", $urls),
            CURLOPT_HTTPHEADER     => array('Content-Type: text/plain'),
        );

        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        if (str_contains($result, "success")) {
            return "成功";
        }
        return $result;
    }

    /**
     * @Author      XXM
     * @DateTime    2018-09-23
     * @description            [description]
     * @return      [type]     [description]
     */
    public function articles(Request $request)
    {
        if($request->isMethod('post')){
            $parmas = $request->all();
            $article_ids = explode(',', $parmas['article_ids']);

            if($parmas['type'] == 'deleteArticles'){
                DB::table('articles')->whereIn('id',$article_ids)->update(['status'=>-1]);
            }else if($parmas['type'] == 'sendArctiles'){
                DB::table('articles')->whereIn('id',$article_ids)->update(['status'=>1]);
            }else{
                $category = Category::whereName($parmas['category'])->first();
                if(!$category){
                    return '专题不存在';
                }
                $category_id = $category->id;
            }

            if($parmas['type'] == 'changeCategory'){
                DB::table('articles')->whereIn('id',$article_ids)->update(['category_id'=>$category_id]);
            }else if($parmas['type'] == 'addCategory'){
                $articles = Article::whereIn('id',$article_ids)->get();
                foreach ($articles as $article) {
                    $article->categories()->attach($category_id,['submit' => '已收录']);
                }

            }

            return redirect()->back();
        }

        $articles = Article::orderByDesc('id');
        $data['articles'] = $articles->paginate(10);

        
        return view('admin.articles')->withData($data);
    }
}
