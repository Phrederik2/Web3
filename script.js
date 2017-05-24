/**
 * retourne l'object XMLHttpRequest si il est instanciable
 */
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

/**
 * execute l'object XMLHttpRequest, quand readystate est ok, passe le retour du serveur dans la fonction de callback.
 * 
 * @param function callback function a utiliser au retour de l'object XMLHttpRequest
 * @param string value les jeux de clé/valeur a ajouter au _GET
 */
function request(callback,value) {

    var xhr = getXMLHttpRequest();

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            callback(xhr.responseText);
        }
    };

    xhr.open("GET", "Ajax/ajaxSchedule.php?"+value, true);
    xhr.send(null);
}

/**
 * fonction qui callback qui recupere le string et l'envoi dans un elements du dom
 * @param String xhr 
 */
function check(xhr) {
   
    document.getElementById("testajax").innerHTML = xhr;
}



$(document).ready(function(){
//JsTree
 $(function () { $('#activity').jstree(); });
 $(function () { $('#local').jstree(); });
 $(function () { $('#test').jstree(); });

 $.jstree.defaults.core.themes.variant = "small";
});
//Tabs
  $( function() {
    $( "#tabs" ).tabs();
  } );
  //DatePicker
    $( function() {
    $( "#datepicker" ).datepicker();
  } );
//Accordion
  $( function() {
    $( "#accordion" ).accordion();
  } );
