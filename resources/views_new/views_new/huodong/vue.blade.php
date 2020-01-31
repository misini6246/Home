<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="{{path('js/jquery.min.js')}}"></script>
    <script src="{{path('js/vue.js')}}"></script>
</head>
<style>
    [v-cloak] {
        display: none;
    }
</style>
<body>
<div id="example">
    <select v-model="country_id" name="country" v-on:change="get_regions()">
        <option value="0">请选择</option>
        <option value="1">中国</option>
    </select>
    <select name="province" v-cloak>
        <option v-for="province in province_list" value="@{{ province.region_id }}">@{{ province.region_name }}</option>
        @{{ province_list }}
    </select>
    <img src=""/>@{{ msg + 1 }}
    <input v-model="msg"/>
</div>
</body>
<script type="text/javascript">
    var vm = new Vue({
        el: '#example',
        data: {
            country_id: 0,
            province_list:[

            ],
            msg:0
        },
        methods:{
            get_regions:function(){
                $.ajax({
                    url:'/address/region',
                    data:{parent:this.country_id},
                    type:'get',
                    dataType:'json',
                    success:function(regions){
                        if(regions.regions) {
                            vm.province_list = regions.regions;
                        }
                    }
                });
            }
        }
    })
</script>
</html>