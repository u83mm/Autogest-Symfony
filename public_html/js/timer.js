"use strict";
var count = 60;

function reloj(){
	//var segundos = document.getElementById("segundos");
	if(document.getElementById("segundos") != null) {
		document.getElementById("segundos").innerHTML = count;
		count--;
		if(count < 0) {window.location = "/signout.php";}
	}	
}
