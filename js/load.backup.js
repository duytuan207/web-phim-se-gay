var http = createRequestObject();
var field = '';
var loadingText = "<center><img src='images/loading.gif'> <b>Đang tải dữ liệu ...</b></center>";
var loadingfilm = '<center><embed id="ld" wmode="transparent" name="ld" src="http://anhtrang.org/phim/images/loading.swf" width="200" height="180" allowfullscreen="true" allowscriptaccess="always" /></center>';
           var RATE_OBJECT_IMG = "http://xemphimon.com/OneBee/images/star_l.png";
           var RATE_OBJECT_IMG_HOVER = "http://xemphimon.com/OneBee/images/star_l.png";
           var RATE_OBJECT_IMG_HALF = "http://xemphimon.com/OneBee/images/star_l_half.png";
           var RATE_OBJECT_IMG_BG = "http://xemphimon.com/OneBee/images/star_l_none.png";

function createRequestObject() {
	var xmlhttp;
	try { xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); }
	catch(e) {
    try { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	catch(f) { xmlhttp=null; }
  }
  if(!xmlhttp&&typeof XMLHttpRequest!="undefined") {
	xmlhttp=new XMLHttpRequest();
  }
	return  xmlhttp;
}

function handleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			response = http.responseText;
			field.innerHTML = response;
			field.scrollIntoView();
			if(!response) window.location.href = url;
		}
  	}
	catch(e){}
	finally{}
}

function nohandleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			response = http.responseText;
			field.innerHTML = response;
			if(!response) window.location.href = url;
		}
  	}
	catch(e){}
	finally{}
}

function load_pages(type,num,apr,id,page) { //load_pages('comment',num,film_id,0,1);	
	field = document.getElementById(type);
	if (type != 'comment')	
	field.innerHTML = loadingText;
	http.open('POST',  link_code+'index.php');
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = handleResponse;
    http.send('load_pages=1&type='+type+'&num='+num+'&apr='+apr+'&id='+id+'&page='+page); 
  return false; 
}
function IPsetCookie(c_name,value,exdays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
}
function IPgetCookie(c_name){
var i,x,y,ARRcookies=document.cookie.split(";");
for (i=0;i<ARRcookies.length;i++)
  {
  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
  x=x.replace(/^\s+|\s+$/g,"");
  if (x==c_name)
    {
    return unescape(y);
    }
  }
}
function next_movie(nextepid) {
		if(pautonext && nextepid > 0) {
			$('.list_episodes a.current').removeClass('current');
			$.post("index.php",{nextmovie:1,e_id:nextepid},function(c){
				strz=c.split(",");
				$('a#play_'+nextepid).addClass('current');
				 $("#ip-mediaplayer").html(c)
				if(pzoom){
					$("#player-rz").css({height:'560px'});
					$("#right").css({'padding-top':'530px'});
					$("#ip-mediaplayer_wrapper").css({'z-index':'10',position:'absolute',width:'990px',height:'460px'});
				}
			})
		}
	}
	
	var pautonext=true;
	function _autonext(){
		if(!pautonext){
			$("a._autonext span").html("Bật");
			pautonext=true
		}else{
			$("a._autonext span").html("Tắt");
			pautonext=false
		}
		return false;
	}
	var pzoom	=	false;
	function _zoom() {
		if(!pzoom){
			$("#player-rz").css({height:'560px'});
			$("#right").css({'padding-top':'530px'});
			$("#ip-mediaplayer_wrapper").css({position:'absolute',width:'990px',height:'460px'});
			$("a._zoom").html('Thu nhỏ');
			pzoom=true
		}else{
			$("#player-rz").css({height:'auto'});
			$("#right").css({'padding-top':'0'});
			$("#ip-mediaplayer_wrapper").css({position:'relative',width:'685px',height:'460px'});
			$("a._zoom").html('Phóng to');
			pzoom=false
		}
		return false;
	}
	var plight	=	false;
	function _light() {
		if(!plight){
			$('body').append('<div class="light-ip"></div>');
			$('#ip-mediaplayer_wrapper').css({'z-index':'10'});
			$("a._light").html("Bật đèn");
			plight=true
		}else{
			$('div.light-ip').remove();
			$("a._light").html("Tắt đèn");
			plight=false
		}
		return false;
	}
	
	function hide_ads_ip() {
		var dateads = new Date();
        var minutes = 60; // 60 phút
        dateads.setTime(dateads.getTime() + (minutes * 60 * 1000)); 
        IPsetCookie("hide-ads-ip",1,dateads);	
		IPsetCookie("hide-ads-ip",1,1);
		$('a._hide-ads').remove();
		$('html div.adv-hide-ip,body div.adv-hide-ip').remove();
		return false;
	}
	
	$(document).ready(function() {
		$("#searchInput").autocomplete("search.php",{width:600,max:30,highlight:!1,scroll:!1});
	   	$('#load-plugins-ip').prepend('<a class="bottom-ip _autonext" onclick="return _autonext()">AutoNext: <span>Bật</span></a>');
	   //$('#load-plugins-ip').prepend('<a class="bottom-ip _zoom"  onclick="return _zoom()">Phóng to</a><a class="bottom-ip _light" onclick="return _light()">Tắt đèn</a><a class="bottom-ip _autonext" onclick="return _autonext()">Tự động chuyển tập: <span>Bật</span></a><a class="bottom-ip _hide-ads" onclick="return hide_ads_ip()">Tắt quảng cáo</a><a class="bottom-ip _hide-ads" onclick="return hide_ads_ip()">Tắt quảng cáo</a>');
		 if(IPgetCookie("hide-ads-ip")) {
			 $('html div.adv-hide-ip,body div.adv-hide-ip,a._hide-ads').remove();
		 }
		$("#nav_menu li").hover(function(){
			$(this).addClass('activer');
			$(this).find("ul:first").show(200);
		},function(){
			$(this).removeClass('activer');
			$(this).find("ul:first").hide();
		});
		$("div.slider_chieurap").carousel({autoSlide:true,loop:true,dispItems: 5,autoSlideInterval:10000,delayAutoSlide:5000});
	});
	
	
function search_auto(query) {
			if(query.length < 3) {
				$("#show-search-auto").fadeOut();
			}else {
				$.get("/search.php",{ query: query},function(data){
					$("#show-search-auto").html(data).fadeIn();
				});
			}
}
//#######################################
//# SEARCH
//#######################################
/*
function do_search() {
	kw = document.getElementById("keyword").value;
	if (!kw) alert('Bạn chưa nhập từ khóa');
	else {
	kw = encodeURIComponent(kw);
	kw = kw.replace(/%20/g,'+');
	window.location.href = 'http://xemphimon.com/tim-kiem/'+kw+'/trang-1.html';
	}
	return false;
} */
function EnterKey(a){13==(window.event?window.event.keyCode:a.which)&&do_search()}
function do_search(a){if(searchid=$(".tgt-autocomplete-activeItem a").attr("href"))return window.location.href=searchid,!1;1==a&&(query=$("input[name='q']").val(),window.location.href="http://xemphimon.com/tim-kiem/"+query+'/trang-1.html');return!1}



//#######################################
//# tag
//#######################################
function do_tag() {
	kw = document.getElementById("keyword").value;
	if (!kw) alert('Bạn chưa nhập từ khóa');
	else {
		kw = encodeURIComponent(kw);
		window.location.href = 'http://xemphimon.com/tag/'+kw+'/trang-1.html';	
	}
  return false;
}
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
		$("#dien-vien-show-film").append(data).hide().fadeIn(300);
	})
	return false;
}	


//#######################################
//# ADD EMOTIONS
//#######################################
function addText(elname, wrap1, wrap2) {
	if (document.selection) { // for IE 
		var str = document.selection.createRange().text;
		document.forms['add'].elements[elname].focus();
		var sel = document.selection.createRange();
		sel.text = wrap1 + str + wrap2;
		return;
	} else if ((typeof document.forms['add'].elements[elname].selectionStart) != 'undefined') { // for Mozilla
		var txtarea = document.forms['add'].elements[elname];
		var selLength = txtarea.textLength;
		var selStart = txtarea.selectionStart;
		var selEnd = txtarea.selectionEnd;
		var oldScrollTop = txtarea.scrollTop;
		var s1 = (txtarea.value).substring(0,selStart);
		var s2 = (txtarea.value).substring(selStart, selEnd)
		var s3 = (txtarea.value).substring(selEnd, selLength);
		txtarea.value = s1 + wrap1 + s2 + wrap2 + s3;
		txtarea.selectionStart = s1.length;
		txtarea.selectionEnd = s1.length + s2.length + wrap1.length + wrap2.length;
		txtarea.scrollTop = oldScrollTop;
		txtarea.focus();
		return;
	} else {
		insertText(elname, wrap1 + wrap2);
	}
}
//#######################################
//# COUNT WORDS
//#######################################
var submitcount=0;
   function checkSubmit() {

      if (submitcount == 0)
      {
      submitcount++;
      document.Surv.submit();
      }
   }


function wordCounter(field, countfield, maxlimit) {
wordcounter=0;
for (x=0;x<field.value.length;x++) {
      if (field.value.charAt(x) == " " && field.value.charAt(x-1) != " ")  {wordcounter++}
      if (wordcounter > 250) {field.value = field.value.substring(0, x);}
      else {countfield.value = maxlimit - wordcounter;}
      }
   }

function textCounter(field, countfield, maxlimit) {
  if (field.value.length > maxlimit)
      {field.value = field.value.substring(0, maxlimit);}
      else
      {countfield.value = maxlimit - field.value.length;}
  }
//#######################################
//# COMMENT
//#######################################
function showComment(num,film_id,page) { 
	field = document.getElementById("comment_field");
	field.innerHTML = loadingText;
	http.open('POST',  'index.php');
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = handleResponse;
    http.send('showcomment=1&num='+num+'&film_id='+film_id+'&page='+page); 
  return false; 
} 

function comment_handleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			var response = http.responseText;
			if (response == 'OK') {
				film_id = encodeURIComponent(document.getElementById("film_id").value);
				num = encodeURIComponent(document.getElementById("num").value);
				showComment(num,film_id,1);
			}
			else document.getElementById("comment_loading").innerHTML = response;

		}
  	}
	catch(e){}
	finally{}
}

function comment_check_values() {
	film_id = encodeURIComponent(document.getElementById("film_id").value);
	num = encodeURIComponent(document.getElementById("num").value);
	comment_poster = encodeURIComponent(document.getElementById("comment_poster").value);
	comment_content = encodeURIComponent(document.getElementById("comment_content").value);
	comment_img = encodeURIComponent(document.getElementById("comment_img").value);
	try {
	    document.getElementById("comment_loading").innerHTML = loadingText;
		document.getElementById("comment_loading").style.display = "block";
		http.open('POST',  'index.php');
		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
		http.onreadystatechange = comment_handleResponse;
		http.send('comment=1&film_id='+film_id+'&num='+num+'&comment_poster='+comment_poster+'&comment_content='+comment_content+'&comment_img='+comment_img);
		document.getElementById("submit").disabled=true;document.getElementById("submit").value="Wait...";
	}
	catch(e){}
	finally{}
  return false;
}
//#######################################
//# RATING
//#######################################
function rating(film_id,star) {
   		field = document.getElementById("rating_field");
	//	field.innerHTML = loadingText;
   		http.open('POST', 'index.php');
   		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
   		http.onreadystatechange = nohandleResponse;
		http.send('rating=1&film_id='+film_id+'&star='+star);
 	return false;
}
	// pre-fetch image
	(new Image()).src = RATE_OBJECT_IMG;
	(new Image()).src = RATE_OBJECT_IMG_HALF;
	(new Image()).src = RATE_OBJECT_IMG_BG;

	function show_star(starNum,rate_text) {
		remove_star();
		document.getElementById("rating_text").innerHTML = rate_text;
		full_star(starNum);
	}
	
	function full_star(starNum) {
		for (var i=0; i < starNum; i++)
			document.getElementById('star'+ (i+1)).src = RATE_OBJECT_IMG;
	}
	function remove_star() {
		for (var i=0; i < 5; i++)
			document.getElementById('star' + (i+1)).src = RATE_OBJECT_IMG_BG; // RATE_OBJECT_IMG_REMOVED;
	}
	function remove_all_star() {
		for (var i=0; i < 5; i++) document.getElementById('star' + (i+1)).src = RATE_OBJECT_IMG_BG; // RATE_OBJECT_IMG_REMOVED;
		document.getElementById("rating_text").innerHTML = 'Bình Chọn';
	}
	function show_rating_process() {
		if(document.getElementById("rating_process")) document.getElementById("rating_process").style.display = "block";
		if(document.getElementById("rating")) document.getElementById("rating").style.display = "none";
	}
	function hide_rating_process() {
		document.getElementById("rating_process").style.display = "none";
		if(document.getElementById("rating")) document.getElementById("rating").style.display = "block";
	}
//#######################################
//# REQUEST
//#######################################
function showRequest(num,page) {
	field = document.getElementById("request_field");
	field.innerHTML = loadingText;
	http.open('POST',  'index.php');
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = handleResponse;
    http.send('showrequest=1&num='+num+'&page='+page); 
  return false; 
} 

function request_handleResponse() {
	try {
		if((http.readyState == 4)&&(http.status == 200)){
			var response = http.responseText;
			if (response == 'OK') {
				num = encodeURIComponent(document.getElementById("num").value);
				showRequest(num,1);
			}
			else document.getElementById("request_loading").innerHTML = response;
			
		}
  	}
	catch(e){}
	finally{}
}

function request_check_values() {
	num = encodeURIComponent(document.getElementById("num").value);
	request_name = encodeURIComponent(document.getElementById("request_name").value);
	request_email = encodeURIComponent(document.getElementById("request_email").value);
	request_img = encodeURIComponent(document.getElementById("request_img").value);
	try{
			document.getElementById("request_loading").innerHTML = loadingText;
			document.getElementById("request_loading").style.display = "block";
			http.open('POST',  'index.php');
			http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
			http.onreadystatechange = request_handleResponse;
			http.send('request=1&num='+num+'&request_name='+request_name+'&request_email='+request_email+'&request_img='+request_img);
			//document.getElementById("send").disabled=true;document.getElementById("send").value="Wait...";
		}
	  catch(e){}
	  finally{}
	return false;
}
//#######################################
//# BROKEN
//#######################################
function showBroken(film_id,episode_id) {
	try {
		//document.getElementById("broken_field").innerHTML = loadingText;
		//document.getElementById('broken_field').style.display='block';
		http.open('POST','index.php');
		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		http.onreadystatechange = function() {
			if((http.readyState == 4)&&(http.status == 200)){
				//document.getElementById("broken_field").innerHTML = http.responseText;
				alert('Đã thông báo link lỗi! Cám ơn bạn!');
			}
		}
		http.send('broken=1&film_id='+film_id+'&episode_id='+episode_id);
	}
	catch(e){}
	finally{}
	return false;
}
//#######################################
//# SHOW FILM
//#######################################
function showFilm(num,page,number,apr,cat_id) { 
    field = document.getElementById(num);
	field.innerHTML = loadingText;
	http.open('POST',  'index.php');
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = handleResponse;
    http.send('showfilm=1&num='+num+'&page='+page+'&number='+number+'&apr='+apr+'&cat_id='+cat_id); 
  return false; 
}
//#######################################
//# SHOW TRAILER
//#######################################
function showTrailer(num,apr,page) { 
    field = document.getElementById("trailer_loading");
	field.innerHTML = loadingText;
	http.open('POST',  'index.php');
	http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	http.onreadystatechange = handleResponse;
    http.send('showtrailer=1&num='+num+'&apr='+apr+'&page='+page); 
  return false; 
}
//#######################################
//# WATCH MOVIE
//#######################################
function player(episode_id) {
	try {
		field = document.getElementById("player_field");
		field.scrollIntoView();
		field.innerHTML = loadingText;
		http.open('POST','index.php');
		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		http.onreadystatechange = handleResponse;
		http.send('watch=1&episode_id='+episode_id);
	}
	catch(e){}
	finally{}
	return false;
}

//#######################################
//# favorite
//#######################################
function favo(islogin,film_id) {
	try {
		if(islogin==0)
		{
			alert('Bạn phải đăng nhập để sử dụng chức năng này! Cám ơn bạn!');
		}
		else{
			http.open('POST','index.php');
			http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			http.onreadystatechange = function() {
				if((http.readyState == 4)&&(http.status == 200)){
					alert('Đã thêm phim này vào danh sách ưa thích của bạn! Cám ơn bạn!');
					
				}
			}
			http.send('favo=1&film_id='+film_id);
		}
	}
	catch(e){}
	finally{}
	return false;
}
//#######################################
//#unfavorite
//#######################################
function unfavo(film_id) {
	try {
		http.open('POST','index.php');
		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		http.onreadystatechange = function() {
				if((http.readyState == 4)&&(http.status == 200)){
					alert('Đã bỏ phim này khỏi danh sách ưa thích của bạn! Cám ơn bạn!');
					//showFilm(11,1,12,1,'');
				}
			}
		http.send('unfavo=1&film_id='+film_id);
	}
	catch(e){}
	finally{}
	return false;
}


/*! Y!m: nguyen.long199x */
var video_common=
{
	promotedClip: new Array(),
	animId: 0,
	currAnim: 1,
	
	startAnim: function(){
		if($('#top_video').html() != ''){
			this.promotedClip[0] = $('#top_video').html();
			this.promotedClip[1] = $('#top_video_1').html();
			this.promotedClip[2] = $('#top_video_2').html();
			this.animId = setInterval("video_common.switchPromoted()", 10000);
		}
	},
	stopAnim: function(){
		if(this.animId > 0){
			clearInterval(this.animId);
			this.animId = 0;
		}
	},
	switchPromoted: function(){
		if(video_common.animId > 0){
			$('#top_video').fadeOut(1000, function(){
				var next_id=video_common.currAnim+1;
				if (next_id>1)
				{
					next_id=0;
				}
				$('#top_video').html(video_common.promotedClip[next_id]);
				$('#top_video').fadeIn(1000);
			});
			video_common.currAnim += 1;
			 if (video_common.currAnim>1){
				video_common.currAnim=0;
			}
		}
	}
}
var videox_common=
{
	promotedClip: new Array(),
	animId: 0,
	currAnim: 1,
	
	startAnim: function(){
		if($('#topx_video').html() != ''){
			this.promotedClip[0] = $('#topx_video').html();
			this.promotedClip[1] = $('#topx_video_1').html();
			this.promotedClip[2] = $('#topx_video_2').html();
			this.animId = setInterval("videox_common.switchPromoted()", 10000);
		}
	},
	stopAnim: function(){
		if(this.animId > 0){
			clearInterval(this.animId);
			this.animId = 0;
		}
	},
	switchPromoted: function(){
		if(videox_common.animId > 0){
			$('#topx_video').fadeOut(1000, function(){
				var next_id=videox_common.currAnim+1;
				if (next_id>1)
				{
					next_id=0;
				}
				$('#topx_video').html(videox_common.promotedClip[next_id]);
				$('#topx_video').fadeIn(1000);
			});
			videox_common.currAnim += 1;
			 if (videox_common.currAnim>1){
				videox_common.currAnim=0;
			}
		}
	}
}
var videoy_common=
{
	promotedClip: new Array(),
	animId: 0,
	currAnim: 1,
	
	startAnim: function(){
		if($('#topy_video').html() != ''){
			this.promotedClip[0] = $('#topy_video').html();
			this.promotedClip[1] = $('#topy_video_1').html();
			this.promotedClip[2] = $('#topy_video_2').html();
			this.animId = setInterval("videoy_common.switchPromoted()", 10000);
		}
	},
	stopAnim: function(){
		if(this.animId > 0){
			clearInterval(this.animId);
			this.animId = 0;
		}
	},
	switchPromoted: function(){
		if(videoy_common.animId > 0){
			$('#topy_video').fadeOut(1000, function(){
				var next_id=videoy_common.currAnim+1;
				if (next_id>1)
				{
					next_id=0;
				}
				$('#topy_video').html(videoy_common.promotedClip[next_id]);
				$('#topy_video').fadeIn(1000);
			});
			videoy_common.currAnim += 1;
			 if (videoy_common.currAnim>1){
				videoy_common.currAnim=0;
			}
		}
	}
}
var videoz_common=
{
	promotedClip: new Array(),
	animId: 0,
	currAnim: 1,
	
	startAnim: function(){
		if($('#topz_video').html() != ''){
			this.promotedClip[0] = $('#topz_video').html();
			this.promotedClip[1] = $('#topz_video_1').html();
			this.promotedClip[2] = $('#topz_video_2').html();
			this.animId = setInterval("videoz_common.switchPromoted()", 10000);
		}
	},
	stopAnim: function(){
		if(this.animId > 0){
			clearInterval(this.animId);
			this.animId = 0;
		}
	},
	switchPromoted: function(){
		if(videoz_common.animId > 0){
			$('#topz_video').fadeOut(1000, function(){
				var next_id=videoz_common.currAnim+1;
				if (next_id>1)
				{
					next_id=0;
				}
				$('#topz_video').html(videoz_common.promotedClip[next_id]);
				$('#topz_video').fadeIn(1000);
			});
			videoz_common.currAnim += 1;
			 if (videoz_common.currAnim>1){
				videoz_common.currAnim=0;
			}
		}
	}
}
scrolltotop.init();
function createRequestObject() {
	var xmlhttp;
	try { xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); }
	catch(e) {
    try { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}
	catch(f) { xmlhttp=null; }
  }
  if(!xmlhttp&&typeof XMLHttpRequest!="undefined") {
	xmlhttp=new XMLHttpRequest();
  }
	return  xmlhttp;
}

/* box */
var imgServer='http://image.star.zing.vn/'
var offsetfromcursorX=12 //Customize x offset of tooltip
var offsetfromcursorY=10 //Customize y offset of tooltip

var offsetdivfrompointerX=10 //Customize x offset of tooltip DIV relative to pointer image
var offsetdivfrompointerY=14 //Customize y offset of tooltip DIV relative to pointer image. Tip: Set it to (height_of_pointer_image-1).

document.write('<div id="dhtmltooltip"></div>') //write out tooltip DIV
document.write('<img id="dhtmlpointer" src="images/spc.gif">') //write out pointer image

var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

var pointerobj=document.all? document.all["dhtmlpointer"] : document.getElementById? document.getElementById("dhtmlpointer") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thewidth, thecolor){
if (ns6||ie){
	if (typeof thewidth!="undefined") {
		tipobj.style.width=thewidth+"px";
	}
	if (typeof thecolor != "undefined" && thecolor != "") {
		tipobj.style.backgroundColor=thecolor;
	}
	tipobj.innerHTML=thetext
	enabletip=true
	return false
}
}

function positiontip(e){
if (enabletip){
var nondefaultpos=false
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var winwidth=ie&&!window.opera? ietruebody().clientWidth : window.innerWidth-20
var winheight=ie&&!window.opera? ietruebody().clientHeight : window.innerHeight-20

var rightedge=ie&&!window.opera? winwidth-event.clientX-offsetfromcursorX : winwidth-e.clientX-offsetfromcursorX
var bottomedge=ie&&!window.opera? winheight-event.clientY-offsetfromcursorY : winheight-e.clientY-offsetfromcursorY

var leftedge=(offsetfromcursorX<0)? offsetfromcursorX*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth){
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=curX-tipobj.offsetWidth+"px"
nondefaultpos=true
}
else if (curX<leftedge)
tipobj.style.left="5px"
else{
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetfromcursorX-offsetdivfrompointerX+"px"
pointerobj.style.left=curX+offsetfromcursorX+"px"
}

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight){
tipobj.style.top=curY-tipobj.offsetHeight-offsetfromcursorY+"px"
nondefaultpos=true
}
else{
tipobj.style.top=curY+offsetfromcursorY+offsetdivfrompointerY+"px"
pointerobj.style.top=curY+offsetfromcursorY+"px"
}
tipobj.style.visibility="visible"
if (!nondefaultpos)
pointerobj.style.visibility="visible"
else
pointerobj.style.visibility="hidden"
}
}
function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
pointerobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor=''
tipobj.style.width=''
}
}
document.onmousemove=positiontip
