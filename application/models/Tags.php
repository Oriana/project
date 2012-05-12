<?php
require_once 'Datos/ManejadorCassandra.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tags
 *
 * @author karla
 */
class Tags {
   function ConsultarTagsPorNombre($nombre)
    {
        
    $a=new ManejadorCassandra();
    $a->Conectar();
    
    $x=$a->ConsultaPorParametro('tags',array('nombre'=>$nombre));
    $z=$x->getAll();
    return $z;
        
    }
    
    
    
     function InsertarTags($nombreTags)
   {
       
       
       if ($this->ConsultarTagsPorNombre($nombreTags)==NULL){
        
        $a=new ManejadorCassandra();
   
        $x=$a->Insertar ('tags',$nombreTags,array ('nombre'=>$nombreTags ));
        return $x; 
       }
      
           
       return 'Este tag ya existe elija otro';
  
   }
    
    //OJO CON MODIFICAR //
   
     function ModificarTags($nombreTags,$nombreNuevo)
   {
       
       
       if ($this->ConsultarTagsPorNombre($nombreTags)!=NULL){
        
        $a=new ManejadorCassandra();
   
        $x=$a->Modificar('tags',$nombreTags,array ('nombre'=>$nombreNuevo ));
        return $x; 
       }
      
           
       return 'Este tag no existe';
  
   }
    
    
    
     
 
}

?>
