@extends('layouts.app')

@section('title')
    添加文章
@endsection
@section('keywords')
  
@endsection
@section('description')
  
@endsection

@section('content')

<div class="container-fluid">
<ol class="breadcrumb">
    <li><a href="/">懂点医</a></li>
    <li class="active">添加文章</li>
  </ol>
<div class="row">
  <div class="col-md-7">
    <form action="/article" method="POST" role="form" enctype="multipart/form-data" id='article_form'>
      {{ csrf_field() }}
      <legend>添加新的文章</legend>

      <div class="form-group">
        <label>标题</label>
        <input type="text" class="form-control" placeholder="标题" name="title">
      </div>
      <div class="form-group">
        <label>作者</label>
        <input type="text" class="form-control" placeholder="作者" name="author" value="{{ Auth::user()->name }}">
      </div>
      <div class="form-group">
        <label>关键词</label>
        <input type="text" class="form-control" placeholder="关键词" name="keywords">
      </div>
      <div class="form-group">
        <label>简介</label>
        <input type="text" class="form-control" placeholder="简介" name="description">
      </div>
      <div class="form-group">
        <label>正文</label>
        <textarea class="hidden"  name="body"></textarea>
        <div class="editable"></div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-danger">提交</button>
      </div>

      
    </form>
  </div>
  <div class="col-md-5">
      @include('article.parts.image_upload_ui')
  </div>
</div>


</div>

@endsection

@push('scripts')
<script type="text/javascript">
  $(function() {
    var editor = $('.editable').summernote({
        lang: 'zh-CN', // default: 'en-US',
        height: 500,
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
      });

    $('.editable').on('summernote.change', function(we, contents, $editable) {
      $('textarea').val(contents);
    });
    
  });

</script>
@endpush