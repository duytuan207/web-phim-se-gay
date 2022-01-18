<?php
if (!defined('IN_MEDIA')) die("Hack");

function players($url,$film_id,$e_id,$type,$width,$height,$sv=0,$film_sub,$postajax=0,$linknext){
    global $mysql, $web_link,$temp,$tb_prefix;
	$stretching			=	"uniform";
	//////////EPISODE//////////
	$epnext	=	$mysql->fetch_array($mysql->query("SELECT episode_type,episode_name FROM ".$tb_prefix."episode WHERE episode_id = ".$e_id));
	$eptype	=	$epnext['episode_type'];
	$q 		= 	$mysql->query("SELECT episode_id,episode_name,episode_type,episode_message,episode_urlsub FROM ".$tb_prefix."episode WHERE episode_film = ".$film_id." AND episode_id > $e_id AND episode_type = $eptype ORDER BY episode_id ASC");
	$r 		= 	$mysql->fetch_array($q);
	if(!$mysql->num_rows($q))
		$nextepid = 0;
	else 
		$nextepid = $r['episode_id'];
	$url 			= $url;
	$gk_url  		= $url;
	$urlmahoa		= $urlk = $url;
	$data			= file_get_contents($web_link.'/video/player.php?url='.urlencode($url));
	$array			= json_decode($data, true);
	$link_sub 		= ($film_sub?$web_link.'/sub/'.$film_sub:$web_link."/sub.xml");
	if($linknext)
	$linknext = "proxy.nextlocation=".$linknext;
	$text = '';
	$time = time();
	if($array[360]){
		$res = 360;
		$text .= '<source src="'.$array[360].'" type="video/mp4" data-res="360" />';
	}
	if($array[480]){
		if(!$res) $res = 480;
		$text .= '<source src="'.$array[480].'" type="video/mp4" data-res="480" />';
	}
	if($array[720])	$text .= '<source src="'.$array[720].'" type="video/mp4" data-res="720" />';
	if($array[1080])	$text .= '<source src="'.$array[1080].'" type="video/mp4" data-res="1080" />';
	$player = '<video id="video_'.$time.'" class="video-js vjs-default-skin" controls autoplay preload="none" width="100%" height="100%" poster="/video/background-player.jpg" data-setup="{}">'.$text.'
        <track kind="subtitles" src="'.$link_sub.'" srclang="en-US" label="English" default></track>
        <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
        </p>
    </video>
    <br>

    <script type="text/javascript">
        videojs("#video_'.$time.'", {
            plugins: {
                resolutionSelector: {
                    default_res: "'.$res.'"
                }
            }
        }, function() {
            var player = this;
            player.on("changeRes", function() {
                console.log("Current Res is: " + player.getCurrentRes());
            });
        });

        videojs("video_'.$time.'").watermark({
            file: "/video/logo.png",
            opacity: 1
        });
		videojs("video_'.$time.'").ready(function(){
			var vid = this;
			vid.on("ended", function(){
				xpo_next_video("'.$nextepid.'");
			});
		});

    </script>';

	return $player;

}
?>