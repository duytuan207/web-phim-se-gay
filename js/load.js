function search_auto(a) {
	3 > a.length ? $("#show-search-auto").fadeOut() : $.get("/search.php", {
		query : a
	}, function (a) {
		$("#show-search-auto").html(a).fadeIn()
	})
}

function EnterKey(a) {
	13 == (window.event ? window.event.keyCode : a.which) && do_search()
}

function do_search(a) {
	if (searchid = $(".tgt-autocomplete-activeItem a").attr("href"))
		return window.location.href = searchid, !1;
	1 == a && (query = $("input[name='q']").val(), window.location.href = "http://xemphimon.com/tim-kiem/" + query + "/trang-1.html");
	return !1
}

function do_tag() {
	(kw = document.getElementById("keyword").value) ? (kw = encodeURIComponent(kw), window.location.href = "http://xemphimon.com/tag/" + kw + "/trang-1.html") : alert("B\u1ea1n ch\u01b0a nh\u1eadp t\u1eeb kh\u00f3a");
	return !1
}

var plight = !1;
function _light() {
	plight ? ($("div#light-overlay").remove(), $("span#light-statuss").html("T\u1eaft \u0111\u00e8n"), plight = !1) : ($("body").append('<div id="light-overlay" style="position: fixed; z-index: 999; opacity: 0.98; top: 0px; left: 0px; width: 100%; height: 100%; background-color: rgb(0, 0, 0);"></div>'), $("#watch-block").css({
			"z-index" : "2000"
		}), $("#media-player-box").css({
			"z-index" : "2000"
		}), $("span#light-statuss").html("B\u1eadt \u0111\u00e8n"), plight = !0);
	$('html, body').animate({
		scrollTop : $("#watch-block").offset().top
	}, 1000);
	return !1
}
var resizeCheck = 'small';
var orgBoxWidth = 0;
var orgPlayerSize = {
	'width' : 0,
	'height' : 0
};
var docHeight = 34;

function zoom_css() {

	if (resizeCheck == 'small') {
		//--Tính toán kích thước trước khi phóng
		orgBoxWidth = jQuery('#block-player').outerWidth();
		orgPlayerSize.width = jQuery('#media-player-box').width();
		orgPlayerSize.height = jQuery('#media-player-box').height();
		//--Tính toán kích thước sau khi phóng
		var newWidth = 960;
		var largeSize = {
			'width' : newWidth,
			'height' : Math.ceil(newWidth / 16 * 9 + docHeight)
		};
		var sidebarTopMargin = jQuery('.block-comments').offset().top;

		jQuery('#sidebar').animate({
			marginTop : sidebarTopMargin
		});
		jQuery('#block-player').animate({
			width : '980px'
		});
		jQuery('#btn-resize-player #resize-status').text('Thu nhỏ');
		jQuery('#block-player #media-player-box').animate({
			width : largeSize.width,
			height : largeSize.height
		}, function () {
			$('html, body').animate({
				scrollTop : $("#watch-block").offset().top
			}, 1000);
		});
		resizeCheck = 'large';
	} else {

		jQuery('#block-player').animate({
			width : orgBoxWidth
		});
		jQuery('#sidebar').animate({
			marginTop : "0px"
		});
		jQuery('#block-player #media-player-box').animate({
			width : orgPlayerSize.width,
			height : orgPlayerSize.height
		}, function () {
			$('html, body').animate({
				scrollTop : $("#watch-block").offset().top
			}, 1000);
		});
		jQuery('#btn-resize-player #resize-status').text('Phóng to');
		resizeCheck = 'small';
	}

}

var pzoom = !1;
function _zoom() {

	if (!pzoom) {
		zoom_css();
		$("a._zoom").html("Thu nh\u1ecf");
		$('html, body').animate({
			scrollTop : $("#watch-block").offset().top
		}, 500);
		pzoom = true
	} else {
		$("#watch-block,.breadcrumbs").removeAttr("style");
		$("#media-player-box").animate({
			"height" : "400"
		}, 300);
		$("div.m-right").css({
			"padding-top" : "0"
		});
		$("a._zoom").html("Ph\u00f3ng to");
		$('html, body').animate({
			scrollTop : $("#watch-block").offset().top
		}, 500);
		pzoom = false

	}
	return false
}

