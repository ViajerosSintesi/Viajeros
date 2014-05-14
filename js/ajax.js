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