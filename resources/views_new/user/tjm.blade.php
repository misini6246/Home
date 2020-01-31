<div id="user_tjm" style="display: inline-block;">
    @if($user_tjm)
        <div class="title" style="display: inline-block;">
            <img src="http://images.hezongyy.com/images/user/dian_03.png?110112"/>
            <span class="bt">您的专属邀请码</span>
        </div>
        <style type="text/css">
            .sctjm-box .tjm-code {
                display: inline-block;
                color: #2391FF;
                font-size: 18px;
                margin-left: 30px;
                font-weight: bold;
                width: 100px;
                height: 100%;
                position: relative;
                top: 5px;
            }
        </style>
        <span class="tjm-code">{{$user_tjm->tjm}}</span>
        <style type="text/css">
            .sctjm-box .btn-fz {
                width: 100px;
                height: 20px;
                line-height: 18px;
                position: relative;
                top: 3px;
                border: 1px dashed rgba(204, 204, 204, 1);
                text-align: center;
                border-radius: 10px;
                color: #666666;
                font-size: 12px;
                display: inline-block;
                cursor: pointer;
            }
        </style>
        <div class="btn-fz" data-clipboard-action="copy" data-clipboard-target=".tjm-code" onclick="copy()">
            点击复制邀请码
        </div>
        <script type="text/javascript">
            function copy() {
                var clipboard2 = new Clipboard('.btn-fz');
                clipboard2.on('success', function (e) {
                    layer.msg('复制成功！', {icon: 1})
                });
                clipboard2.on('error', function (e) {
                    layer.msg('复制失败！请手动复制', {icon: 2})
                });
            }
        </script>
    @else
        <div class="title" style="display: inline-block;">
            <img src="http://images.hezongyy.com/images/user/dian_03.png?110112"/>
            <span class="bt">您的专属邀请码</span>
        </div>
        <style type="text/css">
            .sctjm-box .btn-sc {
                width: 88px;
                height: 38px;
                line-height: 38px;
                text-align: center;
                background: #3DBB2B;
                border-radius: 4px;
                color: #FFFFFF;
                font-size: 14px;
                display: inline-block;
                margin-left: 30px;
                cursor: pointer;
            }
        </style>
        <div class="btn-sc" onclick="generateTjm()">
            点击生成
        </div>
        <script>
            function generateTjm() {
                $.ajax({
                    url: '{{route('member.generate_tjm')}}',
                    dataType: 'json',
                    success: function (data) {
                        layer.msg(data.msg, {icon: data.error + 1})
                        if (data.error == 0) {
                            $('#user_tjm').html(data.html)
                        }
                    }
                })
            }
        </script>
    @endif
</div>
