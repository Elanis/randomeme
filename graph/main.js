/**
 * Draw a circle graph with percentage 
 *
 * @param      {number}  percent  Percent drawed
 * @param      {<type>}  name     Name of graph
 * @param      {<type>}  color    Color of graph
 */
function percentCircle(percent,name,color)
{
  var datalist= new Array(percent, 100-percent);
  var colist = new Array(color,'grey');
  var canvas = document.getElementById(name);
  var w = canvas.width
  var h = canvas.height
  var ctx = canvas.getContext('2d');
  var radius = h / 2 - 5;
  var centerx = w / 2;
  var centery = h / 2;
  var total = 0;
  for(x=0; x < datalist.length; x++) { total += datalist[x]; };
  var lastend= 0;
  var offset = Math.PI / 2;
  for(x=0; x < datalist.length; x++)
  {
    var thispart = datalist[x];
    ctx.beginPath();
    ctx.fillStyle = colist[x];
    ctx.moveTo(centerx,centery);
    var arcsector = Math.PI * (2 * thispart / total);
    ctx.arc(centerx, centery, radius, lastend - offset, lastend + arcsector - offset, false);
    ctx.lineTo(centerx, centery);
    ctx.fill();
    ctx.closePath();
    lastend += arcsector;
  }
}

/**
 * Draw a linear graph
 *
 * @param      {number}  percent  Percent drawed
 * @param      {<type>}  name     Name of graph
 * @param      {<type>}  color    Color of graph
 */
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