function _autonext() {
	if ($.cookie("autonext_xpo")) {
		$("#autonext-status").html("On");
		$.cookie("autonext_xpo", "")
	} else {
		$("#autonext-status").html("Off");
		$.cookie("autonext_xpo", 1)
	}
	return false
}
function load_video(e_id) {
	if (e_id != 0)
		$.post("index.php", {
			nextmovie : 1,
			e_id : e_id
		}, function (data) {
			if (data) {
				$("#media-player-box").html(data);
				$(".episode a").each(function () {
					$(this).removeClass("active")
				});
				$("#" + e_id).addClass("active");
				var nextEpisodeHref = $("#" + e_id).attr("href");
				var nextEpisodeTitle = 'Xem Phim ' + $.trim($('.breadcrumbs h2 span').text());
				var server_title = $("#" + e_id).parent().parent().find('.name').text();
				var episode_title = $("#" + e_id).attr("title");
				window.history.pushState(null, nextEpisodeTitle + ' ' + server_title + ' ' + episode_title, nextEpisodeHref);
				document.title = episode_title;
				if ($('.breadcrumbs .item.last-child').length > 0) {
					$('.breadcrumbs .item.last-child').html(server_title + ' ' + episode_title);
				}
				$('html, body').animate({
					scrollTop : $("#watch-block").offset().top
				}, 500);
				if (pzoom)
					zoom_css()
			}
		});
}
function download(e_id) {
	if (e_id != 0)
		$.post("index.php", {
			download : 1,
			e_id : e_id
		}, function (data) {
			if (data) {
				$("#download").html(data);
				$('#download').show(800);
			}
		});
}
function xpo_next_video(e_id) {
	if (!$.cookie("autonext_xpo")) {
		load_video(e_id);
	}
}

function dienvien(a) {
	$.post("index.php", {
		dienvien : 1,
		page : a
	}, function (a) {
		html = a.split("{***}");
		$("#dien-vien-show").append(html[0]);
		html[1] ? $("#show-actor-click").html(html[1]) : $("#show-actor-click").remove()
	})
}

function filmdienvien(a, b) {
	$.post("index.php", {
		filmdienvien : 1,
		key : a,
		page : b
	}, function (a) {
		$("#show-film-click").remove();
		$("#dien-vien-show-film").append(a)
	});
	return !1
}

function fetch_episodesaved(a) {
	var b = PHP.unserialize($.cookie("episode_saved")) || {};
	var c = b[a];
	if ($.isNumeric(c)) {
		if ($(".list-server a#" + c).length) {
			load_episode($(".list-server a#" + c))
		}
	}
}

