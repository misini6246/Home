// JavaScript Document
	$(document).ready(function(){
		$("#use_left_con ul li").mouseover(function(){
										
			
			$(this).css("background","url(images/user_left_bg.jpg)");
		 });
		$("#use_left_con ul li").mouseout(function(){
			if(!($(this).hasClass("leftdis_ok")))
			$(this).css("background","");
		 });
		 $("#xszn_1").click(function(){
			$("#xszn_con_1").slideToggle("slow");	
			if($("#xszn_jia_1").html()=="+")
				$("#xszn_jia_1").html("-");
			else
				$("#xszn_jia_1").html("+");
			
		 });
		$("#xszn_5").click(function(){
			$("#xszn_con_5").slideToggle("slow");	
			if($("#xszn_jia_5").html()=="+")
				$("#xszn_jia_5").html("-");
			else
				$("#xszn_jia_5").html("+");
			
		 });
		 $("#xszn_6").click(function(){
			$("#xszn_con_6").slideToggle("slow");	
			if($("#xszn_jia_6").html()=="+")
				$("#xszn_jia_6").html("-");
			else
				$("#xszn_jia_6").html("+");
			
		 });
		 $("#xszn_7").click(function(){
			$("#xszn_con_7").slideToggle("slow");	
			if($("#xszn_jia_7").html()=="+")
				$("#xszn_jia_7").html("-");
			else
				$("#xszn_jia_7").html("+");
			
		 });
		 $("#xszn_8").click(function(){
			$("#xszn_con_8").slideToggle("slow");	
			if($("#xszn_jia_8").html()=="+")
				$("#xszn_jia_8").html("-");
			else
				$("#xszn_jia_8").html("+");
			
		 });
		 $("#xszn_16").click(function(){
			$("#xszn_con_16").slideToggle("slow");	
			if($("#xszn_jia_16").html()=="+")
				$("#xszn_jia_16").html("-");
			else
				$("#xszn_jia_16").html("+");
			
		 });
		 $("#xszn_17").click(function(){
			$("#xszn_con_17").slideToggle("slow");	
			if($("#xszn_jia_17").html()=="+")
				$("#xszn_jia_17").html("-");
			else
				$("#xszn_jia_17").html("+");
			
		 });
		 $("#xszn_2").click(function(){
			$("#xszn_con_2").slideToggle("slow");	
			if($("#xszn_jia_2").html()=="+")
				$("#xszn_jia_2").html("-");
			else
				$("#xszn_jia_2").html("+");
			
		 });
		 
			
	});