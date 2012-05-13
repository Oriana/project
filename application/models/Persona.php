<?php
require_once 'Datos/ManejadorCassandra.php';
session_start();




class Persona {
    //put your code here
    
    
    
    
     public function IniciarSesion($nick,$clave){
        
        $a=new ManejadorCassandra();
        
        $x=$a->ConsultaPorParametro('usuario',array('nick'=>$nick));
        
        $z=$x->getAll();
        if ($z[$nick]['clave']==$clave){
            
            $_SESSION['Usuario'] =$nick; 
            return true;
            
        }
        else{
          
            return false;
            
        }
     }
    
    function ConsultarUsuarioPorNick($nick)
    {
        
    $a=new ManejadorCassandra();
    
    $x=$a->ConsultaPorParametro('usuario',array('nick'=>$nick));
    $z=$x->getAll();
    return $z;
        
        
        
    }
    
    
     function InsertarUsuario($biografia,$email,$fechaNaciomiento,$foto,$nick,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido)
    {
        
         $t=new Token();
        if ($t->ValidarToken($token)==TRUE){
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
    
        return 'El token se vencio';
   
    }
    
     function EliminarUsuario($nick)
    {
        $t=new Token();
    if ($t->ValidarToken($token)==TRUE){ 
    $a=new ManejadorCassandra();
    
    $x=$a->Eliminar('usuario.'.$nick);
    
      }
    
    return 'El token se vencio';
      
    }
    
    
      function ModificarUsuario($nick,$biografia,$email,$fechaNaciomiento,$foto,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido)
    {
        $t=new Token();
    if ($t->ValidarToken($token)==TRUE){
        
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
    
    return 'El token se vencio';
   
    }
    
}





?>