$(document).ready(function () {
	$(".list-episode").find("a").click(function () {
		if ($(this).attr("data-type") != "down") {
			var current_id = $(this).attr('id');
			load_video(current_id);
		}
		return false;
	});
	if ($.cookie("autonext_xpo"))
		$("#autonext-status").html("Off");
	else
		$("#autonext-status").html("On");
	$("#searchInput").autocomplete("search.php", {
		width : 600,
		max : 30,
		highlight : !1,
		scroll : !1
	});
	$("#nav_menu li").hover(function () {
		$(this).addClass("activer");
		$(this).find("ul:first").show(200)
	}, function () {
		$(this).removeClass("activer");
		$(this).find("ul:first").hide()
	})
	$(".film_action .star_items .rate").mouseenter(function () {
		filmid = $("#filmid").val();
		star = $(this).attr("data-id");
		if (filmid) {
			$.each($(this).parent().find(".rate"), function (a) {
				$(this).removeClass("none half full");
				if (a < star) {
					$(this).addClass("full")
				}
			});
			$(".rate_result").hide();
			$(".star_meaning").text($(this).attr("data-meaning"))
		}
	}).mouseleave(function () {
		if (filmid) {
			$.each($(this).parent().find(".rate"), function (a) {
				$(this).removeClass("none full").addClass($(this).attr("data"))
			});
			$(".rate_result").show();
			$(".star_meaning").text("")
		}
	}).click(function () {
		if (filmid) {
			rate_film(filmid, star);
			filmid = null;
			$("#filmid").val(null)
		}
	});	
});
//info - js
$(document).ready(function () {
	$("#mobile").click(function () {
		jAlert('Vui Lòng Xem Phim Bằng Điện Thoại', 'Thông Báo');
	});
	$("#update").click(function () {
		jAlert('Đang Cập Nhật', 'Thông Báo');
	});
	$("#bookmark").click(function () {
		jAlert('Chức Năng Này Đang Cập Nhật', 'Thông Báo');
	});
	$("#bookmark2").click(function () {
		jAlert('Chức Năng Này Đang Cập Nhật', 'Thông Báo');
	});
	$("#bookmark3").click(function () {
		jAlert('Chức Năng Này Đang Cập Nhật', 'Thông Báo');
	});
});
/* $("#phim18").click( function() {
jConfirm('Phim Có Nội Dung 18+, Bạn Đã Trên 18 Tuổi Hay Chưa.', 'Thông Báo', function(r) {
jAlert('Confirmed: ' + r, 'Confirmation Results');
});
});
 *///tab info
 function rate_film(a,b) {
 	$.post("index.php", {
		rating : 1,
		film_id : a,
		star : b
	}, function (data) {
		if (data) {
			$(".star_items").html(data);
			showmess('Cảm ơn bạn đã bình chọn cho bộ phim này!', 'success');
		}
	});
	return false;
}
 
