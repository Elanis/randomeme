function initToolbar() {
	/*****************************
			Get a new Meme        
	*****************************/
	$('#get-new').click(function() {
		window.location.href = "***REMOVED***";
	});

	/*************************
			Copy Link
	*************************/
	$("#link").click(function() {
		/* Fade in and out for link overlay */
		$("#link-overlay").addClass('fade-in');

		setTimeout(function(){ 
			$("#link-overlay").removeClass('fade-in');
			$("#link-overlay").addClass('fade-out');

			$("#link-overlay")(function(){
				$("#link-overlay").classList.removeClass('fade-out');
			}, 500);
		}, 3000);

		document.getElementById('link-to-copy').select();
		document.execCommand( 'copy' );
		return false;
	});

	/***************************
			Mute Button
	***************************/
	function setMute(status) {
		$('#video').prop('muted',status);
		setCookie("mute",parseInt(status),31);

		if(status) {
			$('#volume').src("img/volume-off.png");
		} else {
			$('#volume').src("img/volume-on.png");
		}
	}

	$('#volume').click(function() {
		setMute((!$('#video').prop('muted')));
	});

	setMute(getCookie('mute'));

	/***************************
			Mute Button
	***************************/
	if(!existCookie('volume')) {
		setCookie('volume',0.2,31)
	}

	/**************************
			FullScreen
	**************************/
	var fullscreenEnabled = (!document.fullscreenElement && !document.mozFullScreenElement && !document.webkitFullscreenElement);

	function toggleFullScreen() {
	  if (!document.fullscreenElement &&    // alternative standard method
	      !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
	    if (document.documentElement.requestFullscreen) {
	      document.documentElement.requestFullscreen();
	    } else if (document.documentElement.mozRequestFullScreen) {
	      document.documentElement.mozRequestFullScreen();
	    } else if (document.documentElement.webkitRequestFullscreen) {
	      document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
	    }
	  } else {
	    if (document.cancelFullScreen) {
	      document.cancelFullScreen();
	    } else if (document.mozCancelFullScreen) {
	      document.mozCancelFullScreen();
	    } else if (document.webkitCancelFullScreen) {
	      document.webkitCancelFullScreen();
	    }
	  }

	  fullscreenEnabled = !fullscreenEnabled;
	}

	$('#fullscreen').click(function() {
		toggleFullScreen().then(function() {
			if(fullscreenEnabled) {
				$('#fullscreen').src("img/fullscreen-collapse.png");
			} else {
				$('#fullscreen').src("img/fullscreen-expand.png");
			}
		})
	});
};