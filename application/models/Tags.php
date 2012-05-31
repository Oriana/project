<?php
require_once 'Datos/ManejadorCassandra.php';

class Tags {
   function ConsultarTagsPorNombre($nombre)
    {
      if (isset($_SESSION['Usuario'])){   
        $a=new ManejadorCassandra();

        $x=$a->ConsultaPorParametro('tags',array('nombre'=>$nombre));
        $z=$x->getAll();
        return $z;
      }
      else{
          return 'El usuario no ha iniciado sesion';
      }
    }
    
    
    
     function InsertarTags($token,$nombre)
   {
       $t=new Token();
       if ($t->ValidarToken($token)==TRUE){ 
       if ($this->ConsultarTagsPorNombre($nombre)!=NULL){
        
        $a=new ManejadorCassandra();
   
        $x=$a->Insertar ('tags',$nombre,array ('nombre'=>$nombre));
        return $x; 
       }
      
           
       return 'Este tag ya existe elija otro';
  
   }
   else{
       return'El token se vencio';
   }
   }
    //OJO CON MODIFICAR //
   
     function ModificarTags($token,$nombre,$nombreNuevo)
   {
       $t=new Token();
       if ($t->ValidarToken($token)==TRUE){ 
       if ($this->ConsultarTagsPorNombre($nombre)!=NULL){
        
        $a=new ManejadorCassandra();
   
        $x=$a->Modificar('tags',$nombre,array ('nombre'=>$nombreNuevo ));
        return $x; 
       }
      
           
       return 'Este tag no existe';
  
   }
   
   else{
       return 'El token se vencio';
   }
   }  
    
    function EliminarTags($token,$nombre)
    {
    $t=new Token();
    if ($t->ValidarToken($token)==TRUE){ 
    $a=new ManejadorCassandra();
    
    $x=$a->Eliminar('tags.'.$nombre);
    return $x;
      }
      else{
    
    return 'El token se vencio';
      }
    }
     
 
}

?>
