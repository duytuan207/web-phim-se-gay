var phimvang_mp=0;
var phimvang_mp2=0;
var phimvang_mp3=0;
			function SVIT_ADS_GetCookie(Name){
				var re=new RegExp(Name+"=[^;]+", "i");
				if (document.cookie.match(re)) 
					return decodeURIComponent(document.cookie.match(re)[0].split("=")[1]); 
				return ""
			}

			function SVIT_ADS_SetCookie(name, value, days){
				if (typeof days!="undefined"){ 
					var x= new Date().getTime() + days;
					var expireDate = new Date()
					expireDate.setTime(x)
					
					document.cookie = name+"="+decodeURIComponent(value)+"; expires="+expireDate.toUTCString()
				}
				else document.cookie = name+"="+decodeURIComponent(value);
			}

			function vtlai_popup()
			{
							   
					var cookie_popup_ads = SVIT_ADS_GetCookie('phimvang_mp_popup_ads');
					if (cookie_popup_ads=='') {
					   if(phimvang_mp==0)
						{
							phimvang_mp=1;
							var Time_expires = 60*60*1*1000;
							SVIT_ADS_SetCookie('phimvang_mp_popup_ads','true',Time_expires);
							var params = 'width=' + '600';
							params += ', height=' + '600';
							params += ',scrollbars=yes,status=1,toolbar=1,menubar=1,resizable=1,location=1,directories=1';
							var params_f = 'fullscreen=yes,scrollbars=yes,status=1,toolbar=1,menubar=1,resizable=1,location=1,directories=1';					
							//var vtlai_popup_1 = window.open('http://nhanh.vn/promotion/popup.html?utm_source=phim30s.com&utm_medium=pop&utm_campaign=ht', 'vtlai_popup_1',params1);//27--09 den 27--010
							//var vtlai_popup_1 = window.open('http://cucre.vatgia.com/vn/cucre_vatgia.html?utm_source=phim30s.com&utm_medium=popup&utm_campaign=tnt',params1);//00h00 25/9/2012 ---> 00h00 25/10/2012
							
		window.focus();
						}

					}
		
				var cookie_test = SVIT_ADS_GetCookie('phimvang_mp_popup_ads_test');
				if (cookie_test=='')
				{
					if(phimvang_mp2==0)
						{
							phimvang_mp2=1;
							var Time_expires = 60*60*4*1000;
							SVIT_ADS_SetCookie('phimvang_mp_popup_ads_test','true',Time_expires);
							var params1 = 'width=' + '600';
							params1 += ', height=' + '600';
							params1 += ',scrollbars=yes,status=1,toolbar=1,menubar=1,resizable=1,location=1,directories=1';
							 //var vtlai_popup_4 = window.open('http://adf.ly/CXTgJ',params1,'height=10,width=10,right=3600,top=3600,location=0,toolbar=0,status=0,menubar=0,scrollbars=0,resizable=0');//00h00 9/1/2012 ---> 00h00 16/1/2012
							
							window.focus();
				
				
				}
			}
				
				//bao kim.vn
				var cookie_test = SVIT_ADS_GetCookie('phimvang_mp_popup_baokim');
				if (cookie_test=='')
				{
					if(phimvang_mp3==0)
						{
							phimvang_mp3=1;
							var Time_expires = 60*60*6*1000;
							SVIT_ADS_SetCookie('phimvang_mp_popup_baokim','true',Time_expires);
							var params1 = 'width=' + '600';
							params1 += ', height=' + '600';
							params1 += ',scrollbars=yes,status=1,toolbar=1,menubar=1,resizable=1,location=1,directories=1';	
							var vtlai_popup_2 = window.open('http://imgs.somo.vn/phim30s/sieu-pham-webgame.html', 'vtlai_popup_2');//07.11.2013	
							//var vtlai_popup_2 = window.open('http://xvideos47.com/forums/13-LAUXANH-Cave-gai-goi', 'vtlai_popup_2','height=350,width=200,right=3600,top=3600,location=0,toolbar=0,status=0,menubar=0,scrollbars=0,resizable=0');// /26.12
							//var vtlai_popup_3 = window.open('http://gg.thienhanhkiem2.com/?_c=2342', 'vtlai_popup_3'); // 04.12.2013
							//var vtlai_popup_3 = window.open('http://mp3.zing.vn/bai-hat/Anh-Dau-Dinh-Khoc-Nguyen-Khoi/ZW6ZBUO9.html', 'vtlai_popup_3','height=10,width=10,right=3600,top=3600,location=0,toolbar=0,status=0,menubar=0,scrollbars=0,resizable=0');// /26.12
							//var vtlai_popup_4 = window.open('http://www.caytre.com', 'vtlai_popup_4'); // 19 thang 02 den 31 thang 03 2013	
							//var vtlai_popup_5 = window.open('http://hay30s.com/phimsex.html', 'vtlai_popup_5','height=10,width=10,right=3600,top=3600,location=0,toolbar=0,status=0,menubar=0,scrollbars=0,resizable=0'); // 20.03.2013 het han
							//var vtlai_popup_6 = window.open('http://7vui.com/hen-xui', 'vtlai_popup_6'); // 03.2.2013 den 08.04.2013
							//var vtlai_popup_7 = window.open('http://bit.ly/hZA7Db', 'vtlai_popup_7'); // 19.03.2013 den 19.04.2013
												
							//var vtlai_popup_8 = window.open('http://app.adsoctopus.com/getlink/redirect?utm_source=hay30s&pos=6', 'vtlai_popup_8'); //  23.04.2013 den 23.05.2013
							//var vtlai_popup_9 = window.open('http://baocaotieuluan.com/web/', 'vtlai_popup_9'); //27.10.2013 1 tuáº§n		
							window.focus();
				
				
				}
			}
		}