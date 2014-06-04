var conexion;
function conectar(){ 
	if (window. XMLHttpRequest){ 
		conexion=new XMLHttpRequest(); 
	} 
	else { 
		conexion= new ActiveXObject("Microsoft.XMLHttp"); 
	} 
} 
function actualizaPerfil(){
	conectar();
	conexion.open("GET", "mod-datos.html",true); 
	conexion.send(); 
	conexion.onreadystatechange=listo;
}
function registro(){
	conectar();
	conexion.open("GET", "registro.php",true); 
	conexion.send(); 
	conexion.onreadystatechange=cargarRegistro;
}

function listo(){ 
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("perfil-right").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("perfil-right").innerHTML="Error: El archivo no existe"; 
	} 	
}
function cargarRegistro(){ 
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("home-right").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("home-right").innerHTML="Error: El archivo no existe"; 
	} 	
}
function infoPais(pais){
	conectar();
	conexion.open("GET", "pais-info.php?pais="+pais, true);
	conexion.send();
	conexion.onreadystatechange=cargarInfoPais;
}
function cargarInfoPais(){
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("contenido").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("contenido").innerHTML="Error: El archivo no existe"; 
	}
}
function fotoPais(){
	conectar();
	conexion.open("GET", "pais-foto.php", true);
	conexion.send();
	conexion.onreadystatechange=cargarInfoPais;
}
function cargarFotoPais(){
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("contenido").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("contenido").innerHTML="Error: El archivo no existe"; 
	}
}
function ciudadesPais(pais){
	conectar();
	conexion.open("GET", "php/pais/pais-ciudades.php?pais="+pais, true);
	conexion.send();
	conexion.onreadystatechange=cargarCiudadesPais;
}
function cargarCiudadesPais(){
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("contenido").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("contenido").innerHTML="Error: El archivo no existe"; 
	}
}
/* ====== ciudad ======= */
function infoCiudad(){
	conectar();
	conexion.open("GET", "ciudad-info.php", true);
	conexion.send();
	conexion.onreadystatechange=cargarInfoPais;
}
function cargarInfoCiudad(){
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("contenido").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("contenido").innerHTML="Error: El archivo no existe"; 
	}
}
function fotoCiudad(){
	conectar();
	conexion.open("GET", "ciudad-foto.php", true);
	conexion.send();
	conexion.onreadystatechange=cargarInfoPais;
}
function cargarFotoCiudad(){
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("contenido").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("contenido").innerHTML="Error: El archivo no existe"; 
	}
}

function editInfoPais(pais){
	conectar();
	conexion.open("GET", "pais-edit-info.php?pais="+pais, true);
	conexion.send();
	conexion.onreadystatechange=cargaEditInfoPais;
}
function cargaEditInfoPais(){
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("info").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("info").innerHTML="Error: El archivo no existe"; 
	}
}
function editInfoCiudad(ciudad){
	conectar();
	conexion.open("GET", "ciudad-edit-info.php?ciudad="+ciudad, true);
	conexion.send();
	conexion.onreadystatechange=cargaEditInfoCiudad;
}
function cargaEditInfoCiudad(){
	if (conexion.readyState==4 && conexion.status==200) { 
		document.getElementById("info").innerHTML=conexion.responseText; 
	}
	if (conexion.readyState==4 && conexion.status==404) { 
		document.getElementById("info").innerHTML="Error: El archivo no existe"; 
	}
}