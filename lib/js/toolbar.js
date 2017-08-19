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
		status = (status==1 || status==true)? 1 : 0;

		setCookie("mute",parseInt(status),31);

		if(status) {
			$('#volume-mute').attr("src","img/volume-off.png");
		} else {
			$('#volume-mute').attr("src","img/volume-on.png");
		}
	}

	$('#volume-mute').click(function() {
		setMute((!($('#video').prop('muted')==1)));
	});

	setMute(getCookie('mute'));

	/***************************
			  Volume
	***************************/
	if(!existCookie('volume')) {
		setCookie('volume',0.2,31);
	}

	function setVolume(volume) {
		if((volume==NaN) || (volume=="NaN")) {
			volume = 0.2;
		}

		$('#video').prop('volume',volume);
		setCookie("volume",parseFloat(volume),31);
	}

	setVolume(getCookie('volume'));	

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
				$('#fullscreen').attr("src","img/fullscreen-collapse.png");
			} else {
				$('#fullscreen').attr("src","img/fullscreen-expand.png");
			}
		})
	});
};