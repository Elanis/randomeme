<?php
/* Launch framework ! */
include('./lib/init.php');

/**********************
 * Display Errors
 **********************/
ini_set('display_errors','on');
error_reporting(E_ALL);

/**********************
 * Database Connection
 **********************/
try {
$bd = new PDO('mysql:host=mysql;dbname=randomeme', 'randomeme', '***REMOVED***');
}
catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
}

/**********************
 * Mute GET or COOKIE
 **********************/
if((isset($_GET['mute'])&&((int) $_GET['mute']==1)) or (isset($_COOKIE['mute'])&&((int) $_COOKIE['mute']==1))) {
	$volume = 0;
} else {
	$volume = 0.2;
}

/**********************
 * Meme asked
 **********************/
$f = (string) $_SERVER['REQUEST_URI']; // Transforme en chaine de caracteres
$f = (strstr($f,"?",true)=="")?$f:strstr($f,"?",true); // On retire les arguments GET
$f = str_replace('/','',$f); // On retire les /
$f = substr($f, 0, 5); // On reduit à 5 caracteres

/**********************
 * Disallow Subfolders
 **********************/
if(('/'.$f!=$_SERVER['REQUEST_URI'])&&('/'.$f."?mute=1"!=$_SERVER['REQUEST_URI'])) {
	if(isset($_GET['mute'])&&((int) $_GET['mute']==1)) { $f = $f."?mute=1"; } // On remet l'argument GET
	header("Location: ***REMOVED***/".$f);
}

/**********************
 * Recuperation SQL ...
 **********************/
$query = $bd->prepare('SELECT * FROM memes WHERE LOWER(link)=LOWER(:link)');
$query->bindValue(':link',$f,PDO::PARAM_STR);
$query->execute();
$data = $query->fetch();
$query->CloseCursor();

/**********************
 * ... ou Random meme
 **********************/
while(empty($data)||!isset($data["link"])||empty($data["link"])||$data["link"]==""||(isset($_SESSION['historique'])&&$data["link"]==$_SESSION['historique'] && $f != $data["link"])) {
	$query = $bd->prepare('SELECT * FROM memes ORDER BY RAND() LIMIT 1'); //SELECT SQL_NO_CACHE * FROM memes WHERE RAND() > 0.9 ORDER BY RAND( ) LIMIT 1
	$query->execute();
	$data = $query->fetch();
	$query->CloseCursor();
}

// Add to history
$_SESSION['historique'] = $data["link"];
// Stats full support
// Not working yet
$_SERVER['REQUEST_URI'] = ($f==$data["link"])?$data["link"]:"random-".$data["link"];

/**********************
 * Code HTML
 **********************/
?>
	<script type="text/javascript">
		if(!existCookie("mute")) {
			setCookie("mute", <?php echo (isset($_GET['mute'])&&((int) $_GET['mute']==1))?"1":"0"; ?>, 31);
		}
	</script>
	<body>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v2.8";
		  fjs.parentNode.insertBefore(js, fjs);
		  }(document, 'script', 'facebook-jssdk'));</script>

		<header>
			<!-- Title -->
			<div id="title"><?php echo $data["nom"]; ?></div>
			<div id="buttons">
				<!-- Twitter -->
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="***REMOVED***/<?php echo $data["link"]; ?>" data-text="That meme is amazing !" data-hashtags="Randomeme">Tweet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

				<!-- Facebook -->
				<div class="fb-share-button" data-href="***REMOVED***/<?php echo $data["link"]; ?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Frandomeme.xyz%2F<?php echo $data["link"]; ?>&amp;src=sdkpreparse">Share</a></div>

				<!-- Get new meme -->
				<img alt="get new meme" src="img/get-new.png" id="get-new">

				<!-- Get the link -->
				<img alt="link" src="img/link.png" id="link">

				<!-- Mute button -->
				<?php 
				if($volume==0) {
					echo'<img alt="mute" src="img/volume-off.png" id="volume" alt="volume">';
				} else {
					echo'<img alt="mute" src="img/volume-on.png" id="volume" alt="volume">';
				} ?>

				<!-- Fullscreen button -->
				<img src="img/fullscreen-expand.png" id="fullscreen" alt="fullscreen">
			</div>		
		</header>

		<!-- Link -->
		<textarea id="link-to-copy">***REMOVED***/<?php echo $data["link"]; ?></textarea>
		<p id="link-overlay">Link Copied !</p>

		<!-- Content -->
		<?php
		switch($data["type"]) {
			case 0: // Video
			?>
				<video id="video" src="https://***REMOVED***/randomeme/<?php echo $data["link"]; ?>.mp4" preload="metadata" loop></video>
				<!-- Preload Video
					auto	The author thinks that the browser should load the entire video when the page loads
					metadata	The author thinks that the browser should load only metadata when the page loads
					none	The author thinks that the browser should NOT load the video when the page loads
				-->
				<div id="adContainer"></div>
				<img id="play" src="img/play.png">

				<script type="text/javascript">
				// Play on load
				window.addEventListener('load', function() {
					var video = document.getElementById("video");
					video.volume = <?php echo $volume; ?>;
					video.play();

					if(video.paused) {
						document.getElementById("play").style.display = "block"; /* That's Just for android */
					}
				});

				//Android Compatibility
				window.addEventListener('touchstart', function() {
					video.play();	
					document.getElementById("play").style.display = "none";
					this.removeEventListener('touchstart', videoStart);
				})
				</script>
			<?php
			break;
			case 1: // Audio + Image
			?>
			<audio id="audio" src="sounds/<?php echo $data["link"]; ?>.mp3"></audio>
			<script type="text/javascript">
			// Play on load
			window.addEventListener('load', function() {
				var sound = document.getElementById("sound");
				document.body.style.backgroundImage = "url('img/"+<?php echo data["link"]; ?>+".png')";
				sound.volume = <?php echo $volume; ?>;
				sound.play();
			});
			</script>
			<?php
			break;
			case 2: // Gif

			break;
			default: // Wtf ?!
				echo "ERROR: Wrong media Type";
		} ?>
		<!-- Footer -->
		<footer>
			<div class="credits">
			Copyright 2016 - <?php echo date("Y"); ?> - <a href="***REMOVED***/" target="_blank">Website By Elanis</a> - All contents are property of their own creators - If you want add/modify/delete content, please contact me. - <a href="***REMOVED***/contact.php" target="_blank">Contact</a>
			- This video is distributed under  
				<?php 
				if(!empty($data["copyrightLink"])&&$data["copyrightLink"]!="") {
					echo "<a href=\"".$data["copyrightLink"]."\" target=\"_blank\">".$data["copyrightType"]."</a>";
				} else {
					echo $data["copyrightType"];
				}
				?> license.</div>
			<div class="author">
			By 
				<?php 
				if(!empty($data["website"])&&$data["website"]!="") {
					echo "<a href=\"".$data["website"]."\" target=\"_blank\">".$data["author"]."</a>";
				} else {
					echo $data["author"];
				}
				?> 
			</div>
		</footer>
	</body>
</html>