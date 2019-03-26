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
    <input type="hidden" id="id" value="{{$addressInfo->address_id}}">
    收货姓名:<input type="text" name="address_name" value="{{$addressInfo->address_name}}"><br/>
    收货手机号:<input type="text" name="address_tel" value="{{$addressInfo->address_tel}}"><br/>
    收货地址:<input type="text" name="address_detail" value="{{$addressInfo->address_detail}}"><br/>
    <input type="button" value="提交" id="addupd">
</body>
</html>
<script src="{{url('js/jquery.js')}}"></script>
<script>
    $(document).on('click','#addupd',function () {
        var address_id=$('#id').val();
        // console.log(address_id);
        var address_name=$("[name='address_name']").val();
        // console.log(address_name);
        var address_tel=$("[name='address_tel']").val();
        var address_detail=$("[name='address_detail']").val();

        $.get(
            "/addressupd",
            {address_id:address_id,address_name: address_name,address_tel: address_tel,address_detail: address_detail},
            function (res) {
                if(res==1){
                    location.href="/address";
                }
            }
        )
    })
</script>