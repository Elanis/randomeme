function linearGraph(name,percent,color) {
		var percentContainer = document.getElementById(name);
		percentContainer.innerHTML = "<span class=\"skill-name\">"+ name +"</span><div class=\"percentBar\" id=\"" + name + "-percent\">.</div>";
		var percentBar = document.getElementById(name + "-percent");
		percentBar.style.backgroundColor = color;
		percentBar.style.color = color;

		var percentOne = percent/50; //2 sec to draw
		var currentpercent = 0;
		var intervalID = setInterval(function() {
			currentpercent += percentOne;
			percentBar.style.width = currentpercent + "%";
			if(currentpercent>=percent) {
				clearInterval(intervalID);
			}
		},40);
}