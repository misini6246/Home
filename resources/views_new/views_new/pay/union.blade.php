<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form id="form" action="https://unionpaysecure.com/api/Pay.action" method="post">
    @foreach($pay_arr as $k=>$v)
        <input name="{{$k}}" id="{{$k}}" value="{{$v}}" type="hidden">
    @endforeach
</form>
<script type="text/javascript">
    document.getElementById("form").submit();
</script>
</body>
</html>