function tab(a, b) {
	var c = $("#tab_" + a + "_" + b);
	var d = $("#tab_ct_" + a + "_" + b);
	$("#" + a + " .tabs li, #" + a + " .tab_ct").removeClass("c");
	c.addClass('c');
	d.addClass('c');
}
function filmBox(film_id) {
	$.post("index.php", {
		filmBox : 1,
		film_id : film_id
	}, function (c) {
		if (c == 1) {
			showmess('Bạn vui lòng đăng nhập để sử dụng chức năng này!', 'warning');
		} else if (c == 2) {
			showmess('Phim này đã được xóa ra khỏi tủ phim của bạn!!', 'success');
			document.getElementById("btn-text_add").innerHTML = 'Thêm vào tủ phim';

		} else if (c == 3) {
			showmess('Phim này đã được thêm vào tủ phim của bạn!', 'success');
			document.getElementById("btn-text_add").innerHTML = 'Xóa khỏi tủ phim';
		}
	});

	return false;
}
function ip_error(film_id, episode_id) {

	$.post("index.php", {
		error : 1,
		film_id : film_id,
		episode_id : episode_id
	}, function (c) {
		if (c == 1) {
			showmess('Thông báo của bạn đã được gửi đi, BQT sẽ khắc phục trong thời gian sớm nhất. Thank!', 'success');
		}
	});

	return false;
}
function showmess(a, type) {
	showNotification({
		type : type,
		/* gá»“m: information,warning,error,success */
		message : a,
		autoClose : true,
		duration : 2 /* Ä‘Ă³ng sau 2s */
	});
}
function google(ss) {
	(function ($) {
		var config = {
			siteURL : ss, // Change this to your site
			searchSite : true,
			type : 'web',
			append : false,
			perPage : 8, // A maximum of 8 is allowed by Google
			page : 0 // The start page
		}

		// The small arrow that marks the active search icon:
		var arrow = $('<span>', {
				className : 'arrow'
			}).appendTo('ul.icons');

		$('ul.icons li').click(function () {
			var el = $(this);

			if (el.hasClass('active')) {
				// The icon is already active, exit
				return false;
			}

			el.siblings().removeClass('active');
			el.addClass('active');

			// Move the arrow below this icon
			arrow.stop().animate({
				left : el.position().left,
				marginLeft : (el.width() / 2) - 4
			});

			// Set the search type
			config.type = el.attr('data-searchType');
			$('#more').fadeOut();
		});

		// Adding the site domain as a label for the first radio button:
		$('#siteNameLabel').append(' ' + config.siteURL);

		// Marking the Search tutorialzine.com radio as active:
		$('#searchSite').click();

		// Marking the web search icon as active:
		$('li.web').click();

		// Focusing the input text box:
		$('#s').focus();

		$('#searchForm').submit(function () {
			googleSearch();
			return false;
		});

		$('#searchSite,#searchWeb').change(function () {
			// Listening for a click on one of the radio buttons.
			// config.searchSite is either true or false.

			config.searchSite = this.id == 'searchSite';
		});

		function googleSearch(settings) {

			// If no parameters are supplied to the function,
			// it takes its defaults from the config object above:

			settings = $.extend({}, config, settings);
			settings.term = settings.term || $('#s').val();

			if (settings.searchSite) {
				// Using the Google site:example.com to limit the search to a
				// specific domain:
				settings.term = 'site:' + settings.siteURL + ' ' + settings.term;
			}

			// URL of Google's AJAX search API
			var apiURL = 'http://ajax.googleapis.com/ajax/services/search/' + settings.type + '?v=1.0&callback=?';
			var resultsDiv = $('#resultsDiv');

			$.getJSON(apiURL, {
				q : settings.term,
				rsz : settings.perPage,
				start : settings.page * settings.perPage
			}, function (r) {

				var results = r.responseData.results;
				$('#more').remove();

				if (results.length) {

					// If results were returned, add them to a pageContainer div,
					// after which append them to the #resultsDiv:

					var pageContainer = $('<div>', {
							className : 'pageContainer'
						});

					for (var i = 0; i < results.length; i++) {
						// Creating a new result object and firing its toString method:
						pageContainer.append(new result(results[i]) + '');
					}

					if (!settings.append) {
						// This is executed when running a new search,
						// instead of clicking on the More button:
						resultsDiv.empty();
					}

					pageContainer.append('<div class="clear"></div>')
					.hide().appendTo(resultsDiv)
					.fadeIn('slow');

					var cursor = r.responseData.cursor;

					// Checking if there are more pages with results,
					// and deciding whether to show the More button:

					if (+cursor.estimatedResultCount > (settings.page + 1) * settings.perPage) {
						$('<div>', {
							id : 'more'
						}).appendTo(resultsDiv).click(function () {
							googleSearch({
								append : true,
								page : settings.page + 1
							});
							$(this).fadeOut();
						});
					}
				} else {

					// No results were found for this search.

					resultsDiv.empty();
					$('<p>', {
						className : 'notFound',
						html : 'No Results Were Found!'
					}).hide().appendTo(resultsDiv).fadeIn();
				}
			});
		}

		function result(r) {

			// This is class definition. Object of this class are created for
			// each result. The markup is generated by the .toString() method.

			var arr = [];

			// GsearchResultClass is passed by the google API
			switch (r.GsearchResultClass) {

			case 'GwebSearch':
				arr = [
					'<div class="webResult">',
					'<h2><a href="', r.unescapedUrl, '" target="_blank">', r.title, '</a></h2>',
					'<p>', r.content, '</p>',
					//'<a href="',r.unescapedUrl,'" target="_blank">',r.visibleUrl,'</a>',
					'</div>'
				];
				break;
			case 'GimageSearch':
				arr = [
					'<div class="imageResult">',
					'<a target="_blank" href="', r.unescapedUrl, '" title="', r.titleNoFormatting, '" class="pic" style="width:', r.tbWidth, 'px;height:', r.tbHeight, 'px;">',
					'<img src="', r.tbUrl, '" width="', r.tbWidth, '" height="', r.tbHeight, '" /></a>',
					'<div class="clear"></div>', '<a href="', r.originalContextUrl, '" target="_blank">', r.visibleUrl, '</a>',
					'</div>'
				];
				break;
			case 'GvideoSearch':
				arr = [
					'<div class="imageResult">',
					'<a target="_blank" href="', r.url, '" title="', r.titleNoFormatting, '" class="pic" style="width:150px;height:auto;">',
					'<img src="', r.tbUrl, '" width="100%" /></a>',
					'<div class="clear"></div>', '<a href="', r.originalContextUrl, '" target="_blank">', r.publisher, '</a>',
					'</div>'
				];
				break;
			case 'GnewsSearch':
				arr = [
					'<div class="webResult">',
					'<h2><a href="', r.unescapedUrl, '" target="_blank">', r.title, '</a></h2>',
					'<p>', r.content, '</p>',
					'<a href="', r.unescapedUrl, '" target="_blank">', r.publisher, '</a>',
					'</div>'
				];
				break;
			}

			// The toString method.
			this.toString = function () {
				return arr.join('');
			}
		}
		$('#searchForm').submit();
	})(jQuery);
}

