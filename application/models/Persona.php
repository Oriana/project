<?php

error_reporting( E_ERROR);

require_once 'Datos/ManejadorCassandra.php';
require_once 'Xml.php';
require_once 'Token.php';
require_once 'Comentario.php';


class Persona {
   
     private $ip;  //variable que contiene la ip
     private $token; //variable que contiene el token
     private $nick; // variable que contiene el nick
     
     
     //Inicio de la Funcion Persona que recibe la ip de donde se esta conectando la persona
     //Actualizado
     public function Persona (){ 

        $this->ip=$this->getIP();
     } 
     //Fin de la funcion Persona
    
     
 //********* Metodos Probados por el cliente ********* //
 
 
     // Inicio de la Funcion IniciarSesion
     //Probado y listo.
     public function IniciarSesion($data){
        
        if (!$this->SesionIniciada()){ //Verificamos que el usuario no este logueado ya.
            
            $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data; 
            $xml = simplexml_load_string($data);
            
            if (!is_object($xml)){
                throw new Exception('Error en la lectura del XML',1001);

            }
            
            (string) $nick =(string) $xml->Usuario->Nick;
            (string) $clave = (string)$xml->Usuario->Clave;
          
            $ConexionCassandra=new ManejadorCassandra(); //Conexion con la base de datos cassandra
            $BuscaUsuario=$ConexionCassandra->ConsultaPorParametro('usuario',array('nick'=>$nick)); // Busca en la table usuario el nick 
            $VerificaEnBD=$BuscaUsuario->getAll();
            
            if (($VerificaEnBD[$nick]['clave']==$clave)&&($nick!="") &&($clave!="")){ // Verifica en la base de datos que la clave sea igual a la que esta almacenada
               $GuardarIp=$this->ObtenerIp();
               $ConexionCassandra->Insertar('sesion',$GuardarIp,array('ip'=> $GuardarIp,'nick'=>$nick)); //Almasena en la tabla sesion la ip y el nik del usuario
               $this->nick=$nick;
               return 'UsuarioLogeado';
               
            }
           
            else{
              
               return 'Usuario o Clave incorrecta'; // Si algunos de los campos (usuario o clave) son incorrectas, muestra mensaje de error
               
            }
               
        }
       
        else{
         return 'El usuario ya inicio sesion';
         
       }
     
      
     } 
    // Fin de la Funcion iniciar sesion

    
       //Probado y listo.
     public function CerrarSesion(){
        $a=new ManejadorCassandra();
        $x=$a->Eliminar('sesion.'.$this-> ObtenerIp());
        return "La sesion ha sido cerrada";
} 


     // Inicio de la SesionIniciada que verifica si el usuario ya ha iniciado sesion
     //Probado y listo
     public function SesionIniciada()
{
        
        $ConexionCassandra=new ManejadorCassandra();//Conexion con la base de datos 
        $ObtenerIp=$ConexionCassandra->ConsultaPorParametro('sesion',array('ip'=>$this->ObtenerIp())); //Busco en la tabla sesion si se encuentra la ip
        $VerificarIp=$ObtenerIp->getAll();
        
        if($VerificarIp!=NULL){
            
            return true; //Retorna true si se encontra el usuario
        }
        else{
            
            return false; //Retorna false si no se encuentra el usuario
        }
        
     }  
     // Fin de la Funcion SesionIniciada
     
     
     
      // Inicio de la Funcion ConsultarUsuarioPorNick que busca un determinado usuario en la base de datos
      //Probado y listo
     public function ConsultarUsuarioPorNick($data)
     {
      
            $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data; 
            $xml = simplexml_load_string($data);
            
            if (!is_object($xml)){
                throw new Exception('Error en la lectura del XML',1001);

            }
        
           (string) $nick =(string) $xml->Usuario->Nick;
        
           
            if ($this->SesionIniciada()){ // Verifico que el usuario este logeado
                
            $ConexionCassandra=new ManejadorCassandra(); //Conexion con la base de datos cassandra
            $BuscaUsuario=$ConexionCassandra->ConsultaPorParametro('usuario',array('nick'=>$nick)); // Busca en la table usuario el nick 
            $VerificaEnBD=$BuscaUsuario->getAll();
             if($VerificaEnBD[$nick]!=NULL){
             
                 return $VerificaEnBD;
             }
             else{
                 
                 return "El usuario que esta consultando no existe";
             }
             
          }
        
          else{

           return 'El usuario no ha iniciado sesion'; //Error si el usuario no ha iniciado sesion
         }
        
   }
       
