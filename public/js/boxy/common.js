/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	if ($("#check_box").attr("checked")==false) {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	}
}

//检测邮箱格式
function is_email(str){
	var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
	return reg.test(str);
}
//设为首页
function SetHomePage(obj,url){
	try{
		obj.style.behavior='url(#default#homepage)';obj.setHomePage(url);
	}catch(e){
		if(window.netscape){
			try{
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
			}catch (e){ 
				return false;  
			}
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
			prefs.setCharPref('browser.startup.homepage',url);
		}
	}
}
//加入收藏
function AddFavorite(url, title){
   try{
       window.external.addFavorite(url, title);
   }catch (e){
       try{
           window.sidebar.addPanel(title, url, "");
       }catch (e){
           return false;
       }
   }
}
/* 火狐下取本地全路径 */
function getFullPath(obj)
{
    if(obj)
    {
        //ie
        if (window.navigator.userAgent.indexOf("MSIE")>=1)
        {
            obj.select();
            return document.selection.createRange().text;
        }
        //firefox
        else if(window.navigator.userAgent.indexOf("Firefox")>=1)
        {
            if(obj.files)
            {
                return obj.files.item(0).getAsDataURL();
            }
            return obj.value;
        }
        return obj.value;
    }
}

function redirect(url) {
	location.href = url;
}

var ui = {} ;

$.extend(ui, {
	box:function(element, options){   
	}
});

