@extends('v2.layouts.blank')

@section('title')
    登录 - 爱你城
@stop
@section('content')
<div id="sign_in">
    <div class="logo">
        <a href="/v2">
            <span class="love">
                爱
            </span>
            <span class="you">
                你
            </span>
            <span class="city">
                城
            </span>
        </a>
    </div>
    <div class="main">
        <h4 class="title">
            <div class="normal_title">
                <a class="active" href="javascript:;">
                    登录
                </a>
                <b>
                    ·
                </b>
                <a href="/v2/sign_up">
                    注册
                </a>
            </div>
        </h4>
        <div class="sign_in_contauner">
            <form accept-charset="utf-8" action="">
                <div class="input_prepend restyle">
                    <input placeholder="手机号或邮箱" type="text"/>
                    <i class="iconfont icon-yonghu01">
                    </i>
                </div>
                <div class="input_prepend">
                    <input placeholder="密码" type="text"/>
                    <i class="iconfont icon-suo2">
                    </i>
                </div>
                <div class="captcha">
                    <div class="geetest_wind">
                        <div class="geetest_radar_btn">
                            <div class="geetest_radar">
                                <div class="geetest_sector">
                                </div>
                                <div class="geetest_ring">
                                </div>
                                <div class="geetest_small">
                                </div>
                            </div>
                            <div class="geetest_radar_tip">
                                <span>
                                    点击按钮进行验证
                                </span>
                            </div>
                            <a class="geetest_logo" href="javascript:;">
                                <i class="iconfont icon-dunpai">
                                </i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="remember_btn">
                    <input checked="checked" type="checkbox" value="true"/>
                    <span>
                        记住我
                    </span>
                </div>
                <div class="forget_btn">
                    <a data-toggle="dropdown" href="javascript:;">
                        登录遇到问题？
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="javascript:;">
                                用手机号重置密码
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                用邮箱重置密码
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                无法用海外手机号登录
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;">
                                无法用Google账号登录
                            </a>
                        </li>
                    </ul>
                </div>
                <input class="btn_base btn_sign_in" type="submit" value="登录"/>
            </form>
            <div class="more_sign">
                <h6>
                    社交账号登录
                </h6>
                <ul>
                    <li>
                        <a class="weibo" href="#" target="_blank">
                            <i class="iconfont icon-sina">
                            </i>
                        </a>
                    </li>
                    <li>
                        <a class="weixin" href="#" target="_blank">
                            <i class="iconfont icon-weixin1">
                            </i>
                        </a>
                    </li>
                    <li>
                        <a class="qq" href="#" target="_blank">
                            <i class="iconfont icon-qq2">
                            </i>
                        </a>
                    </li>
                    <li class="more_method">
                        <a href="javascript:void(0);">
                            <i class="iconfont icon-gengduo">
                            </i>
                        </a>
                    </li>
                    <li class="hide_method hide">
                        <a class="git" href="#" target="_blank">
                            <i class="iconfont icon-Git">
                            </i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop