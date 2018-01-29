@extends('layouts.app')

@section('title')
    问答 - 爱你城
@stop
@section('content')
<div id="interlocution">
    <div class="interlocution_top">
        <div class="container">
            {{-- 专题分类 --}}
            @include('interlocution.parts.category_list',['categories'=>$categories])
        </div>
    </div>
    <div class="interlocution_note">
        <div class="container">
            <div class="row">
                {{-- 左侧 --}}
                <div class="main col-xs-12 col-sm-8">
                    {{-- 文章摘要 --}}
                    <div class="article_list">
                        @include('interlocution.parts.article_list',['questions'=>$questions])
                    </div>
                    {{-- 分页 --}}
                    {{-- <ul class="pagination">
                        <li>
                            <a href="#">
                                <span>
                                    上一页
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                1
                            </a>
                        </li>
                        <li>
                            <a class="active" href="#">
                                2
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                3
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>
                                    下一页
                                </span>
                            </a>
                        </li>
                    </ul> --}}
                </div>
                {{-- 右侧 --}}
                <div class="aside col-sm-4">
                    {{-- 轮播图 --}}
                    @include('interlocution.parts.poster')
                    {{-- 精选回答 --}}
                    @include('interlocution.parts.selected_article_list')
                    {{-- 联系我们 --}}
                    @include('interlocution.parts.contact_us')
                </div>
            </div>
        </div>
        @include('parts.foot')
    </div>
    <question-modal></question-modal>
</div>
@stop