     // Fin de la Funcion ConsultarUsuarioPorNick
     
    
   
    //Probado y listo
     public function ValidarNick($nick){
     
     $ConexionCassandra=new ManejadorCassandra(); //Conexion con la base de datos cassandra
     $BuscaUsuario=$ConexionCassandra->ConsultaPorParametro('usuario',array('nick'=>$nick)); // Busca en la table usuario el nick 
     $VerificaEnBD=$BuscaUsuario->getAll();
     if($VerificaEnBD[$nick]==NULL){
         return true;
     }
     return false;
     
 }
       
    //Probado y listo
    public function Registrarse($data)
    {
      
            $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data; 
            $xml = simplexml_load_string($data);
            
            if (!is_object($xml)){
                throw new Exception('Error en la lectura del XML',1001);

            }

            
            
            (string) $nick =(string) $xml->Usuario->Nick;
            (string) $clave = (string)$xml->Usuario->Clave;
            (string) $primerNombre = (string)$xml->Usuario->PrimerNombre;
            (string) $segundoNombre = (string)$xml->Usuario->SegundoNombre;
            (string) $primerApellido = (string)$xml->Usuario->PrimerApellido;
            (string) $segundoApellido = (string)$xml->Usuario->SegundoApellido;
            (string) $biografia = (string)$xml->Usuario->Biografia;
            (string) $email = (string)$xml->Usuario->Email;
            (string) $fechaNacimiento = (string)$xml->Usuario->FechaNacimiento;
            (string) $foto = (string)$xml->Usuario->Foto;
           
        
         if ($this->ValidarNick($nick)==true){
         
             $a=new ManejadorCassandra();

             $x=$a->Insertar('usuario',$nick,array ('biografia'=>$biografia, 
                                                       'email'=>$email,
                                                       'fechaNacimiento'=>$fechaNacimiento,
                                                       'foto'=>$foto,
                                                       'nick'=>$nick,
                                                       'primerNombre'=>$primerNombre,
                                                       'segundoNombre'=>$segundoNombre,
                                                       'primerApellido'=>$primerApellido,
                                                       'segundoApellido'=>$segundoApellido,
                                                       'clave'=>$clave
                                                        ));
                return "usuario registrado"; 
        }
        
        return 'Este nick ya existe elija otro';
        
         
    
       
   
    } // 
     
     
     
      //Inicio de la funcion PedirToken
      //Probado y listo
     public function PedirToken($nick){
         
        if ($this->SesionIniciada()){ //Verificamos que el usuario este logueado ya.        
             $PeticionToken= new Token();
             if (isset($this->token)){ // si el usuario ya tiene asignado un token

                 if(!$PeticionToken->ValidarToken($this->token)){ // Si el token se vencio

                     $this->token= $PeticionToken->ObtenerToken($this->nick,$this->getIP); // Se asigna un nuevo token
                 }
             }
             else{

                  $this->token= $PeticionToken->ObtenerToken($this->nick,$this->getIP);// Se le asigna un token por primera vez
             }

             return $this->GetToken();
             
       }
       else{
           
           return 'No se le puede asignar un token porque no ha iniciado sesion.';
       }
  }       
 //Fin de la funcion PedirToken 
 //Inicio de la funcion ObtenerIp que obtiene la IP
     // Probado y Listo 
     public function ObtenerIp()
     { 

        return str_replace(".","",$this->getIP()); //Funcion que quita los puntos de la IP

     }
     //Fin de la funcion ObtenerIp
     
  
     //Funcion que obtiene la ip del usuario y la guarda con punto
     // Probado y Listo 
     private function getIP(){
        
        if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ){  
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        
        else{
            
            if( isset($_SERVER ['HTTP_VIA']) ){
                $ip = $_SERVER['HTTP_VIA'];
            }
            else{
                
                if( isset( $_SERVER ['REMOTE_ADDR'] )){
                    $ip = $_SERVER['REMOTE_ADDR'];
                }
                else{
                    $ip = null ;
                }
            }
        
        }
        
       
        return $ip; //retorna la IP
     } 
    
