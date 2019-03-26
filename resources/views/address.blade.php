@extends('include')
@section('content')
    <link rel="stylesheet" href="{{url('css/address.css')}}">
    <link rel="stylesheet" href="{{url('css/sm.css')}}">
    <link href="{{url('css/comm.css')}}" rel="stylesheet" type="text/css" />

    <!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">地址管理</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="{{url('/saveaddress')}}" class="m-index-icon">添加</a>
</div>
<div class="addr-wrapp">
    @foreach($addressInfo as $v)
     @if($v['is_default']==1)
            <div class="addr-list">
                 <ul>
                    <li class="clearfix">
                        <span class="fl">{{$v->address_name}}</span>
                        <span class="fr">{{$v->address_tel}}</span>
                    </li>
                    <li>
                        <p>{{$v->address_detail}}</p>
                    </li>
                    <li class="a-set" address_id="{{$v->address_id}}">
                        <s class="z-set" style="margin-top: 6px;"></s>
                        <span class="_span">设为默认</span>
                        <div class="fr">
                            <span class="edit"><a href="{{url('/addressedit')}}?address_id={{$v->address_id}}">编辑</a></span>
                            <span class="remove">删除</span>
                        </div>
                    </li>
                </ul>
            </div>
      @else
            <div class="addr-list">
                <ul>
                    <li class="clearfix">
                        <span class="fl">{{$v->address_name}}</span>
                        <span class="fr">{{$v->address_tel}}</span>
                    </li>
                    <li>
                        <p>{{$v->address_detail}}</p>
                    </li>
                    <li class="a-set" address_id="{{$v->address_id}}">
                        <span class="_span">设为默认</span>
                        <div class="fr">
                            <span class="edit"><a href="{{url('/addressedit')}}?address_id={{$v->address_id}}">编辑</a></span>
                            <span class="remove">删除</span>
                        </div>
                    </li>
                </ul>
            </div>
       @endif
    @endforeach
</div>
@endsection
<script src="{{url('js/zepto.js')}}" charset="utf-8"></script>
<script src="{{url('js/sm.js')}}"></script>
<script src="{{url('js/sm-extend.js')}}"></script>
<!-- 单选 -->
<script src="{{url('js/jquery-1.8.3.min.js')}}"></script>
<script>
    var $$=jQuery.noConflict();
    $$(document).ready(function(){
            // jquery相关代码
            $$('.addr-list .a-set s').toggle(
            function(){
                if($$(this).hasClass('z-set')){
                    
                }else{
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }   
            },
            function(){
                if($$(this).hasClass('z-defalt')){
                    $$(this).removeClass('z-defalt').addClass('z-set');
                    $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                }
                
            }
        )

    });
    
</script>
<script>
    $(function () {
        layui.use('layer',function () {
        //点击默认
        $(document).on('click','._span',function () {
            var address_id=$(this).parent('li').attr('address_id');
            // console.log(address_id);
            $.get(
                "default",
                {address_id:address_id},
                function (res) {
                    if(res==1){
                        history.go(0);
                    }
                }
            )
        })
        //点击删除
        $(document).on('click','.remove',function () {
            var address_id=$(this).parents('li').attr('address_id');
            $.get(
                "/addressdel",
                {address_id:address_id},
                function (res) {
                    if(res==1){
                        layer.msg('删除成功');
                        history.go(0);
                    }
                }
            )
        })
        })
    })
</script>
