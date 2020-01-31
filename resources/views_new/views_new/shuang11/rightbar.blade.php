<style type="text/css">

    .time-item2{width: 600px;height: 72px;line-height: 72px;margin: 14px 0 3px 500px;float: left;}

    .time-item2 strong{font-size: 42px;color: #e40d0d;width: 72px;height: 72px;display: block;
        float: left;text-align: center;margin-right:56px;font-family: "Microsoft YaHei";line-height: 72px;}
    .toolbar-wrap{position: fixed;top: 0px;right: 0px;z-index: 9990;width: 35px;height: 100%;}
    .toolbar {position: absolute;right: 0px;top: 0px;width: 29px;height: 100%;border-right: 6px solid #7A6E6E;}
    .toolbar-panels {position: absolute;left: 0px;top: 0px;width: 278px; height: 100%;z-index: 2;background: #cc074e none repeat scroll 0% 0%;overflow-y: auto;overflow-x: hidden;}
    .toolbar-panel { width: 278px;height: 100%;position: absolute;background: #cc074e none repeat scroll 0% 0%;overflow-y: auto;overflow-x: hidden;}
    .shuang11-disk{position: absolute;bottom: -135px;right: 36px;width: 54px;height: 135px;}
    .quick_links{position:absolute;top:55%;left:0;margin-top:-190px;*margin-top:-220px; background:#262626;z-index:2;width:36px;}
    .top-11{position:absolute;top:0;right:0; background:#684cff;z-index:2;width:36px;height:26%;}
    .shuang11-tip{position: absolute;top:0;right: 0;width: 80px;cursor: pointer;height: 100%;}
    .shuang11-tip img{height: 185px;width: 80px;position: absolute;left: 0;bottom: 0;}
    .top-11-tab{position:absolute;top:0;right:0; background:#262626;z-index:2;width:36px;height: 26%;}
    .shuang11-tip-tab{position: absolute;top:0;right: 0;width: 36px;height: 100%;cursor: pointer;background: #843cff;}
    .shuang11-tip-tab img{height: 160px;width: 36px;position: absolute;left: 0;bottom: 0;}
</style>
<div class="top-11 shuang11"  >

    <div  id="shuang11-tip" class="shuang11-tip"  >
        <div style="width:80px;height:60%;background:#7b41ff;"></div>
        <p style="background-color:#fff"><img src="{{get_img_path('images/shuang11-index01.png')}}" alt="" /></p>


    </div>


</div>


<div class="top-11-tab shuang11" style="display:none;">


    <div  id="shuang11-tip-tab" class="shuang11-tip-tab"  >
        <img src="{{get_img_path('images/shuang11-index06.png')}}" alt="" />

    </div>

</div>
<script>
    $(".top-11").click(function(){

        $(this).hide();

        $(".toolbar-wrap").animate({right:"278px"});
        $(".top-11-tab").show();
    })

    $(".top-11-tab,#title").click(function(){


        $(".toolbar-wrap").animate({right:"0px"});

        setTimeout(function () {
            $(".top-11").show().next().hide();

        }, 500);



    })

</script>