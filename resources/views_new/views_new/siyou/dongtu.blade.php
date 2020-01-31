<style>
    #dongtu div{
        animation: dt 1s;
        animation-iteration-count:infinite;
        animation-direction:alternate;
    }
    @keyframes dt
    {
        from {top: 150px;}
        to {top: 200px;;}
    }
    /*#dongtu div{*/
        /*top:150px;*/
        /*transition: top 2s;*/
    /*}*/
    /*#dongtu div:hover{*/
        /*top:200px;*/
    /*}*/
</style>
<div id="dongtu" style="position:relative;width: 1920px;height: 724px;background-image: url('{{path('images/sy_dt.jpg')}}')">
    <div style="position: absolute;left: 100px;top: 150px;width: 210px;height: 200px;">
        <img style="width: 237px;height: 200px;" src="{{path('images/sy_sj1.png')}}"/>
    </div>
    <div style="position: absolute;right: 100px;top: 150px;width: 210px;height: 200px;">
        <img style="width: 210px;height: 200px;" src="{{path('images/sy_sj2.png')}}"/>
    </div>
</div>