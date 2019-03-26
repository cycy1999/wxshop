@extends('include')
@section('content')
<link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('css/login.css')}}" rel="stylesheet" type="text/css" />
<link href="{{url('css/findpwd.css')}}" rel="stylesheet" type="text/css" />

  @csrf
<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">重置密码</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="/" class="m-index-icon"><i class="m-public-icon"></i></a>
</div>


<div class="wrapper">
    <div class="registerCon">
        <ul>
            <li>
                <s class="password"></s>
                <input type="password" id="pwd" placeholder="请输入原密码" maxlength="26" />
                <span class="clear">x</span>
            </li>
            <li>
                <s class="password"></s>
                <input type="password" id="newpwd" placeholder="请输入新密码" maxlength="26" />
                <span class="clear">x</span>
            </li>
            <li><a id="findPasswordNextBtn" href="javascript:void(0);" class="orangeBtn">确认重置</a></li>
        </ul>
    </div>

</div>
@endsection
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script src="{{url('layui/layui.js')}}"></script>
<script>
    $(function () {
        layui.use('layer',function () {
            $('#pwd').blur(function () {
                var pwd=$('#pwd').val();
                if(pwd==''){
                    layer.msg('原密码不能为空');
                }else{
                    var reg=/^\w{6,12}$/;
                    if(!reg.test(pwd)){
                        layer.msg('原密码是由数字 字母 下划线六到十二位组成');
                    }
                }
            })
            $('#newpwd').blur(function () {
                var newpwd=$('#newpwd').val();
                if(newpwd==''){
                    layer.msg('新密码不能为空');
                }else{
                    var reg=/^\w{6,12}$/;
                    if(!reg.test(newpwd)){
                        layer.msg('新密码是由数字 字母 下划线六到十二位组成');
                    }
                }
            })
            $(".orangeBtn").click(function () {
                var pwd=$('#pwd').val();
                var newpwd=$('#newpwd').val();
                var _token=$("[name='_token']").val();
               $.post(
                   "updpwd",
                   {pwd:pwd,newpwd:newpwd,_token:_token},
                   function (res) {
                       if(res==2){
                           layer.msg('原密码不正确请重新输入');
                       }else if(res==3){
                           layer.msg('修改成功');
                           location.href='/login';
                       }
                   }
               )
            })
        })
    })
</script>
