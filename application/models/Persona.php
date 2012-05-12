<?php
require_once 'Datos/ManejadorCassandra.php';

class Persona {
    //put your code here
    
    function ConsultarUsuarioPorNick($nick)
    {
        
    $a=new ManejadorCassandra();
    
    $x=$a->ConsultaPorParametro('usuario',array('nick'=>$nick));
    $z=$x->getAll();
    return $z;
        
        
        
    }
    
    
     function InsertarUsuario($biografia,$email,$fechaNaciomiento,$foto,$nick,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido)
    {
        
        
        if ($this->ConsultarUsuarioPorNick($nick)==NULL){
         
         $a=new ManejadorCassandra();
    
         $x=$a->Insertar('comentario',$nick,array ('biografia'=>$biografia, 
                                                   'email'=>$email,
                                                   'fechaNacimiento'=>$fechaNaciomiento,
                                                   'foto'=>$foto,
                                                   'nick'=>$nick,
                                                   'primerNombre'=>$primerNombre,
                                                   'segundoNombre'=>$segundoNombre,
                                                   'primerApellido'=>$primerApellido,
                                                   'segundoApellido'=>$segundoApellido,
                                                    ));
         return $x; 
        }
        
        return 'Este nick ya existe elija otro';
   
    }
    
     function EliminarUsuario($nick)
    {
        
    $a=new ManejadorCassandra();
    
    $x=$a->Eliminar('usuario.'.$nick);
      
    }
    
    
      function ModificarUsuario($nick,$biografia,$email,$fechaNaciomiento,$foto,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido)
    {
        
        
        if ($this->ConsultarUsuarioPorNick($nick)!=NULL){
         
         $a=new ManejadorCassandra();
    
         $x=$a->Modificar('comentario',$nick,array ('biografia'=>$biografia, 
                                                   'email'=>$email,
                                                   'fechaNacimiento'=>$fechaNaciomiento,
                                                   'foto'=>$foto,
                                                   'primerNombre'=>$primerNombre,
                                                   'segundoNombre'=>$segundoNombre,
                                                   'primerApellido'=>$primerApellido,
                                                   'segundoApellido'=>$segundoApellido,
                                                    ));
         return $x; 
        }
        
        return 'Este usuario no existe';
   
    }
    
}





?>
