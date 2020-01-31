/**
 * Created by wang on 14-9-22.
 */
$(function(){
   $(".delete").click(function(){
       var th=$(this);
       showDialog("确定要删除该商品？",true,function(){
           $.ajax({type: "get",url: "",data: "",success: function(msg){
               if(1/*删除条件*/){
                   th.parent().parent().remove();
               }
           }});
       })
   });
});