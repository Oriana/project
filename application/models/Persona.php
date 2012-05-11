<?php
require_once 'Datos/ManejadorCassandra.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editorjbhmnb.
 */

/**
 * Description of Persona
 *
 * @author karla
 */
class Persona {
    //put your code here
    
    function ConsultarUsuarioPorNombre($nombre)
    {
        
    $a=new ManejadorCassandra();
    $a->Conectar();
    
    $x=$a->ConsultaPorParametro('usuario',array('primerNombre'=>$nombre));
    $z=$x->getAll();
    return $z;
        
        
        
    }
    
    
}





?>
