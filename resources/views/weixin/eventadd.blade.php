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
<form action="doadd" method="post" enctype="multipart/form-data">
    <div>
        <div id="_div">
        <b>素材选择</b>
        <select name="type" id="sel">
            <option value="text">文本</option>
            <option value="img">图片</option>
            <option value="video">视频</option>
            <option value="audio">语音</option>
            <option value="music">音乐</option>
            <option value="news">图文</option>
        </select><br/>
        <div class="text">
            <textarea name="content" cols="30" rows="10"></textarea>
        </div>
        {{--<div class="img audio video music" style="display: none">--}}
            {{--<input type="file" name="file">--}}
        {{--</div>--}}
        {{--<div class="news" style="display: none">--}}
            {{--请输入标题:<input type="text" name="title"></br>--}}
            {{--描述: <textarea name="content" id="" cols="30" rows="10"></textarea></br>--}}
            {{--图片: <input type="file" name="file"></br>--}}
            {{--链接:<input type="text" name="linkurl"></br>--}}
        {{--</div>--}}
    </div>
        <input type="submit" value="提交" class="weui-btn weui-btn_mini weui-btn_warn">
    </div>
</form>
</body>
<script src="{{url('js/jquery.js')}}">
</script>
<script>
    $(function () {
        $('#sel').change(function () {
            var value=$(this).val();
            // console.log(value);
            if(value=='text'){
                $('.text').remove();
                $('.video').remove();
                $('.audio').remove();
                $('.music').remove();
                $('.img').remove();
                $("#_div").append("<div class=\"text\">\n" +
                    "            <textarea name=\"text\" id=\"\" cols=\"30\" rows=\"10\"></textarea>\n" +
                    "        </div>"
                );
            }
            if(value=='news') {
                    $("#_div").append("<div  class=\"news\">\n" +
                        "            <p>标题<input type=\"text\" name=\"title\"></p>\n" +
                        "            <p>简介<input type=\"text\" name=\"content\"></p>\n" +
                        "            <p>图片<input type=\"file\" name=\"file\"></p>\n" +
                        "            <p>网址<input type=\"text\" name=\"linkurl\"></p>\n" +
                        "        </div>"
                    )
                $('.text').remove();
                $('.video').remove();
                $('.audio').remove();
                $('.music').remove();
                $('.img').remove();
            }else if(value=='img'){
                $("#_div").append("<div class=\"img\">\n" +
                    "            <input type=\"file\"  name=\"file\">\n" +
                    "        </div>")
                $('.news').remove();
                $('.text').remove();
                $('.video').remove();
                $('.audio').remove();
                $('.music').remove();
            }else if(value=='video'){
                $('.dd').append("<div class=\"video\">\n" +
                    "            <input type=\"file\"  name=\"file\">\n" +
                    "        </div>");
                $('.news').remove();
                $('.text').remove();
                $('.audio').remove();
                $('.img').remove();
                $('.music').remove();
            }else if(value=='audio'){
                $('.dd').append("<div class=\"audio\">\n" +
                    "            <input type=\"file\"  name=\"file\">\n" +
                    "        </div>");
                    $('.news').remove();
                    $('.text').remove();
                    $('.video').remove();
                    $('.music').remove();
                    $('.img').remove();
            }else if(value=='music'){
                $('.dd').append("<div class=\"music\">\n" +
                    "            <input type=\"file\"  name=\"file\">\n" +
                    "        </div>");
                $('.news').remove();
                $('.text').remove();
                $('.video').remove();
                $('.audio').remove();
                $('.img').remove();
            }
        })
    })
</script>
</html>