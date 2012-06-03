<?php

require_once 'Peticion.php';
require_once 'Xml.php';


$ip='190.75.110.60:8081'; //Variable que guarda la ip
$RutaServicio="http://".$ip."/ServidorRest/application/Servicio/"; //Variable que concatena la ruta con la ip

//******************************Consumo de Insertar Comentario***************************************//


$url=$RutaServicio.'Comentario.php?method=InsertarComentario&token=_5427_5427_1338649389&data=';

$etiqueta[0]='adjunto';
$etiqueta[1]='admiteRespuesta';
$etiqueta[2]='cantidadDeRespuestas';
$etiqueta[3]='descripcion';
$etiqueta[4]='fechaPublicacion';
$etiqueta[5]='idComentario';
$etiqueta[6]='meGusta';
$etiqueta[7]='nick';
$etiqueta[8]='noMeGusta';
$etiqueta[9]='personaNoGusta';
$etiqueta[10]='personaGusta';
$etiqueta[11]='idRaiz';

$valores[0]="video";
$valores[1]='1';
$valores[2]='2';
$valores[3]='primer comentario probando';
$valores[4]='02/06/2012';
$valores[5]='2';
$valores[6]='1';
$valores[7]='jordi';
$valores[8]='1';
$valores[9]='antonio';
$valores[10]='karla';
$etiqueta[11]='4';
$datos=Xml::ArregloXml($etiqueta, $valores,'Usuarios','Usuario');
$P= new RestRequest($url.$datos,'GET');

$P->execute();

echo 'Prueba Insertar Comentario->'.print_r($P->getResponseBody(), true).'<br/>' ;

//******************************************************************************************//















?>
