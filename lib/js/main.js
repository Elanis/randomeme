/* Facebook button */
(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "https://connect.facebook.net/fr_FR/all.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

/* Twitter button */
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');

$(document).ready(function() {
	// Init toolbar
	initToolbar();

	switch(memeType) {
		case 0: // Video
			$("#video").get(0).play();
			
			if($("#video").get(0).paused) {
				$("#play").css("display","block"); /* That's Just for android */
			}

			$(window).one('touchstart', function() { // This event will be played once
				$("#video").get(0).play();
				$("#play").css("display","none");

			});
			break;
		case 1: // Audio
			$("#sound").get(0).play();
			break;
		case 2: // Gif
			// @ADD: Do some stuff here
			break;
		default: // Wtf ?!
			// Do nothing
	}

});