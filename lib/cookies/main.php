<?php // Librairie de modification des cookies ?>
<script src='./lib/cookies/main.js'></script>

<?php // Message de prevention
function drawCookiePreventionPanel() {
	/* Get Vars from Config */
	global $config;

	if(isset($_GET['cookies_accepted']) && $_GET['cookies_accepted']==1) {
		echo "<script type=\"text/javascript\">
		setCookie(\"cookies_accepted\",1,".$config['cookies-prevention-valid-time'].");
		</script>";
	}

	if($config['cookies-prevention-activated']==true && (!isset($_COOKIE['cookies_accepted']) || $_COOKIE['cookies_accepted']!=1 ) && (!isset($_GET['cookies_accepted']) || $_GET['cookies_accepted']!=1 )) {
		// Is the language module active ? If not, do its work ...
		if($config['module_lang']!="1" && $config['module_lang']!=1) {
			define('COOKIE_STAT_PREVENT',$config['cookies-prevention-default-message']);
		}

		// Default CSS ?
		if($config['cookies-prevention-custom-css']==false) {
		?>
		<style>
			#cookie-prevent {
				position: fixed;
				bottom: 0;
				left: 0;
				width: 100%;

				background-color: #222222;
				color: white;

				margin: 0;

				line-height: 1.1em;
			}
			#cookie-prevent p {
				padding-left: 2em;
				padding-right: 2em;
			}
			#cookie-prevent-close {
				position: absolute;
				right: 5px; 
				bottom: calc(50% - 0.5em);
			}
		</style>
		<?php
		}

		// Echo that div ...
		?>
		<div id="cookie-prevent">
			<p><?php echo COOKIE_STAT_PREVENT; ?></p>
			<span id="cookie-prevent-close">X</span>
		</div>
		<script type="text/javascript">
			document.getElementById("cookie-prevent-close").addEventListener("click",function() {
				var cookie = document.getElementById("cookie-prevent");
				cookie.parentNode.removeChild(cookie);
				setCookie("cookies_accepted",1,<?php echo $config['cookies-prevention-valid-time']; ?>);
			})
		</script>
		<?php
	}
}
?>