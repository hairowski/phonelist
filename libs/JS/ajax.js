
//Creamos el objeto de AJAX
function ajaxFunction() {
	var xmlHttp;
	try {
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
		return xmlHttp;
	} 
	catch (e) {
		// Internet Explorer
		try {
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
			return xmlHttp;
		} 
		catch (e) {
			try {
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
				return xmlHttp;
			} 
			catch (e) {
				alert("Tu navegador no soporta AJAX!");
			return false;
			}
		}
	}
}

//Funci�n para mandar llamar nuestra p�gina de manera as�ncrona

function Refresh(_pagina,capa) {
	var ajax;
	ajax = ajaxFunction();
	ajax.open("POST", _pagina, true);
		
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.onreadystatechange = function(){
		if (ajax.readyState == 4){
			document.getElementById(capa).innerHTML = ajax.responseText;			
		}
	}
	ajax.send(null);
}

//Funci�n para cambiar el estado alternativamente 

function toggle(id){
    var capa = document.getElementById(id);
    if (capa.style.marginLeft == "0px"){
        capa.style.marginLeft = "-580px";
    } else {
        capa.style.marginLeft = "0px";
    }
}