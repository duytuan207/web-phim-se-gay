jQuery(document).ready(function(){
	//--Khi bấm nút trailer
	jQuery('.btn-film-trailer').click(function(){
		//--Nếu kích thước màn hình nhỏ thì ko play ở popup
		var wWidth=jQuery(window).width();
		var wHeight=jQuery(window).height();
		if(wWidth<1000 || wHeight<600)
			return true;
		//--Lấy URL của trailer
		var videoUrl=jQuery(this).attr('data-videourl');
		if(typeof videoUrl!='string')
			return true;
		//--Lấy preview ảnh
		var previewUrl='';
		if(typeof filmInfo.previewUrl=="string")
			previewUrl=filmInfo.previewUrl;
		//--Khởi tạo trình player với chiều rộng và cao = 100%
		if(typeof Player=="undefined")
			return true;
		var trailerPlayer=new Player("trailer-player");
		trailerPlayer.useYoutubeEmbed=0;
		trailerPlayer.options.width='640px';
		trailerPlayer.options.height='360px';
		//--Tạo tiêu đề popup & url comment box
		var title=jQuery(this).attr('title');
		if(typeof title!='string' || jQuery.trim(title)=='')
			title='Trailer';
		var filmUrl='';
		if(typeof filmInfo.fullUrl=="string")
			filmUrl=filmInfo.fullUrl;
		//--Bật popup có overlay
		fx.displayPopup(title,'<div id="trailer-player-popup" class="trailer-player-popup" style="width: 960px;height: 360px;">\
			<div id="trailer-player" style="display:inline-block;width: 640px;"></div>\
			<div id="trailer-comment" class="loading-image" style="display:inline-block;min-height:50px;width:310px;height:100%;overflow:auto;float:right;"><div class="fb-comments" data-href="'+filmUrl+'" data-width="290" data-numposts="5" data-colorscheme="light"></div></div>\
		</div>',function(){
			trailerPlayer.setup(videoUrl,previewUrl);
			if(typeof FB!="undefined" && typeof FB.XFBML.parse=="function")
				FB.XFBML.parse(document.getElementById("trailer-comment"));
		},1);
		return false;
	});
	
	//--Tìm kiếm
	var fixKeyword=function (str) {  
		str= str.toLowerCase();   
		str= str.replace(/[^\s0-9a-zA-ZấầẩẫậẤẦẨẪẬắằẳẵặẮẰẲẴẶáàảãạâăÁÀẢÃẠÂĂếềểễệẾỀỂỄỆéèẻẽẹêÉÈẺẼẸÊíìỉĩịÍÌỈĨỊốồổỗộỐỒỔÔỘớờởỡợỚỜỞỠỢóòỏõọôơÓÒỎÕỌÔƠứừửữựỨỪỬỮỰúùủũụưÚÙỦŨỤƯýỳỷỹỵÝỲỶỸỴđĐ]+/g," "); 
		str= str.replace(/^\s+|\s+$/g,""); 
		str= str.replace(/\s{1,}/g,"+"); 		
		return str;  
	}   
	jQuery('#form-search').submit(function(){
		var keywordObj=jQuery(this).find('input[name=keyword]')[0];
		
		if(typeof keywordObj !='undefined' && keywordObj!=null)
		{
			var keyword=jQuery(keywordObj).val();
			keyword=fixKeyword(keyword);
			keyword=jQuery.trim(keyword);
			if(keyword=='')
			{
				alert('Bạn chưa nhập từ khóa. (Không tính các ký tự đặc biệt vào độ dài từ khóa)');
				jQuery(keywordObj).focus();
				return false;
			}
			window.location.replace('tim-kiem/'+keyword+'/');
		}
		return false;
	});
});