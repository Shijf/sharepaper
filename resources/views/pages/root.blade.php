@extends('layouts.app')
@section('title', '领取纸巾')
@section("css")
    <style>
        .left_item {
            width: 30%;
            height: 100%;
            display: inline-block;
            box-sizing: border-box;
            vertical-align: middle;
            border-radius:50%; overflow:hidden;
        }

        .right_item {
            width: 40%;
            height: 100%;
            display: inline-block;
            box-sizing: border-box;
            vertical-align: middle;
        }

        .item_img{
            width: 40px;
            height: 40px;
        }

        li {
            /*vertical-align: middle;*/
            box-sizing: border-box;
            display: block;
            height: 18px;
        }
        /**
顶部滚动文字
 */
        .marquee {
            width: auto;
            margin: 0 auto;
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
            animation: marquee 15s linear infinite;
        }

        .marquee:hover {
            animation-play-state: paused
        }

        /* Make it move */
        @keyframes marquee {
            0%   { text-indent: 27.5em }
            100% { text-indent: -105em }
        }

        /* Make it pretty */
        .microsoft {
            padding-left: 1.5em;
            position: relative;
            font: 16px 'Segoe UI', Tahoma, Helvetica, Sans-Serif;
        }

        /* ::before was :before before ::before was ::before - kthx */
        .microsoft:before, .microsoft::before {
            z-index: 2;
            content: '';
            position: absolute;
            top: -1em; left: -1em;
            width: .5em; height: .5em;
            box-shadow: 1.0em 1.25em 0 #F65314,
            1.6em 1.25em 0 #7CBB00,
            1.0em 1.85em 0 #00A1F1,
            1.6em 1.85em 0 #FFBB00;
        }

        .microsoft:after, .microsoft::after {
            z-index: 1;
            content: '';
            position: absolute;
            top: 0; left: 0;
            width: 2em; height: 2em;
            background-image: linear-gradient(90deg, white 70%, rgba(255,255,255,0));
        }
        .swiper-container {
            width: 100%;
        }

        .swiper-container img {
            display: block;
            width: 100%;
        }
    </style>
@endsection
{{--内容页--}}
@section('content')

    <div id="getpaper" class="weui-tab__bd-item weui-tab__bd-item--active" >
        <p class="microsoft marquee">火爆招商中，期待您的加入 ……火爆招商中，期待您的加入 ……火爆招商中，期待您的加入 ……火爆招商中，期待您的加入 ……火爆招商中，期待您的加入 ……火爆招商中，期待您的加入 ……</p>
        {{--广告链接--}}
        <div class="swiper-container">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper" >
                <!-- Slides -->
                <div class="swiper-slide"><img src="./images/swiper-1.jpg" name="123" onclick="ad(this)"  style="border-radius:1%;"/></div>
                <div class="swiper-slide"><img src="./images/swiper-2.jpg" name="456" onclick="ad(this)"  style="border-radius:1%;"/></div>
                <div class="swiper-slide"><img src="./images/swiper-3.jpg" name="789" onclick="ad(this)"  style="border-radius:1%;"/></div>

            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>
        </div>
        {{--内容--}}
        @Auth
        <div class='demos-content-padded'>
                <li>
                    <img class=" left_item item_img"  src="{{Auth::user()->headimgurl}}" alt=""/>
                    <span class="right_item" style="font-size: 15px">欢迎您，第{{Auth::user()->id}}位用户</span>
                </li>
                <br>
            @if(\Illuminate\Support\Facades\Cache::has('limit_daily'.Auth::user()->id))
            <div class="weui-msg" >
                <div class="weui-msg__icon-area"><i class="weui-icon-waiting weui-icon_msg"></i></div>
                <div class="weui-msg__text-area">
                    <h2 class="weui-msg__title">今日已领取，明日再来哦😀</h2>
                    <p class="weui-msg__desc">感谢您的关注与支持</p>
                </div>
            </div>
            @else
                <div class="weui-msg" hidden="hidden" id="finish_getpaper">
                    <div class="weui-msg__icon-area"><i class="weui-icon-waiting weui-icon_msg"></i></div>
                    <div class="weui-msg__text-area">
                        <h2 class="weui-msg__title">今日已领取，明日再来哦😀</h2>
                        <p class="weui-msg__desc">感谢您的关注与支持</p>
                    </div>
                </div>
                <form action="#" class="weui-cells weui-cells_form" id="get">
                    <div class="weui-cell" id="before_scan">
                        <div class="weui-cell__hd"><label class="weui-label">获取机器码：</label></div>
                        <div class="weui-cell__bd">
                            <input class="weui-input"  id="code" type="number" pattern="^[1-9]//d*$" name="code" placeholder="请输入机器号(数字)">
                            {{--<a href="javascript:;" class="weui-btn weui-btn_primary " id="scan">1.点击扫描二维码</a>--}}

                        </div>
                    </div>
                    {{--扫码后出现--}}
                    <div class="weui-cell weui-cell_switch" hidden="hidden" id="arter_scan">

                        <span class="weui-cell__bd">阅读并同意：<a href="#" id="agree" class="open-popup" style="color: #00A1F1" data-target="#full">&nbsp;《相关条款》</a></span>
                        {{--捕获开关状态--}}
                        <input hidden="hidden" id="btn" name="btn1" type="radio" value="off" checked="checked"  />
                        <div class="weui-cell__ft">
                            <label for="switchCP" class="weui-switch-cp">
                                <input id="switchCP" class="weui-switch-cp__input" type="checkbox" name="agree">
                                <div id="switch_agree" class="weui-switch-cp__box"></div>
                            </label>
                        </div>
                    </div>
                    <div class="weui-cell weui-cell_switch" hidden="hidden" id="arter_scan">
                        <div class="weui-cell__hd"><label class="weui-label">领取纸巾咯：</label></div>
                        <a href="javascript:;" class="weui-btn weui-btn_disabled weui-btn_warn " id="submit">&nbsp;&nbsp;&nbsp;<span id="subinfo">2.点击领取纸巾哦</span>&nbsp;&nbsp;</a>
                        {{--<span style="display: block">&nbsp;</span>--}}
                    </div>

                </form>
            @endif
        </div>
            @endauth
    </div>
    {{--用户页--}}


    {{--协议--}}

    <div id="full" class='weui-popup__container'>
        <div class="weui-popup__overlay"></div>
        <div class="weui-popup__modal">
            <header class='demos-header'>
                <h2 class="demos-second-title">关于 jQuery WeUI</h2>
                <p class="demos-sub-title">By 言川 @2016/03/30</p>
            </header>
            <article class="weui-article">
                <h1>大标题</h1>
                <section>
                    <h2 class="title">章标题</h2>
                    <section>
                        <h3>1.1 节标题</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                            consequat.
                        </p>
                        <p>
                            <img src="./images/pic_article.png" alt="">
                            <img src="./images/pic_article.png" alt="">
                        </p>
                    </section>
                    <section>
                        <h3>1.2 节标题</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </section>
                    <section class="weui-btn weui-btn_primary close-popup"> 关闭</section>
                </section>
            </article>

        </div>
    </div>