function creatlink(link) {
	var a = document.getElementById('down-ep');
	a.href = link
}
function list_comment(comment_film, page) {
	$("#show-click").html('<a></a>').addClass('loading');
	var data_post = {
		showcomment : 1,
		comment_film : comment_film,
		page : page
	}
	$.post('index.php', data_post, function (data) {
		$("#show-click").remove();
		if (page == 1)
			$('div.comment-list').hide().html(data).fadeIn(300);
		else
			$('div.comment-list').append(data);
		send_comment = true;
	});
	return false;
}
var send_comment = true;
function submit_comment(comment_film) {
	if (send_comment) {
		if (iplogin) {
			var comment_content = $("textarea[name='message']").val();
			var data_post = {
				comment : 1,
				comment_film : comment_film,
				comment_content : comment_content
			}
			if (!comment_content) {
				jAlert("Vui lòng nhập nội dung bình luận!", "Thông Báo");
			} else {
				if (comment_content.length < 10 || comment_content.length > 500) {
					jAlert("Nội dung bình luận phải chứa từ 10 đến 500 ký tự!", "Thông Báo");
				} else {
					$(".comment-form .submit").addClass('loading');
					send_comment = false;
					$.post('index.php', data_post, function (data) {
						if (data == 1) {
							jAlert("Bạn chưa đăng nhập, vui lòng đăng nhập để gửi bình luận!", "Thông Báo");
						} else {
							if (data == 2) {
								$("textarea[name='message']").val('');
								list_comment(comment_film, 1);
								$(".comment-form .submit").removeClass('loading');
							} else {
								jAlert(data);
							}
						}
					})
				}
			}
		} else {
			jAlert("Bạn chưa đăng nhập, vui lòng đăng nhập để gửi bình luận!", "Thông Báo");
		}
	}
	return false;
}

//#######################################
//# favorite
//#######################################
function favo(islogin, film_id) {
	if (islogin == 0) {
		jAlert("Bạn phải đăng nhập để sử dụng chức năng này! Cám ơn bạn!", "Thông Báo");
	} else {
		set_loading(true);
		$.post("index.php", {
			favo : 1,
			film_id : film_id
		}, function (data) {
			set_loading(false);
			if (data == 'err')
				jAlert("Phim này đã thêm rồi!", "Thông Báo");
			else {
				jAlert('Thêm vào tủ phim thành công', "Thông Báo");
			}
		});
	}
	return false;
}
function unfavo(film_id) {
	try {
		http.open('POST', 'index.php');
		http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		http.onreadystatechange = function () {
			if ((http.readyState == 4) && (http.status == 200)) {
				jAlert("Đã bỏ phim này khỏi danh sách ưa thích của bạn! Cám ơn bạn!", "Thông Báo");
			}
		}
		http.send('unfavo=1&film_id=' + film_id);
	} catch (e) {}
	finally {}
	return false;
}
/*
function remove_film(filmid,type) {
set_loading(true);
$.post('index.php', {
unfavo: 1,
filmid: filmid,
type: type
}, function (data) {
set_loading(false);
if(data) $(".film_"+filmid+'-'+type).remove();
});
return false;
} */