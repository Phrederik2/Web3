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

function request(callback) {

    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };

    xhr.open("GET", "verif.php?test=true", true);
    xhr.send(null);
}

function check(xhr) {
    //alert(xhr);
    document.getElementById("testajax").innerHTML = xhr;
}
request(check);
$(document).ready(function(){

 $(function () { $('#activity').jstree(); });
 $(function () { $('#local').jstree(); });
 $(function () { $('#test').jstree(); });


            /*$('#activity').jstree({
  "plugins" : [ "wholerow", "checkbox" ]
});*/

/*$('#activity').jstree({
  "core" : {
    "themes" : {
      "variant" : "large"
    }
  },
  "checkbox" : {
    "keep_selected_style" : false
  },
  "plugins" : [ "wholerow", "checkbox" ]
});*/
});
