<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{url('doupload')}}" method="post" enctype="multipart/form-data">
    @csrf
        {{--标题:<input type="text"><br/>--}}

        {{--描述:<textarea></textarea><br/>--}}

        图片:<input type="file" name="picture"><br/>

        {{--链接:<input type="text"><br/>--}}

            <input type="submit" value="提交">
</form>
</body>
</html>