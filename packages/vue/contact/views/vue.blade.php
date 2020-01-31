<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="{{path('js/jquery.js')}}"></script>
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
    <select name="province" v-cloak v-model="province_id" v-on:change="get_regions()">
        <option value="0">请选择</option>
        <option v-for="province in province_list" value="@{{ province.region_id }}">@{{ province.region_name }}</option>
        @{{ province_list }}
    </select>
    <select name="city" v-cloak v-model="city_id">
        <option value="0">请选择</option>
        <option v-for="city in city_list" value="@{{ city.region_id }}">@{{ city.region_name }}</option>
        @{{ city_list }}
    </select>
    {{--<img src=""/>@{{ msg + 1 }}--}}
    {{--<input v-model="msg"/>--}}
</div>
</body>
<script type="text/javascript">
    var vm = new Vue({
        el: '#example',
        data: {
            country_id: 0,
            province_id: 0,
            province_list:[

            ],
            city_list:[

            ],
            msg:0
        },
        methods:{
            get_regions:function(){
                if(this.country_id>0) {
                    $.ajax({
                        url: '/address/region',
                        data: {parent: this.country_id},
                        type: 'get',
                        dataType: 'json',
                        success: function (regions) {
                            if (regions.regions) {
                                vm.province_list = regions.regions;
                            }
                        }
                    });
                }else{
                    vm.province_list = '';
                }
            }
        }
    })
</script>
</html>