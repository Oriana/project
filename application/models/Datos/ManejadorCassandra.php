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
        
        
       $resultado = $this->Cassandra->cf ($cf)->getWhere($query);
       //echo print_r($karla, true); 
        return $resultado;
        
       
        
    }
    
     function Eliminar($query){
        
        
       $resultado = $this->Cassandra->remove($query);
       //echo print_r($karla, true); 
        return $resultado;
    
}
}
?>
