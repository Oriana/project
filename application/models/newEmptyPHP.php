<?php
require_once 'Peticion.php';
require_once 'Xml.php';


$ip='192.168.174.1:8081'; //Variable que guarda la ip
$RutaServicio="http://".$ip."/ServidorRest/application/Servicio/"; //Variable que concatena la ruta con la ip


//******************************Consumo de Iniciar Sesion***************************************//

$url=$RutaServicio.'Usuario.php?method=IniciarSesion&data=';

$data[0]='Nick';
$data[1]='Clave';
$data2[0]='karlucha2';
$data2[1]='30';
$data3=Xml::ArregloXml($data, $data2,'Usuarios','Usuario');

$P= new RestRequest($url.$data3,'GET');


$P->execute();

echo 'Prueba Iniciar sesion ->'.print_r($P->getResponseBody(), true).'<br/>' ;

//*********************************************************************************************//




//************************Consumo Del Servicio Pedir Token*********************************//

$url=$RutaServicio.'Usuario.php?method=PedirToken&nick=';



$valor='karla';



$P= new RestRequest($url.$valor,'GET');

$P->execute();

echo 'Prueba Pedir Token ->'.print_r($P->getResponseBody(), true).'<br/>' ;






//******************************************************************************************//



//************************Consumo Del Servicio Consultar Usuario Por Nick**********************//

$url=$RutaServicio.'Usuario.php?method=ConsultarUsuarioPorNick&data=';


$data[0]='Nick';
$data2[0]='karla';
$data3=Xml::ArregloXml($data, $data2,'Usuarios','Usuario');

$P= new RestRequest($url.$data3,'GET');

$P->execute();

echo 'Prueba ConsultarUusario Por nick ->'.print_r($P->getResponseBody(), true).'<br/><br/><br/>' ;

//********************************************************************************************//



//************************Consumo Del Servicio Registrar Usuario*****************************//

$url=$RutaServicio.'Usuario.php?method=Registrarse&data=';

$etiqueta[0]='Nick';
$etiqueta[1]='Clave';
$etiqueta[2]='PrimerNombre';
$etiqueta[3]='SegundoNombre';
$etiqueta[4]='PrimerApellido';
$etiqueta[5]='SegundoApellido';
$etiqueta[6]='Biografia';
$etiqueta[7]='Email';
$etiqueta[8]='FechaNacimiento';
$etiqueta[9]='Foto';


$valores[0]="karlucha2";
$valores[1]='30';
$valores[2]='30';
$valores[3]='foto';
$valores[4]='1';
$valores[5]='ssd';
$valores[6]='1';
$valores[7]='1';
$valores[8]='antonio';
$valores[9]='jordi';
$datos=Xml::ArregloXml($etiqueta, $valores,'Usuarios','Usuario');
$P= new RestRequest($url.$datos,'GET');

$P->execute();

echo 'Prueba Registrar Usuario ->'.print_r($P->getResponseBody(), true).'<br/>' ;

//******************************************************************************************//


//************************Consumo Del Servicio Modificar Usuario*****************************//

$url=$RutaServicio.'Usuario.php?method=ModificarUsuario&token=_5427_5427_1338649389&data=';

$etiqueta[0]='Nick';
$etiqueta[1]='Clave';
$etiqueta[2]='PrimerNombre';
$etiqueta[3]='SegundoNombre';
$etiqueta[4]='PrimerApellido';
$etiqueta[5]='SegundoApellido';
$etiqueta[6]='Biografia';
$etiqueta[7]='Email';
$etiqueta[8]='FechaNacimiento';
$etiqueta[9]='Foto';


$valores[0]="karlucha2";
$valores[1]='30';
$valores[2]='Karla';
$valores[3]='Mariasasasasasaasasasasass';
$valores[4]='1';
$valores[5]='ssd';
$valores[6]='1';
$valores[7]='1';
$valores[8]='antonio';
$valores[9]='jordi';
$datos=Xml::ArregloXml($etiqueta, $valores,'Usuarios','Usuario');
$P= new RestRequest($url.$datos,'GET');

$P->execute();

echo 'Prueba Editar Usuario ->'.print_r($P->getResponseBody(), true).'<br/>' ;

//******************************************************************************************//

//******************************Consumo de Insertar Comentario***************************************//


$url=$RutaServicio.'Comentario.php?method=InsertarComentario&token=_5427_5427_1338649389&data=';

$etiqueta[0]='adjunto';
$etiqueta[1]='admiteRespuesta';
$etiqueta[2]='cantidadDeRespuestas';
$etiqueta[3]='descripcion';
$etiqueta[5]='idComentario';
$etiqueta[6]='meGusta';
$etiqueta[7]='nick';
$etiqueta[8]='noMeGusta';
$etiqueta[9]='personaNoGusta';
$etiqueta[10]='personaGusta';
$etiqueta[11]='idRaiz';

$valores[0]='video';
$valores[1]='2';
$valores[2]='null';
$valores[3]='noQuieroQNadieMeRespondaSoyAsocial';
$valores[5]='6';
$valores[6]='1';
$valores[7]='karuncha';
$valores[8]='1';
$valores[9]='jordi';
$valores[10]='karla';
$valores[11]='6';

$datos=Xml::ArregloXml($etiqueta, $valores,'Comentarios','Comentario');
$P= new RestRequest($url.$datos,'GET');

$P->execute();

echo 'Prueba Insertar Comentario->'.print_r($P->getResponseBody(), true).'<br/>' ;

//******************************************************************************************//


//******************************Consumo de Eliminar Persona***************************************//


$url=$RutaServicio.'Usuario.php?method=EliminarUsuario&token=_5427_5427_1338649389&data=';

$etiqueta[0]='Key';

$valores[0]='antonio';


$datos=Xml::ArregloXml($etiqueta, $valores,'EliminarUsuarios','EliminarUsuario');
$P= new RestRequest($url.$datos,'GET');

$P->execute();

echo 'Prueba Eliminar Usuario->'.print_r($P->getResponseBody(), true).'<br/>' ;

//******************************************************************************************//


//******************************Consumo de ver Comentarios por usuario***************************************//


$url=$RutaServicio.'Comentario.php?method=ConsultarComentarioPorUsuario&data=';

$etiqueta[0]='Nick';

$valores[0]='karuncha';


$datos=Xml::ArregloXml($etiqueta, $valores,'Comentarios','Comentario');
$P= new RestRequest($url.$datos,'GET');

$P->execute();

echo 'Prueba Comentario por Uusario->'.print_r($P->getResponseBody(), true).'<br/>' ;

//******************************************************************************************//



















//************************Consumo Del Servicio Cerrar Sesion*****************************//

$url=$RutaServicio.'Usuario.php?method=CerrarSesion';


$P= new RestRequest($url,'GET');


$P->execute();

echo 'Prueba Cerrar sesion ->'.print_r($P->getResponseBody(), true).'<br/>' ;

//*********************************************************************//



























?>

