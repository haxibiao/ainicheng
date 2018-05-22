@extends('layouts.app')
@section('title')
  {{ $category->name }}
@endsection
@section('keywords')
  {{ $category->name }}
@endsection
@section('description')
  {{ $category->name }}
@endsection

@section('content')
<div class="container">
    <ol class="breadcrumb">
    	<li><a href="/">{{ config('app.name') }}</a></li>
        <li class="active">
            {{ $category->name }}
        </li>
    </ol>
    @include('parts.carousel')
    <div class="panel panel-default top20">
        <div class="panel-heading">
            <h3 class="panel-title">
                {{ $category->name }}文章
            </h3>
        </div>
        <div class="panel-body">
            <div class="list-group">
                @foreach($articles as $article)
                <a class="list-group-item" href="/article/{{ $article->id }}">
                    {{ $article->title }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection