function nextautomovie(){
	current = $('.server_item .listep').find('a.current');
	nextitem = current.next('a');
	if(nextitem.attr('href')){
		location = nextitem.attr('href');
	}
	
}

function setupplayer(a,b){

	$.post("../ipplugins.php",{epid:a},function(c){
		strz=c.split("|");
		$('html,body').animate({scrollTop: $("div.topzg").offset().top},'slow');

	if(strz[0]=="plugins" ||strz[0]=="http" || strz[0]=="video"){

				jwplayer(mediaplayer).setup({'flashplayer':'http://phimvc.com/player/player.swf',
				'width':'100%','height':'450',
				'autostart':'true',
				'stretching':'uniform',
				'controlbar':'bottom',
				'repeat':'false',
				'logo': {'file': 'http://abc.phimola.com/logo.png','position': 'top-right','margin': 15,'hide': 'false','link': '','linktarget': '_blank'},
				'plugins': {'http://abc.phimola.com/captions-2.js': {'file':'','bg':0,'noticebgcolor':'#000000','noticebgopacity':60,'forcefontsize':'20','forceleading':'0','forcecolor':'#ffffff','forceborder':'#000000','margintop':'30','fontsize':'20','leading':'4','color':'#ffff80','border':'#000000','marginbot':'36','notice':'','noticetime':'30','noticesize':'15','noticemargin':'-120','bgcolor':'#111111','bgopacity':'80'},
				'http://phimvc.com/player/plugins/proxy.swf' : {'link': strz[1]},
				'http://abc.phimola.com/timeslidertooltipplugin-3h.swf' : {'preview':{'enabled':false }}},
				'events': {onComplete: function() {nextautomovie();},onError: function(event){nextautomovie();}}});
		}else  {
			$("#").html(strz[1]);
		}
	});
}