@endsection
{{--底部导航--}}
@section('navbar')
    {{--<p class="weui-footer__text">Copyright © 2017-{{date("Y")}} 正定友仁商贸有限公司</p>--}}
@endsection

@section('js')
    <script src="{{asset('lib/jquery-2.1.4.js')}}"></script>

    <script src="{{asset('lib/fastclick.js')}}"></script>
    <script>
        $(function() {
            FastClick.attach(document.body);
        });
    </script>
    <script src="{{asset('js/jquery-weui.js')}}"></script>
    <script src="{{asset('js/swiper.js')}}"></script>
    <script src="{{asset('layui/layer.js')}}"></script>
    <script>
        $(".swiper-container").swiper({
            loop: true,
            autoplay: 3000
        });
    </script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" charset="utf-8">

        wx.config ({!! $config !!});

        //
        $("#scan").bind('click',function () {
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    $("#code").val(res.resultStr);
                    $("#scan").text("1.已获得机器码");
                    $("#scan").addClass('weui-btn_disabled');
                    $("#scan").removeClass('weui-btn_primary');
                    $("#scan").addClass('weui-btn_default');
                    $("#sacn").attr("disabled");
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    //触发协议
                    setTimeout($.alert("同意协议后，即可领取","温馨提示",function () {
                        $("#agree").trigger("click");
                    }),3000);
                    $("#scan").unbind("click");
                }
            });
        });

    </script>
    <script>
        /**
         * 广告链接
         */
        function ad() {
            var id =  layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                shadeClose: true,
                skin: 'yourclass',
                content: '这是一个广告',
                time:5000 ,
            });
            //手动关闭
            // setTimeout(layer.close(id),5000);
        }

        /**判断是否同意协议
         *
         */

        $(function () {
            $("#switchCP").bind("click", function () {

                if($("#btn").val()=="off"){

                    $("#btn").val("on");
                    $("#subinfo").text('2.点击领取纸巾哦');

                    $("#submit").removeClass('weui-btn_disabled');
                    $("#submit").removeClass('weui-btn_warn');
                    $("#submit").addClass('weui-btn_primary');

                }else{

                    $("#btn").val("off");
                    $("#subinfo").text('2.请您先同意协议');
                    $("#submit").addClass('weui-btn_disabled');
                    $("#submit").addClass('weui-btn_warn');
                }
            });
            /**
             * 提交检查
             */
            $("#submit").bind("click",function () {
                if ($("#submit").hasClass('weui-btn_disabled')) {
                    if ($("#btn").val()=="off"){
                        $.alert('您未同意协议，无法领取纸巾');
                    }
                }else {
                    alert($("#code").val());
                    if($("#btn").val()=="on" && $("#code").val()){
                        $("#submit").addClass('weui-btn_disabled');
                        let code = $("#code").val();
                        $.showLoading("请稍等");
                        $.get('getpaper',{echostr:code,user_id:{{Auth::user()->id}}},function (message) {

                            $.hideLoading();

                            setTimeout(function() {
                                if (message.code != 0) {

                                    $.toast("出纸成功", function() {
                                        console.log(message);
                                        console.log('请求成功');
                                        $("#get").hide();
                                        $("#finish_getpaper").show();

                                    });
                                }else {
                                    console.log(message);
                                    $.alert(message.msg, "forbidden");

                                    $("#submit").removeClass('weui-btn_disabled');

                                }
                            }, 1)
                        });
                    }else {
                        $.alert("请点击按钮扫描二维码", "温馨提示", function() {
                            //点击确认后的回调函数

                        });
                    }
                }
            });

            $("#get_show").bind("click",function () {
                $.alert("开发中，请稍等");
            });
        });
    </script>
@endsection
