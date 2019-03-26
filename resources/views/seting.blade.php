<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        li{
            list-style: none;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
<ul>
    <li><a href="{{url('user/edituser')}}">个人资料</a></li>
    <li><a href="{{url('user/safeset')}}">安全设置</a></li>
</ul>
</body>
</html>