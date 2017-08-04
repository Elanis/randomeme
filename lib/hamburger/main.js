window.addEventListener('load', function() {
	var hamburger = document.getElementById("hamburger");
	var menu = document.getElementById("menu");

	var boutonsMenu = document.getElementsByClassName('menuAncre');
	for(var i = 0; i < boutonsMenu.length; i++) {
	    var bouton = boutonsMenu[i];
	    bouton.onclick = function() {
	        CloseMenu();
	    }
	}

	hamburger.addEventListener('click', function() {
		if(menu.classList.contains('menu')) {
			CloseMenu();
		} else {
			menu.classList.add('menu');
		}
	});

	function CloseMenu() {
		menu.classList.remove('menu');
		menu.classList.add('menu-bye');
		setTimeout(function() {
			menu.classList.remove('menu-bye');
		},1450);
	}
});