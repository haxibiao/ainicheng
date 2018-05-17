@extends('layouts.app')

@section('title')
    经典热门 - 爱你城
@stop
@section('content')
<div id="hot_articles">
    <div class="container">
        <div class="row">
            {{-- 左侧 --}}
            <div class="main col-xs-12 col-sm-8">
            	<div class="page_banner">
                    <div class="banner_img thirty_list">
                        <div>
                            <i class="iconfont icon-huo1"></i>
                            <span>经典热门</span>
                        </div>
                    </div>
                </div>
                {{-- 文章摘要 --}}
                @include('category.parts.category_item',['articles'=>$articles])
                {{-- <article-list api="/index/monthly" start-page="2" /> --}}
            </div>
            {{-- 右侧 --}}
            <div class="aside col-sm-4">
                {{-- 推荐作者 --}}
                @if(Auth::check())
                <recommend-authors></recommend-authors>
                @endif
            </div>
        </div>
    </div>
</div>
@stop