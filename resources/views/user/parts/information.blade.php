 <div class="note-info info-lg">
    <a class="avatar" href="/user/{{ $user->id }}"><img src="{{ $user->avatar() }}" alt=""></a>
    @if(!$user->isSelf())
        <div class="btn-wrap">
            <follow 
                type="users" 
                id="{{ $user->id }}" 
                user-id="{{ user_id() }}" 
                followed="{{ is_follow('users', $user->id) }}"
                >
            </follow>
            <a class="btn-base btn-hollow" href="/chat/with/{{ $user->id }}">发消息</a>
        </div>
    @endif
    
    <div class="title">
        <a class="name" href="/user/{{ $user->id }}">{{ $user->name }}</a>
        @php
            $gender_icon = '';
            if($user->gender == '男') {
                $gender_icon ='man icon-nansheng1';
            } else if($user->gender == '女') {
                $gender_icon ='woman icon-nvsheng1';
            }
        @endphp
        <i class="iconfont {{  $gender_icon }}"></i>
        @if($user->is_editor)
          <img class="badge-icon hidden-md hidden-sm hidden-lg" src="/images/signed.png" data-toggle="tooltip" data-placement="top" title="{{ config('app.name') }}签约作者" alt="">
        @endif
    </div>
    
    <div class="info">
        <ul class="info-list">
            <li class="hidden-xs">
                <a href="/user/{{ $user->id }}/followings">
                    <p>{{ $user->count_followings }}</p>
                    关注
                    <i class="iconfont icon-youbian"></i>
                </a>
            </li>
            <li class="hidden-xs">
                <a href="/user/{{ $user->id }}/followers">
                    <p>{{ $user->count_follows }}</p>
                    粉丝
                    <i class="iconfont icon-youbian"></i>
                </a>
            </li>
            <li>
                <a href="/user/{{ $user->id }}">
                    <p>{{ $user->count_articles }}</p>
                    文章
                    <i class="iconfont icon-youbian"></i>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <p>{{ $user->count_words }}</p>
                    字数
                    <i class="iconfont icon-youbian"></i>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <p>{{ $user->count_likes }}</p>
                    收获喜欢
                    <i class="iconfont icon-youbian"></i>
                </a>
            </li>
        </ul>
    </div>
</div>