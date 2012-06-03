<?php
require_once 'Datos/ManejadorCassandra.php';
//require_once 'Persona.php';
require_once 'Datos/Cassandra/Cassandra.php';


echo "iniciando//";

function CrearSuperColumna($keyspace,$name,$columns){
      
    echo $keyspace." ";
    echo $name." ";
    echo $columns." ";
    echo " ntro //";
      $servers = array(
             array(
        
             'host' => '127.0.0.1',
             'port' => 9160,
             'use-framed-transport' => true,
             'send-timeout-ms' => 1000,
             'receive-timeout-ms' => 1000 ));   
     
    echo $servers;
    $cassandra = Cassandra::createInstance($servers);
    
    echo "aqui";
        
        $cassandra->createSuperColumnFamily($keyspace,
               $name,
               $columns, Cassandra::TYPE_UTF8,Cassandra::TYPE_UTF8, Cassandra::TYPE_UTF8,null, null, null,null, null, null,null,null,null,null,null,null);
      $this->Desconectar();
       return $resultado;
        $this->Cassandra=$cassandra;


//$this->Conectar();
     
   }


   
$mc= new ManejadorCassandra();
$x=$mc->Conectar();

CrearSuperColumna('2','ProbandoComentario',array('a'=>
    
            array(
   
            'name' => 'population',
	   'type' => Cassandra::TYPE_UTF8
		)
            
                )
    
        
    
   
       
       );
 

   
   

?>




