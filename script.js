function getXMLHttpRequest() {
	var xhr = null;
	
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
		return null;
	}
	
	return xhr;
}

function request(callback,value) {

    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };

    xhr.open("GET", "verif.php?"+value, true);
    xhr.send(null);
}

function check(xhr) {
   
    document.getElementById("testajax").innerHTML = xhr;
}

request(check);
$(document).ready(function(){

 $(function () { $('#activity').jstree(); });
 $(function () { $('#local').jstree(); });
 $(function () { $('#test').jstree(); });

 $.jstree.defaults.core.themes.variant = "small";
});
