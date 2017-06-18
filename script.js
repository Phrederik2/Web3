/**
 * retourne l'object XMLHttpRequest si il est instanciable
 */
function getXMLHttpRequest() {
  var xhr = null;

  if (window.XMLHttpRequest || window.ActiveXObject) {
    if (window.ActiveXObject) {
      try {
        xhr = new ActiveXObject("Msxml2.XMLHTTP");
      } catch (e) {
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
function request(callback, value) {

  var xhr = getXMLHttpRequest();

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
      callback(xhr.responseText);
    }
  };

  xhr.open("POST", "index.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("ajax=true&" + value);
}

/**
 * fonction qui callback qui recupere le string et l'envoi dans un elements du dom
 * @param String xhr 
 */
function check(xhr) {
  document.getElementById("ScheduleTab").innerHTML = xhr;
}



$(document).ready(function () {
  //JsTree
  $(function () { $('#activity').jstree(); });
  $(function () { $('#local').jstree(); });
  $(function () { $('#test').jstree(); });

  $.jstree.defaults.core.themes.variant = "small";
});
//Tabs
$(function () {
  $("#tabs").tabs();
});
//DatePicker
$(function () {
  $("#datepicker").datepicker();
});
//Accordion
$(function () {
  $("#accordion").accordion();
});

$("#datepicker").datepicker({
   onSelect: function(dateText, inst) { 
      var date = $(this).datepicker( 'getDate' ); //the getDate method
      
      if(date == null){
        return;
      }
      else{
        var selDate = date.valueOf();
        request(check,"timestamp="+selDate);

      }

   }
});


