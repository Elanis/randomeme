window.addEventListener('load', function() {

	/*****************************
			Get a new Meme        
	*****************************/
	document.getElementById("get-new").addEventListener('click', function() {
		window.location.href="***REMOVED***";
	});

	/*************************
			Copy Link
	*************************/
	var toCopy  = document.getElementById('link-to-copy'),
	    btnCopy = document.getElementById('link');
	    overlayCopy = document.getElementById('link-overlay');

	btnCopy.addEventListener( 'click', function(){
		overlayCopy.classList.add('fade-in');
		setTimeout(function(){ 
			overlayCopy.classList.remove('fade-in');
			overlayCopy.classList.add('fade-out');
			setTimeout(function(){
			overlayCopy.classList.remove('fade-out');
			}, 500);
		}, 3000);
		toCopy.select();
		document.execCommand( 'copy' );
		return false;
	} );

	/***************************
			Mute Button
	***************************/
	var volumeDOM = document.getElementById("volume");

	volumeDOM.addEventListener('click', function() {
		if(video.volume==0) {
			video.volume = 0.2;
			volumeDOM.src = "img/volume-on.png";
			setCookie("mute",0);
		} else {
			video.volume = 0;
			volumeDOM.src = "img/volume-off.png";
			setCookie("mute",1);
		}
	});

	/**************************
			FullScreen
	**************************/
	var fullScreenDOM = document.getElementById("fullscreen");

	fullScreenDOM.addEventListener('click', function() {
		toggleFullScreen();
		if(fullScreenDOM.src=="***REMOVED***/img/fullscreen-collapse.png"||fullScreenDOM.src=="img/fullscreen-collapse.png") {
			fullScreenDOM.src="img/fullscreen-expand.png";
		} else {
			fullScreenDOM.src="img/fullscreen-collapse.png";
		}
	});

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
	}
});