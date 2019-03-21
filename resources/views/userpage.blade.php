@extends('include')
@section('content')
    <link href="{{url('css/member.css')}}" rel="stylesheet" type="text/css" />
    <div class="welcome" style="display: none">
        <p>Hi，等你好久了！</p>
        <a href="" class="orange">登录</a>
        <a href="" class="orange">注册</a>
    </div>

    <div class="welcome">
        <i class="set"></i>
        <div class="login-img clearfix">
            <ul>
                <li><img src="{{url('images/goods2.jpg')}}" alt=""></li>
                <li class="name">
                    <h3>兰兰</h3>
                    <p>ID：10030053</p>
                </li>
                <li class="next fr"><s></s></li>
            </ul>
        </div>
        <div class="chao-money">
            <ul class="clearfix">

                <li class="br">
                    <p>余额（元）</p>
                    <span>0</span>
                </li>
                <li>
                    <a href="" class="recharge">去充值</a>
                </li>
            </ul>
        </div>

    </div>
    <!--获得的商品-->
    <div class="sub_nav marginB person-page-menu">
        <a href="{{url('user/buyrecord')}}"><s class="m_s1"></s>潮购记录<i></i></a>
        <a href="/v44/member/orderlist.do"><s class="m_s2"></s>获得的商品<i></i></a>
        <a href="/v44/member/postlist.do"><s class="m_s3"></s>我的晒单<i></i></a>
        <a href="/v44/member/mywallet.do"><s class="m_s4"></s>我的钱包<i></i></a>
        <a href="/v44/member/mywallet.do"><s class="m_s5"></s>收货地址<i></i></a>
        <a href="/v44/help/help.do" class="mt10"><s class="m_s6"></s>帮助与反馈<i></i></a>
        <a href="/v44/help/help.do"><s class="m_s7"></s>二维码分享<i></i></a>
        <p class="colorbbb">客服热线：400-666-2110  (工作时间9:00-17:00)</p>
    </div>
    <div class="footer clearfix">
        <ul>
            <li class="f_home"><a href="{{url('/')}}" ><i></i>潮购</a></li>
            <li class="f_single"><a href="{{url('user/willshare')}}" ><i></i>晒单</a></li>
            <li class="f_car"><a id="btnCart" href="{{url('shop/cart')}}" ><i></i>购物车</a></li>
            <li class="f_personal"><a href="{{url('user/page')}}" class="hover"><i></i>我的潮购</a></li>
        </ul>
    </div>
    @endsection
@section('my-js')
    function goClick(obj, href) {
    $(obj).empty();
    location.href = href;
    }
    if (navigator.userAgent.toLowerCase().match(/MicroMessenger/i) != "micromessenger") {
    $(".m-block-header").show();
    }
@endsection
    <script src="{{url('js/jquery190_1.js')}}" language="javascript" type="text/javascript"></script>
    <script src="{{url('js/jquery-1.8.3.min.js')}}"></script>
