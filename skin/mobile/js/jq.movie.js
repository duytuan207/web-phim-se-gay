(function($){$.fn.jCarouselLite=function(o){o=$.extend({btnPrev:null,btnNext:null,btnGo:null,mouseWheel:false,auto:null,speed:200,easing:null,vertical:false,circular:true,visible:3,start:0,scroll:1,beforeStart:null,afterEnd:null},o||{});return this.each(function(){var b=false,animCss=o.vertical?"top":"left",sizeCss=o.vertical?"height":"width";var c=$(this),ul=$("ul",c),tLi=$("li",ul),tl=tLi.size(),v=o.visible;if(o.circular){ul.prepend(tLi.slice(tl-v-1+1).clone()).append(tLi.slice(0,v).clone());o.start+=v}var f=$("li",ul),itemLength=f.size(),curr=o.start;c.css("visibility","visible");f.css({overflow:"hidden",float:o.vertical?"none":"left"});ul.css({margin:"0",padding:"0",position:"relative","list-style-type":"none","z-index":"1"});c.css({overflow:"hidden",position:"relative","z-index":"2",left:"0px"});var g=o.vertical?height(f):width(f);var h=g*itemLength;var j=g*v;f.css({width:f.width(),height:f.height()});ul.css(sizeCss,h+"px").css(animCss,-(curr*g));c.css(sizeCss,j+"px");if(o.btnPrev)$(o.btnPrev).click(function(){return go(curr-o.scroll)});if(o.btnNext)$(o.btnNext).click(function(){return go(curr+o.scroll)});if(o.btnGo)$.each(o.btnGo,function(i,a){$(a).click(function(){return go(o.circular?o.visible+i:i)})});if(o.mouseWheel&&c.mousewheel)c.mousewheel(function(e,d){return d>0?go(curr-o.scroll):go(curr+o.scroll)});if(o.auto)setInterval(function(){go(curr+o.scroll)},o.auto+o.speed);function vis(){return f.slice(curr).slice(0,v)};function go(a){if(!b){if(o.beforeStart)o.beforeStart.call(this,vis());if(o.circular){if(a<=o.start-v-1){ul.css(animCss,-((itemLength-(v*2))*g)+"px");curr=a==o.start-v-1?itemLength-(v*2)-1:itemLength-(v*2)-o.scroll}else if(a>=itemLength-v+1){ul.css(animCss,-((v)*g)+"px");curr=a==itemLength-v+1?v+1:v+o.scroll}else curr=a}else{if(a<0||a>itemLength-v)return;else curr=a}b=true;ul.animate(animCss=="left"?{left:-(curr*g)}:{top:-(curr*g)},o.speed,o.easing,function(){if(o.afterEnd)o.afterEnd.call(this,vis());b=false});if(!o.circular){$(o.btnPrev+","+o.btnNext).removeClass("disabled");$((curr-o.scroll<0&&o.btnPrev)||(curr+o.scroll>itemLength-v&&o.btnNext)||[]).addClass("disabled")}}return false}})};function css(a,b){return parseInt($.css(a[0],b))||0};function width(a){return a[0].offsetWidth+css(a,'marginLeft')+css(a,'marginRight')};function height(a){return a[0].offsetHeight+css(a,'marginTop')+css(a,'marginBottom')}})(jQuery);

//cookie
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options = $.extend({}, options); // clone object since it's unexpected behavior if the expired property were changed
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        // NOTE Needed to parenthesize options.path and options.domain
        // in the following expressions, otherwise they evaluate to undefined
        // in the packed version for some reason...
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};

//code
function tab(a,b)
{
	c = $("#tab_"+a+"_"+b);
	
	d = $("#tab_ct_"+a+"_"+b);
	
	$("#"+a+" .tabs li, #"+a+" .tab_ct").removeClass("c");
	c.addClass('c');
	d.addClass('c');
}
function EnterKey(a){13==(window.event?window.event.keyCode:a.which)&&do_search()}

function do_search(a){if(searchid=$(".tgt-autocomplete-activeItem a").attr("href"))return window.location.href=searchid,!1;1==a&&(query=$("input[name='q']").val(),window.location.href="http://xemphimon.com/tim-kiem/"+query+'/trang-1.html');return!1}
// ready
jQuery(function($){
	$("#searchInput").autocomplete("search.php",{width:600,max:30,highlight:!1,scroll:!1});
	
	$("#ex_f").click(function(){
	if(filter == 0)
	{
		$(this).html("Thu hẹp");
		
		$("#filter li").addClass('s');
		filter = 1;
	}
	else
	{
		$(this).html("Mở rộng");
		$("#filter li").removeClass('s');
		filter = 0;
	}
	
	
});
// tootips
$(".movies li .cover").mousemove(function(e) {
		 var b = $(this);
		 var a = $(this).parent().children('.m-box');
		 a.show().css({
        "top" : e.pageY,
        "left" : e.pageX + 15
    });
}).mouseout(function(){ var a = $(this).parent().children('.m-box');a.hide();});
 $("#menu ul li").each(function(index){
	   $(this).mouseenter(function(){
		   $(this).addClass('over');
		    }).mouseleave(function(){
			   $(this).removeClass('over');
  			})
  		});
});
//#######################################
//# Dien Vien
//#######################################

