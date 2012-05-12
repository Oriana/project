<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ManejadorCassandra
 *
 * @author karla
 */

// show all the errors
error_reporting(E_ALL);

// the only file that needs including into your project
require_once 'Cassandra/Cassandra.php';

class ManejadorCassandra {
    
       private $Cassandra;
    function Conectar (){

        $servers = array(
             array(
        
             'host' => '127.0.0.1',
             'port' => 9160,
             'use-framed-transport' => true,
             'send-timeout-ms' => 1000,
             'receive-timeout-ms' => 1000 ));

        $cassandra = Cassandra::createInstance($servers);
        
        $cassandra->useKeyspace('RedSocial');
        $this->Cassandra=$cassandra;
        
    }
    
    
    function ConsultaPorParametro($cf,$query){
        
       $this->Conectar();
       $resultado = $this->Cassandra->cf ($cf)->getWhere($query);
       $this->Desconectar(); 
        return $resultado;
        
       
        
    }
    
     function Eliminar($query){
        
       $this->Conectar(); 
       $resultado = $this->Cassandra->remove($query);
       $this->Desconectar();
        return $resultado;
    
}

      function Insertar($cf,$key,$query){
        
       $this->Conectar();
       $resultado = $this->Cassandra->cf ($cf)->set($key,$query,Cassandra::CONSISTENCY_QUORUM);
       $this->Desconectar();
        return $resultado;
          
    }
    
    function Modificar($cf,$key,$query){
        
       $this->Conectar(); 
       $resultado = $this->Cassandra->cf ($cf)->set($key,$query,Cassandra::CONSISTENCY_QUORUM);
       $this->Desconectar();
        return $resultado;
    }
    
    
    function Desconectar(){

    $this->Cassandra->closeConnections();

}

    
}
?>
