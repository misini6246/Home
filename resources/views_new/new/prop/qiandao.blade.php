
{{-- 签到的弹窗 --}}
<style>
    #qd_prop{
        display:none;
        border: none;
        
    }
    #qd_prop img{
        -webkit-transform: none;
        -moz-transform: none;
        -ms-transform: none;
        transform: none;
        cursor: pointer;
    }
    #qd_prop #close_qd{
        float: right;
    }
    #qd_prop .qd_content{
        margin-top:35px; 
    }
    .layui-layer{
        background-color:rgba(0, 0, 0, 0);
        box-shadow: none;
    }
</style>
<div id="qd_prop">
    <img id="close_qd" src="{{path('/images/prop/qiandao_close.png')}}">
    <a target="_blank" href="jifen/qiandao"><img class="qd_content" src="{{path('/images/prop/qiandao_content.png')}}"></a>
</div>
<script>
    // 弹窗——签到
    var qd_prop=layer.open({
        type:1,
        title:false,
        resize:false,
        scrollbar:false,
        area: '620px',
        shade: [0.8, '#000'],
        closeBtn: 0,
        content:$('#qd_prop')
    });
    //点击弹窗关闭按钮
    $('body').on('click','#close_qd',function(){
        layer.close(qd_prop);
    });
</script>