function dienvien(page) {
	$.post('index.php',{dienvien:1,page:page}, function(data){
		html	=	data.split("{***}");
		$("#dien-vien-show").append(html[0]);
		if(html[1])
			$("#show-actor-click").html(html[1]);
		else
			$("#show-actor-click").remove();
	})
}



function filmdienvien(key,page) {
	$.post('index.php',{filmdienvien:1,key:key,page:page}, function(data){
		$("#show-film-click").remove();
		$("#dien-vien-show-film").append(data);
	})
	return false;

}
// phóng to
var	show_part	=	0;
var zoomp		=	false;
function zoom_player() {
	if(zoomp) {
		$('#m').css({'width':'auto'});
		$('#r').css({'padding-top':'0'});
		if(show_part==1) {
			$('#player_wrapper').css({'height':'400px'});
			$('.slider_part .ulz').css({'width':'563px'});
		}
		zoomp	=	false;	
	}else {
		$('#m').css({'width':'980px','position':'relative','z-index':'3'});
		if(show_part==1) {
			$('#r').css({'padding-top':'678px'});
			$('#player_wrapper').css({'height':'500px'});
			$('.slider_part .ulz').css({'width':'870px'});
		}else {
			$('#r').css({'padding-top':'573px'});
		}
		zoomp	=	true;	
	}
}
//light
$(function() {
	if($.cookie("autonext_1v")) {
		$('#txt-next').html('Autonext: Off');
	}else {
		$('#txt-next').html('Autonext: On');
	}
   fill_default_value();
   $("#toggle_light, #toggle_resize, #toggle_autonext").show();
   $("#movie.block").css("position",
   "absolute");
   $("#movie_info").css("margin-top",
   "630px");

   if(!$("#player").length) {
      $("#movie_info").css("margin-top",
      630);
      $("#movie.block").css("height",
      100)}
   $("#toggle_resize").click(function() {
      resize_player(); $(this).text(resize ? "Thu nhá»" : "PhĂ³ng to")}
   );

	$("#toggle_autonext").click(function () {
        toggle_autonext();
        $(this).text(_autonext ? 'AutoNext: On' : 'AutoNext: Off');
    }).text(_autonext ? 'AutoNext: On' : 'AutoNext: Off');

	$(".episode_list").find("a").click(function () {
        load_episode($(this));
        return false;
    });

   var c = false;

   $("#player, #toggle_light, #toggle_resize, #toggle_autonext").css("position", "relative").css('z-index', 8);

   $("#toggle_light, #lightout").click(function() {
      if(!c) {
         c = true; $("#lightout").css("opacity",
         .98).hide().fadeIn()}
      else {
         c = false; $("#lightout").fadeOut()}
      $("#toggle_light").text(c ? "Bật Đèn" : "Tắt Đèn")}
   );
})
function fill_default_value() {
    $(".default-value").each(function () {
        var a = $(this).attr("default-value");
        if ($(this).val() == "") {
            $(this).val(a)
        }
        $(this).css("color", "#666");
        $(this).focus(function () {
            if ($(this).val() == a) {
                $(this).val("");
                $(this).css("color", "")
            }
        });
        $(this).blur(function () {
            if ($(this).val() == "") {
                $(this).css("color", "#666");
                $(this).val(a)
            }
        })
    })
}

function next_player() {
	if($.cookie("autonext_1v")) {
		$('#txt-next').html('Autonext: On');
		$.cookie("autonext_1v","");
	}else {
		$('#txt-next').html('Autonext: Off');
		$.cookie("autonext_1v",1);
	}
	return false;
}
function phim1v_next_video() {
	if(!$.cookie("autonext_1v")) {
		var	e_id	=	tapID;
		if(e_id) {
			$.post('index.php',{nextmovie:1,e_id:e_id}, function(data){
				//alert(data);
				var phim1v	=	data.split("|*|");
				var	playerData	=	phim1v[1];
				if(playerData) {
					$("#player").html(playerData);
					$("div.list_episodes a.current").removeClass('current');
					$("#play_"+e_id).addClass('current');
				}
				tapID	=	phim1v[0];
			})
		}
	}
}