$.extend(ui.box,{	
		success: function(message,closeTime,error){
			if(!closeTime){
				closeTime = 500 ;
			}
			var style = (error==1)?"html_clew_box clew_error ":"html_clew_box";
			var html   =   '<div class="" id="ui_messageBox" style="display:none;z-index:1000001">'
						   + '<div class="html_clew_box_close"><a href="javascript:void(0)" onclick="$(this).parents(\'.html_clew_box\').hide()" title="关闭">关闭</a></div>'
						   + '<div class="html_clew_box_con" id="ui_messageContent">&nbsp;</div></div>';
			var init      =  0;
			
			var showMessage = function( message ){		
				if( !init ){
					$('body').append( html );
					init = 1;
				}
				

				
				$( '#ui_messageContent' ).html( message );
				$('#ui_messageBox').attr('class',style);
				
				var v =  Boxy._viewport() ;
				
				jQuery('<div id="boxy-modal-blackout" class="boxy-modal-blackout"><iframe style="position:absolute;_filter:alpha(opacity=0);opacity=0;z-index:-1;width:100%;height:100%;top:0;left:0;scrolling:no;" frameborder="0" src="about:blank"></iframe></div>')
				.css(jQuery.extend(Boxy._cssForOverlay(), {
					zIndex: 9999999, opacity: 0
				})).appendTo(document.body);
				
				
				$( '#ui_messageBox' ).css({
					left:( v.left + v.width/2  - $( '#ui_messageBox' ).outerWidth()/2 ) + "px",
					top:(  v.top  - 100 + v.height/2 - $( '#ui_messageBox' ).outerHeight()/2 ) + "px"
				});			
				
				$( '#ui_messageBox' ).fadeIn("fast");
			}
			
			
			var closeMessage = function(closeTime){
				setTimeout( function(){  
					$( '#ui_messageBox' ).fadeOut("fast",function(){
						jQuery('.boxy-modal-blackout:last').remove(); 
					});
				} , closeTime);
			}
			
			showMessage( message );
			closeMessage( closeTime );

		} ,
		
		error: function(message,closeTime){
			if(!closeTime){
				closeTime = 1000 ;
			}
			this.success(message,closeTime,1);
		} ,
		
		WRAPPER: "<table id='tsbox' class='boxy-wrapper' cellpadding='0' cellspace='0' border='0' style='display:none;z-index:1000000;'>" +
				"<tr><td class='boxy-top-left'></td><td class='boxy-top'></td><td class='boxy-top-right'></td></tr>" +
				"<tr><td class='boxy-left'></td>" +
				"<td class='boxy-inner'>" +
				"<div class='title-bar'></div><div class='boxy-content' id='tsbox_content'></div>" +
				"</td><td class='boxy-right'></td></tr>" +
				"<tr><td class='boxy-bottom-left'></td><td class='boxy-bottom'></td><td class='boxy-bottom-right'></td></tr>" +
				"</table>" ,
		
		inited: false ,
		IE6: ($.browser.msie && $.browser.version < 7) ,
		
		init: function(option){
			if(!this.inited){
				$('body').prepend(this.WRAPPER) ;
			}
			
			if(option.title){
				$('.title-bar','#tsbox').html("<h2>"+option.title+"</h2><a href='#' class='close'></a>") ;
			}
			
			$('#tsbox').show() ;
			
			$('<div id="boxy-modal-blackout" class="boxy-modal-blackout"><iframe style="position:absolute;_filter:alpha(opacity=0);opacity=0;z-index:-1;width:100%;height:100%;top:0;left:0;scrolling:no;" frameborder="0" src="about:blank"></iframe></div>').css($.extend(this._cssForOverlay(),{
				zIndex: 999999 ,
				opacity: 0.3 
			})).appendTo('body') ;
			
			$('body').bind('keypress.tsbox',function(event){
				var key = event.keyCode?event.keyCode:event.which?event.which:event.charCode;
				if(key == 27){
					$('body').unbind('keypress.tsbox') ;
					ui.box.close(option.callback) ;
					return false ;
				}
			}) ;
			
			$('.close','#tsbox').click(function(){
				ui.box.close(option.callback) ;
				return false ;
			}) ;
		} ,
		
		setContent: function(content){
			$('#tsbox_content').html(content) ;
		} ,
		
		close: function(fn){
			$('#tsbox').remove() ;	
			$('.boxy-modal-blackout').remove() ;
			if(fn){
				fn() ;
			}
		} ,
		
		load: function(url,option,type,data){
			this.init(option) ;
			var ajaxType = type || 'GET' ;
			var ajax = {
				url: url ,
				type: ajaxType ,
				data: data ,
				dataType: 'html' ,
				cache: false ,
				success: function(html){
					ui.box.setContent(html) ;
					ui.box.center() ;
				}
			} ;
			
			this.setContent('<div style="width:200px;height:150px;text-align:center"><div class="load">&nbsp;</div></div>') ;
			this.center() ;
			$.ajax(ajax) ;
		} ,
		
		center: function(axis){
    	    var v = ui.box._viewport();
    	    var o =  [v.left, v.top];
    	    if (!axis || axis == 'x') this.centerAt(o[0] + v.width / 2 , null);
    	    if (!axis || axis == 'y') this.centerAt(null, o[1] + v.height / 2);
    	    return this;
    	} , 
		
		centerAt: function(x, y){
            var s = this.getSize();
            //alert(s);
            if (typeof x == 'number') this.moveToX(x - s[0]/2 );
            if (typeof y == 'number') this.moveToY(y - s[1]/2 );
            return this;
        } ,
		
		// Center this dialog in the viewport (x-coord only)
		centerX: function() {
			return this.center('x');
		},
    
		// Center this dialog in the viewport (y-coord only)
		centerY: function() {
			return this.center('y');
		},
		
		getSize: function(){
            return [$('#tsbox').width(), $('#tsbox').height()];
        },
		
		moveToX: function(x){
            if (typeof x == 'number') $('#tsbox').css({left: x});
            else this.centerX();
            return this;
        },
        
        // Move this dialog (y-coord only)
        moveToY: function(y){
            if (typeof y == 'number') $('#tsbox').css({top: y});
            else this.centerY();
            return this;
        },
		
		_viewport: function(){
			var d = document.documentElement, b = document.body, w = window;
			return jQuery.extend(
				jQuery.browser.msie ?
					{ left: b.scrollLeft || d.scrollLeft, top: b.scrollTop || d.scrollTop } :
					{ left: w.pageXOffset, top: w.pageYOffset },
				!ui.box._u(w.innerWidth) ?
					{ width: w.innerWidth, height: w.innerHeight } :
					(!ui.box._u(d) && !ui.box._u(d.clientWidth) && d.clientWidth != 0 ?
						{ width: d.clientWidth, height: d.clientHeight } :
						{ width: b.clientWidth, height: b.clientHeight }) );
		},	
		
		_u: function(){
			for (var i = 0; i < arguments.length; i++)
				if (typeof arguments[i] != 'undefined') return false;
			return true;
		} ,
		
		_cssForOverlay: function(){
			if(ui.box.IE6){
				return {width: '100%', height: $(document).height() - 5};
			}else{
				return {width: '100%', height: $(document).height() - 5};
			}
		} 
}) ;












