(function(a)
{
    a(document).ready(function(){
        var b=0;var c='';
        var d;
        a('#product_name').bind('keyup',e);
        a('#product_name').bind('keydown',g);
        if(document.activeElement.Id=='product_name'){
            a('#product_name').trigger("keyup")
        };
        a('#ss_btn').click(function(){
            /*王成*/
            //if($('#product_name').val()!=''){
                location.href='/ppzq_list?ppzq_key='+$('#product_name').val();
            //}
            /*end*/
        });
        a('#list>li').live('mouseover',function(){
            var h=a(this).prevAll().length;b=h+1;
            a(this).css('cursor','pointer').addClass('active').siblings('li').removeClass('active')
        });
        a('#list>li').live('click',function(){
            a('#product_name').val(a(this).text());
            location.href='/ppzq_list?ppzq_key='+a('#product_name').val();
        });
        a('#product_name').blur(function(){
            a('#list_wrap').fadeOut();
            var h=a(this).val();if(h==''){
                a(this).val('')
            }
        });
        a('#product_name').focus(function(){
            var h=a(this).val();
            if(h==''){
                a(this).val('')
            };
            var i=a(this).val();
            if(i!=''){
                b=0;
                if(d)d.abort();
                if(i.length>=1){
                    d=a.getJSON('/ppzq_key',{ppzq_key:i,step:'product_name'},f)
                }
            }
        });
        function e(h){
            if(h.keyCode!=40&&h.keyCode!=38){
                c=a.trim(a(this).val())
            };
            if(c==''||h.which==27){
                a('#list').empty();a('#list_wrap').hide()
            };
            if((h.which>=65&&h.which<=90)||h.which==8||h.which==46||h.which==32||h.which==13||h.which==undefined){
                b=0;
                if(d)d.abort();
                if(c.length>=1){
                    d=a.getJSON('/ppzq_key',{ppzq_key:c,step:'product_name'},f)
                }
            }
        };
        function f(h){
            if(h==false){
                a('#list').empty();
                a('#list_wrap').hide()
            }else{
                var i='';
                for(var j=0;j<h.length;j++){
                    i+='<li>'+h[j]+'</li>'
                };
                a('#list').html(i);
                a('#list_wrap').show()
            }
        };
        function g(h){
            switch(h.which){
                case 38:
                    var i='';
                    b=(b==0?a("#list li").length:b-1);
                    if(b==0){
                        i=c;a("#list li").removeClass("active")
                    }else{
                        a("#list li").removeClass("active");
                        a("#list li").eq(b-1).addClass("active");
                        i=a("#list li").eq(b-1).text()
                    };
                    a("#suggest").val(i);
                    break;
                case 40:
                    var i="";
                    if(b==a("#list li").length){
                        i=c;a("#list li").removeClass("active")
                    }else{
                        a("#list li").removeClass("active");
                        i=a("#list li").eq(b).text();
                        a("#list li").eq(b).addClass("active")
                    };
                    b=(b==a("#list li").length?0:b+1);
                    a("#suggest").val(i);
                    break;
                case 13:
                    b=0;
                    if(a('#list>li.active').length!=0){
                        a('#product_name').val(a('#list>li.active').html())
                    };
                    a('#list').empty();
                    a('#list_wrap').hide();
                    a('#product_name').unbind('keyup',e);
                    location.href='/ppzq_list?ppzq_key='+a('#product_name').val();break
            }
        }
    })
})(jQuery);