     // Fin de la funcion getIP
     
     //Inicio de la funcion GetToken que me retorna el token
     public function GetToken($data){  
    
        return $this->token;
      
     }
     
     //Fin de la funcion GetToken 

//********* Metodos Probados por el cliente ********* //
     
     
    
  
    
     
     //Probado y listo
    public function ModificarUsuario($token,$data)
    {
        $T=new Token();
        if ($this->SesionIniciada() ){
            
            if (!$T->ValidarToken($token)){
                
                
                $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data; 
                $xml = simplexml_load_string($data);
                
                if (!is_object($xml)){
                    
                    throw new Exception('Error en la lectura del XML',1001);

                }

            
            
                (string) $nick =(string) $xml->Usuario->Nick;
                (string) $clave = (string)$xml->Usuario->Clave;
                (string) $primerNombre = (string)$xml->Usuario->PrimerNombre;
                (string) $segundoNombre = (string)$xml->Usuario->SegundoNombre;
                (string) $primerApellido = (string)$xml->Usuario->PrimerApellido;
                (string) $segundoApellido = (string)$xml->Usuario->SegundoApellido;
                (string) $biografia = (string)$xml->Usuario->Biografia;
                (string) $email = (string)$xml->Usuario->Email;
                (string) $fechaNacimiento = (string)$xml->Usuario->FechaNacimiento;
                (string) $foto = (string)$xml->Usuario->Foto;
           
        
                 if (!$this->ValidarNick($nick)==true){

                     $a=new ManejadorCassandra();

                     $x=$a->Modificar('usuario',$nick,array (  'biografia'=>$biografia, 
                                                               'email'=>$email,
                                                               'fechaNacimiento'=>$fechaNacimiento,
                                                               'foto'=>$foto,
                                                               'nick'=>$nick,
                                                               'primerNombre'=>$primerNombre,
                                                               'segundoNombre'=>$segundoNombre,
                                                               'primerApellido'=>$primerApellido,
                                                               'segundoApellido'=>$segundoApellido,
                                                               'clave'=>$clave,
                                                                ));
                        return "usuario modificado"; 
                }

                return 'Este nick ya existe elija otro';
        }    
                

        else{

            return 'El token esta vencido';

        }
            
            
            
    }
 }   
    

    
    
   function EliminarUsuario($token,$data)
    {
    $T=new Token();
        if ($this->SesionIniciada() ){
            
            if (!$T->ValidarToken($token)){
                
                
                $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data; 
                $xml = simplexml_load_string($data);
                
                if (!is_object($xml)){
                    
                    throw new Exception('Error en la lectura del XML',1001);

                }

               (string)$Key =(string)$xml->EliminarUsuario->Key;
               
        
                 if (!$this->ValidarNick($Key)==true){
                        
                     $a=new ManejadorCassandra();
                       
                     $x=$a->Eliminar('usuario.'.$Key);
                     
                     //$b=new Comentario();
                    // $y=$b->ConsultarComentarioPorUsuario($nick);
                     
                   //  $m=$a->Eliminar('comentario.'.$y);
                        return "usuario eliminado"; 
                }

                return 'El usuario que desea eliminar no existe';
        }    
                

        else{

            return 'El token esta vencido';

        }
            
            
            
    }
 }   
    
    
    
  
    

    
}






?>
