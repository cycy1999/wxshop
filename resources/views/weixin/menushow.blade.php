<html>
<head>
    <meta charset="UTF-8">
    <title>菜单列表</title>
    <link rel="stylesheet" href="{{url('css/weui.css')}}">
</head>
<body>
@foreach($data as $value)
    @if($value->pid==4)
        <div class="weui-cell menu" menuid="{{$value->m_id}}">
            <div class="weui-cell__bd">
                <p>一级菜单</p>
            </div>
            <div class="weui-cell__ft">{{$value->name}}</div>
            <div class="weui-cell__ft" style="margin-right: 30%">{{$value->type}}</div>
            <div class="weui-cell__ft sub_menu">
                <a href="/admin/upmenu/{{$value->m_id}}" class="weui-btn weui-btn_mini weui-btn_primary">修改</a>
                @if($value['status']==1)
                    <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_warn" id="forbidden" mid="{{$value->m_id}}">禁用</a>
                @else
                    <a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_warn" id="forbidden" mid="{{$value->m_id}}">启用</a>
            </div>
                @endif
        </div>
    @endif
@endforeach

</body>
</html>
<script src="{{url('js/jquery.js')}}"></script>
<script>
    $(document).ready(function(){
        $(".menu").each(function(){
            var menuid =  $(this).attr('menuid');
            // console.log(menuid);
            var that = $(this);
            $.ajax({
                type:"post",
                url:'getmenu',
                data:{m_id:menuid,_token:'{{csrf_token()}}'},
                dataType:'json',
                success:function(res){
                    var str = '';
                    for(var i in res){
                        str += '<div class="weui-cell" style="margin-left: 10%"><div class="weui-cell_bd"><p>二级菜单</p></div><div class="weui-cell_ft">'+res[i]['name']+'</div><div calss="weui_ft">'+res[i]['type']+'</div></div>';
                    }

                    // console.log(res);
                    that.after(str);
                }
            })

        })
        //做禁用
       $(document).on('click','#forbidden',function () {
           var _this=$(this);
           // console.log(_this);
           var m_id=_this.attr('mid');
           // console.log(m_id);
           $.get(
               "menudel",
               {m_id:m_id},
               function (res) {
                   // console.log(res);
               }
           )
       })
    })

</script>

