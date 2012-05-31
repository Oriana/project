<?php
error_reporting( E_ERROR);

require_once 'Datos/ManejadorCassandra.php';
require_once 'Xml.php';
 session_start();




class Persona {
    //put your code here
     private $ip; 
    
    function Persona (){

$this->ip=$this->getIP();
}

    
   public function SesionIniciada(){
        
       
        $a=new ManejadorCassandra();

        $x=$a->ConsultaPorParametro('sesion',array('ip'=>$this->ip));
        $z=$x->getAll();
        if($z!=NULL){
            
            return true;
        }
        else{
            
            return false;
        }
        
    }


  
    
    function ConsultarUsuarioPorNick($data)
    {
      
        $xml = simplexml_load_string($data);
        
        foreach ($xml->Usuario as $Usuario)
        {
            $nick=(string) $Usuario->Nick;
        
        }
        
        
        
        if (isset($_SESSION['Usuario'])){ 
        $a=new ManejadorCassandra();

        $x=$a->ConsultaPorParametro('usuario',array('nick'=>$nick));
        $z=$x->getAll();
        return $z;
      }
      else{
          return $_SESSION['Usuario']."pupu";
          return 'El usuario no ha iniciado sesion';
      }
        
        
        
    }
    
     public function ObtenerIp(){

return str_replace(".","",$this->getIP());

}

    
    
    // Metodo Iniciar Sesion //
   public function IniciarSesion($data){
        
       echo !$this->SesionIniciada();
       if (!$this->SesionIniciada()){ // Verificamos que el usuario no este logeado ya.
      
            $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data;
            $xml = simplexml_load_string($data);
            if (!is_object($xml)){
            throw new Exception('Error en la lectura del XML',1001);
                return $data;
            }

            foreach ($xml->Usuario as $Usuario)
            {
                $nick=(string)$Usuario->Nick;
                $clave=(string) $Usuario->Clave[0];

            }
           $a=new ManejadorCassandra();
          
           $x=$a->ConsultaPorParametro('usuario',array('nick'=>$nick)); // Buscamos al usuario en la BD
           $z=$x->getAll();
           if ($z[$nick]['clave']==$clave){ // Si lo encontramos y la clave es correcta, damos inicio a la sesion.
               $w=$this->ObtenerIp();
               $a->Insertar('sesion',$w,array('ip'=> $w,'nick'=>$nick));
               return 'Usuario Logeado';
               
           }
           else{
               
               return 'Usuario o Clave incorrecta'; // Si no devolvemos el mensaje de error.
           }
               
               
       }
       
       else{
         
           return 'El usuario ya inicio sesion';
           
       }
    }
  // Metodo Iniciar Sesion //

    
     private function getIP(){
        
        if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) )
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        
        else
        {
            if( isset($_SERVER ['HTTP_VIA']) )  
            {
                $ip = $_SERVER['HTTP_VIA'];
            }
            else 
            {
                if( isset( $_SERVER ['REMOTE_ADDR'] ))  
                {
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                else
                {
                    $ip = null ;
                }
            }
        
        }
        
       
        return $ip;
    }
    
    
    
     function InsertarUsuario($token,$biografia,$email,$fechaNaciomiento,$foto,$nick,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido,$clave)
    {
        
        $t=new Token();
        if ($t->ValidarToken($token)==TRUE){
        if ($this->ConsultarUsuarioPorNick($nick)!=NULL){
         
         $a=new ManejadorCassandra();
    
         $x=$a->Insertar('usuario',$nick,array ('biografia'=>$biografia, 
                                                   'email'=>$email,
                                                   'fechaNacimiento'=>$fechaNaciomiento,
                                                   'foto'=>$foto,
                                                   'nick'=>$nick,
                                                   'primerNombre'=>$primerNombre,
                                                   'segundoNombre'=>$segundoNombre,
                                                   'primerApellido'=>$primerApellido,
                                                   'segundoApellido'=>$segundoApellido,
                                                   'clave'=>$clave,
                                                    ));
        return $x; 
        }
        
        return 'Este nick ya existe elija otro';
        
         }
    
        return 'El token se vencio';
   
    }
    
     function EliminarUsuario($token,$nick)
    {
    $t=new Token();
    if ($t->ValidarToken($token)==TRUE){ 
    $a=new ManejadorCassandra();
    
    $x=$a->Eliminar('usuario.'.$nick);
    return $x;
      }
      else{
    
    return 'El token se vencio';
      }
    }
    
    
      function ModificarUsuario($token,$nick,$biografia,$email,$fechaNaciomiento,$foto,$primerNombre,$segundoNombre,$primerApellido,$segundoApellido,$clave)
    {
        $t=new Token();
    if ($t->ValidarToken($token)==TRUE){
        
        if ($this->ConsultarUsuarioPorNick($nick)!=NULL){
         
         $a=new ManejadorCassandra();
    
         $x=$a->Modificar('usuario',$nick,array ('biografia'=>$biografia, 
                                                   'email'=>$email,
                                                   'fechaNacimiento'=>$fechaNaciomiento,
                                                   'foto'=>$foto,
                                                   'primerNombre'=>$primerNombre,
                                                   'segundoNombre'=>$segundoNombre,
                                                   'primerApellido'=>$primerApellido,
                                                   'segundoApellido'=>$segundoApellido,
                                                   'clave'=>$clave,
                                                    ));
         return $x; 
        }
      
        
        return 'Este usuario no existe';
         }
    
    return 'El token se vencio';
   
    }
    
     public function CerrarSesion(){
$a=new ManejadorCassandra();
$x=$a->Eliminar('sesion.'.$this-> ObtenerIp());
return "La sesion ha sido cerrada";
}

    
   


    
    
    
    
}

//$data[0]='Nick';
//$data2[0]='Pedrito';
//$data3=Xml::ArregloXml($data, $data2,'Usuarios','Usuario');

//$a = new Persona();
//echo $a->IniciarSesion($data);

//echo $_SESSION['Usuario'];





?>
