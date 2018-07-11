@extends('layouts.app')

@section('title')
	视频列表
@stop

@section('content')
<div class="container">
     @include('video.parts.top_list')
     @each('video.parts.hot_category_video',[0,1,2],"item")

    {{--  @include('video.parts.hot_category_video')
     @include('video.parts.hot_category_video')
     @include('video.parts.hot_category_video')
     @include('video.parts.hot_category_video') --}}
     <video-list></video-list>
</div>
@stop

@push('scripts')
  <script>
   	$(".cateory-logo").on('error', function(){
    	$(this).attr("src", "/images/default_logo.png");
    });

  </script>
@endpush