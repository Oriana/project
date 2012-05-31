<?php
require_once 'Peticion.php';
require_once 'Xml.php';
$url='http://192.168.2.2:8081/ServidorRest/application/Servicio/Usuario.php?method=IniciarSesion&data=';

$data[0]='Nick';
$data[1]='Clave';
$data2[0]='Pedrito';
$data2[1]='123';
$data3=Xml::ArregloXml($data, $data2,'Usuarios','Usuario');

$P= new RestRequest($url.$data3,'GET');


$P->execute();

echo 'Prueba Iniciar sesion ->'.print_r($P->getResponseBody(), true).'<br/>' ;



$url='http://192.168.2.2/ServidorRest/application/Servicio/Usuario.php?method=ConsultarUsuarioPorNick&data=';


$data[0]='Nick';
$data2[0]='Pedrito';
$data3=Xml::ArregloXml($data, $data2,'Usuarios','Usuario');

$P= new RestRequest($url.$data3,'GET');

$P->execute();

echo 'Prueba ConsultarUusario Por nick ->'.print_r($P->getResponseBody(), true).'<br/>' ;

for ($i=0;$i<sizeof($data);$i++){

if ($data[$i]=='%'){

$data[$i]=' ';
}

}

?>
