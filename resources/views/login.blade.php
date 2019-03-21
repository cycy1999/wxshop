@extends('include')
@section('content')
    <link href="css/login.css" rel="stylesheet" type="text/css" />
    <link href="css/vccode.css" rel="stylesheet" type="text/css" />
    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">登录</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="home-icon"></i></a>
</div>

<div class="wrapper">
    <div class="registerCon">
        <div class="binSuccess5">
            <ul>
                <li class="accAndPwd">
                    <dl>
                        <div class="txtAccount">
                            <input id="txtAccount" type="text" placeholder="请输入您的手机号码/邮箱" name="admin_tel"><i></i>
                        </div>
                        <cite class="passport_set" style="display: none"></cite>
                    </dl>
                    <dl>
                            <input id="txtPassword" type="password" placeholder="密码" value="" maxlength="20"  name="admin_pwd"/><b></b>
                    </dl>
                    <dl>
                        <input id="txtCode" type="text" placeholder="'请输入验证码" value="" maxlength="20"  name="code"/><b></b>
                        <img src="{{url('/verify/create')}}" id="img">
                    </dl>
                </li>
            </ul>
            <a id="btnLogin" href="javascript:;" class="orangeBtn loginBtn">登录</a>
        </div>
        <div class="forget">
            <a href="https://m.1yyg.com/v44/passport/FindPassword.do">忘记密码？</a><b></b><a href="{{url('register')}}">新用户注册</a>
        </div>
    </div>
    <div class="oter_operation gray9" style="display: none;">
        
        <p>登录666潮人购账号后，可在微信进行以下操作：</p>
        1、查看您的潮购记录、获得商品信息、余额等<br />
        2、随时掌握最新晒单、最新揭晓动态信息
    </div>
</div>
@endsection
<script src="{{url('js/jquery-1.8.3.min.js')}}"></script>
<script>
    $(function(){
        layui.use('layer',function () {
            $('#btnLogin').click(function () {
                var admin_tel=$('#txtAccount').val();
                // console.log(admin_tel);
                var admin_pwd=$("#txtPassword").val();
                // console.log(admin_pwd);
                var _token=$("#_token").val();
                var _code=$('#txtCode').val();

                if(admin_tel==''){
                    layer.msg('手机号码不能为空');
                }else{
                    var reg=/^1(3[0-9]|4[57]|5[0-35-9]|8[0-9]|7[06-8])\d{8}$/;
                    if(!reg.test(admin_tel)){
                        layer.msg('手机号必须是十一位纯数字');
                    }else if(admin_pwd==''){
                        layer.msg('密码不能为空');
                    }else{
                        var reg=/^[0-9a-zA-Z]{6,16}$/;
                        if(!reg.test(admin_pwd)) {
                            layer.msg('密码由数字字母 六到十六位组成');
                        }
                    }
                    if(_code==''){
                        layer.msg('验证码不能为空');
                    }
                }
                $.post(
                    "logindo",
                    {admin_tel: admin_tel,admin_pwd: admin_pwd,_token: _token,_code:_code},
                    function(res){
                        if(res==1){
                            layer.msg('添加成功');
                            location.href="shop/cart";
                        }
                    }
                )

            })
            //点击验证码
            $('#img').click(function () {
                $(this).attr('src',"{{url('/verify/create')}}"+"?"+Math.random())
            })
        })
    })
</script>
