@extends('include')
<link rel="stylesheet" href="{{url('css/writeaddr.css')}}">
<link rel="stylesheet" href="{{url('layui/css/layui.css')}}">
<link rel="stylesheet" href="{{url('dist/css/LArea.css')}}">
@section('content')
    <body>

    <!--触屏版内页头部-->
    <div class="m-block-header" id="div-header">
        <strong id="m-title">填写收货地址</strong>
        <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
        <a href="javascript:;" class="m-index-icon">保存</a>
    </div>
    <div class=""></div>
    <!-- <form class="layui-form" action="">
      <input type="checkbox" name="xxx" lay-skin="switch">

    </form> -->
    <form class="layui-form" action="">
        @csrf
        <div class="addrcon">
            <ul>
                <li><em>收货人</em><input type="text" placeholder="请填写真实姓名" name="address_name"></li>
                <li><em>手机号码</em><input type="number" placeholder="请输入手机号" name="address_tel"></li>
                <li><em>所在区域</em>
                    <select name="province">
                        <option>请选择所在的区域</option>
                        @foreach($topAddressInfo as $v)
                        <option value="{{$v->name}}">{{$v->name}}</option>
                        @endforeach
                    </select>
                </li>
                <li class="addr-detail"><em>详细地址</em><input type="text" placeholder="30个字以内" class="addr" name="address_detail"></li>
            </ul>
            <div class="setnormal"><span>设为默认地址</span><input type="checkbox" name="xxx" lay-skin="switch" id="_check">  </div>
        </div>
    </form>
    </div>
    </body>
@endsection

<!-- SUI mobile -->
<script src="{{url('dist/js/LArea.js')}}"></script>
<script src="{{url('dist/js/LAreaData1.js')}}"></script>
<script src="{{url('dist/js/LAreaData2.js')}}"></script>
<script src="{{url('js/jquery-1.11.2.min.js')}}"></script>
<script src="{{url('layui/layui.js')}}"></script>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form();

        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            console.log(data);
            return false;
        });
    });
    var area = new LArea();
    area.init({
        'trigger': '#demo1',//触发选择控件的文本框，同时选择完毕后name属性输出到该位置
        'valueTo':'#value1',//选择完毕后id属性输出到该位置
        'keys':{id:'id',name:'name'},//绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
        'type':1,//数据源类型
        'data':LAreaData//数据源
    });
</script>
<script>
    $(function () {
        layui.use('layer',function () {
            $('.m-index-icon').click(function () {
                var address_name=$("[name='address_name']").val();
                var address_tel=$("[name='address_tel']").val();
                var province=$("[name='province']").val();
                var address_detail=$("[name='address_detail']").val();
                var _token=$("[name='_token']").val();
                var _check=$("#_check").prop('checked');
                if(address_name==''){
                    layer.msg('收货姓名不能为空');
                    return false;
                }
                if(address_tel==''){
                    layer.msg('收货手机号不能为空');
                    return false;
                }
                if(address_detail==''){
                    layer.msg('详细地址不能为空');
                    return false;
                }
                var is_default='';
                if(_check==true){
                    is_default=1;
                }else{
                    is_default=2;
                }
                $.post(
                    "addaddress",
                    {address_name:address_name,address_tel:address_tel,province:province,address_detail:address_detail,_token:_token,is_default:is_default},
                    function (res) {
                        if(res==1){
                            layer.msg("保存成功");
                            location.href="/address";
                        }
                    }
                )
            })
        })
    })
</script>
