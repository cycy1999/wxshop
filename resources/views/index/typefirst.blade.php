<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="{{url('css/weui.css')}}" rel="stylesheet">
</head>
<body>
@csrf
    <div class="weui-cells weui-cells_checkbox">
        <label class="weui-cell weui-check__label" for="s11">
            <div class="weui-cell__hd">
                <input type="radio" class="weui-check" name="news" id="s11" checked="checked" value="news"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>图文</p>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="s12">
            <div class="weui-cell__hd">
                <input type="radio" name="news" class="weui-check" id="s12" value="video"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>视频</p>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="s13">
            <div class="weui-cell__hd">
                <input type="radio" name="news" class="weui-check" id="s13" value="image"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>图片</p>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="s14">
            <div class="weui-cell__hd">
                <input type="radio" name="news" class="weui-check" id="s14" value="audio"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>语音</p>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="s15">
            <div class="weui-cell__hd">
                <input type="radio" name="news" class="weui-check" id="s15" value="text"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>文本</p>
            </div>
        </label>
        <label class="weui-cell weui-check__label" for="s16">
            <div class="weui-cell__hd">
                <input type="radio" name="news" class="weui-check" id="s16" value="music"/>
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p>音乐</p>
            </div>
        </label>
</div>
    </div>
    <input type="submit" value="提交" class="weui-btn weui-btn_mini weui-btn_warn" id="but">
    </div>
</body>
<script src="{{url('js/jquery.js')}}">
</script>
<script>
    $(function () {
            $('input[type="radio"]').each(function(){
                var type=$(this).val();
                // console.log(type);
                var type1="{{$type}}";
                if(type==type1){
                    $(this).attr('checked','checked');
                }
            })

        $(document).on('click','#but',function () {
            var _this=$(this);
            // console.log(_this);
            var type=$("input[type='radio']:checked").val();
            // console.log(type);
            var result=confirm("您选择的是"+type+"类型是否确认");
            if(result){
                $.post(
                    "dotype",
                    {type:type,_token:'{{csrf_token()}}'},
                     function (res) {
                         console.log(res);
                     }
                )
            }else{
                history.go(0);
            }

        })
    })
</script>
</html>