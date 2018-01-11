<?php
/* Launch framework ! */
include('./lib/init.php');

/**
 * Display Errors
 */
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
if(!isset($_COOKIE['mute']) || isset($_GET['mute'])) {
	$mute = (isset($_GET['mute']))?(int)$_GET['mute']:0;

	echo '<script type="text/javascript">setCookie("mute",'.$mute.',31);</script>';
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
$arg1 = "";
$arg2 = "";
$arg3 = "";

if(isset($_GET['mute'])) {
	$arg1 = "mute=".((string) $_GET['mute']);
}

if(isset($_GET['cookies_accepted'])) {
	$arg2 = "cookies_accepted=".((string) $_GET['cookies_accepted']);
}

if($arg1!="" && $arg2 !="") {
	$arg3 = "&";
}

$comp1 = '/'.$f.'?'.$arg1.$arg3.$arg2;
$comp2 = '/'.$f.'?'.$arg2.$arg3.$arg1;

if(('/'.$f!=$_SERVER['REQUEST_URI'])&&
	($comp1!=$_SERVER['REQUEST_URI'])&&
	($comp2!=$_SERVER['REQUEST_URI'])) {

	if(isset($_GET['mute'])&&((int) $_GET['mute']==1)) { $f = $f."?mute=1"; } // On remet l'argument GET
	if(isset($_GET['cookies_accepted'])&&((int) $_GET['cookies_accepted']==1)) { 
		if(isset($_GET['mute'])&&((int) $_GET['mute']==1)) {
			$f = $f."&cookies_accepted=1";
		} else {
			$f = $f."?cookies_accepted=1";
		}
	 } // On remet l'argument GET
 
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

/**
 * Ads
 */
if(isset($_SESSION['memeViewed']) && is_int($_SESSION['memeViewed']) && $_SESSION['memeViewed'] > 3) {
	$adChance = $_SESSION['memeViewed'] * 0.07;
} else if(isset($_SESSION['memeViewed']) && is_int($_SESSION['memeViewed']) && ($_SESSION['memeViewed']==1 || $_SESSION['memeViewed']==2 || $_SESSION['memeViewed']==3)) {
	$adChance = 0;
} else {
	$adChance = 0;
	$_SESSION['memeViewed'] = 1;
}

if($data !== false && !(empty($data)||!isset($data["link"])||empty($data["link"])||$data["link"]==""||(isset($_SESSION['historique'])&&$data["link"]==$_SESSION['historique'] && $f != $data["link"]))) {

/**
 * Twitter cards
 */
?>
	<meta name="twitter:card" content="player" />
	<meta name="twitter:creator" content="@ElanisGaming" />
	<meta name="twitter:title" content="<?php echo $data["nom"]; ?>" />
	<meta name="twitter:image" content="***REMOVED***/img/background.png" />
	<meta name="twitter:player" content="***REMOVED***/twitter-player/?v=<?php echo $data["link"]; ?>" />
	<meta name="twitter:player:width" content="1920" />
	<meta name="twitter:player:height" content="1080" />

	<meta property="og:title" content="Randomeme - <?php echo $data["nom"]; ?>" />
	<meta property="og:type" content="video.other" />
	<meta property="og:image" content="***REMOVED***/img/background.png" />
	<meta property="og:url" content="***REMOVED***/<?php echo $data["link"]; ?>" />
	<meta property="og:video" content="https://***REMOVED***/randomeme/<?php echo $data["link"]; ?>.mp4" />
	<meta property="og:video:url" content="https://***REMOVED***/randomeme/<?php echo $data["link"]; ?>.mp4" />
	<meta property="og:video:secure_url" content="https://***REMOVED***/randomeme/<?php echo $data["link"]; ?>.mp4" />
	<meta property="og:video:type" content="video/mp4" />
	<meta property="og:image:width" content="1280" />
	<meta property="og:image:height" content="720" />
<?php
	$adChance = 0;
}


if($adChance > mt_rand(0,1)) {
/**********************
 * Code HTML
 **********************/
?>
		</head>
		<body>
		<div id="global-div" class="centered-div">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- Randomeme - ads -->
			<ins id="randomAd" class="adsbygoogle"
			     style="display:inline-block;width:336px;height:280px"
			     data-ad-client="***REMOVED***"
			     data-ad-slot="***REMOVED***"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>

			<script type="text/javascript" src="lib/js/jquery.min.js"></script>
			<script type="text/javascript">
				$(document).ready(function() {
					if($('#randomAd').length == 0 || $('#randomAd').css('display') == "none") {
						$('#global-div').append('<p class="centered-div-p">This website display only one ad each 4 to 14 memes (it\'s random), please disable your adblocker or whitelist our website, that\'s our single source of money to pay servers and services needed to make that website works.<br/><br/>Thanks.</p><a href="/" id="reload-page" onclick="window.location.reload(); return;">Get a new meme !</a>'); 
					}
				});

			</script>

			<a href="/" id="reload-page" onclick="window.location.reload(); return;">Get a new meme !</a>
		</div>
	</body>
</html>
<?php
$_SESSION['memeViewed'] = 0;
} else {
$_SESSION['memeViewed']++;

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
		</head>
		<body>
		<div id="fb-root"></div>

		<header>
			<!-- Title -->
			<div id="title"><?php echo $data["nom"]; ?></div>
			<div id="buttons">
				<!-- Twitter -->
				<a href="https://twitter.com/share" class="twitter-share-button" data-url="***REMOVED***/<?php echo $data["link"]; ?>" data-text="That meme is amazing !" data-hashtags="Randomeme">Tweet</a>

				<!-- Facebook -->
				<div class="fb-share-button" data-href="***REMOVED***/<?php echo $data["link"]; ?>" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Frandomeme.xyz%2F<?php echo $data["link"]; ?>&amp;src=sdkpreparse">Share</a></div>

				<!-- Get new meme -->
				<img alt="get new meme" src="img/get-new.png" id="get-new">

				<!-- Get the link -->
				<img alt="link" src="img/link.png" id="link">

				<!-- Mute button -->
				<img alt="volume-mute" src="img/volume-on.png" id="volume-mute" alt="volume-mute">

				<!-- Fullscreen button -->
				<img src="img/fullscreen-expand.png" id="fullscreen" alt="fullscreen">
			</div>		
		</header>

		<!-- Link -->
		<textarea id="link-to-copy" readonly>***REMOVED***/<?php echo $data["link"]; ?></textarea>
		<p id="link-overlay">Link Copied !</p>

		<!-- Content -->
		<?php
		echo '<script type="text/javascript">
			var memeType = '.(int) $data["type"].';
			</script>';

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
			<?php
			break;
			case 1: // Audio + Image
			?>
			<audio id="audio" src="sounds/<?php echo $data["link"]; ?>.mp3"></audio>
			<script type="text/javascript">
			document.body.style.backgroundImage = "url('img/"+<?php echo data["link"]; ?>+".png')";
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
		<script type="text/javascript" src="lib/js/jquery.min.js"></script>
		<script type="text/javascript" src="lib/js/toolbar.js"></script>
		<script type="text/javascript" src="lib/js/main.js"></script>
	</body>
</html>
<?php 
}
?>