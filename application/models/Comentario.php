<?php

require_once 'Datos/ManejadorCassandra.php';
require_once 'Persona.php';
require_once 'Xml.php';
require_once 'Token.php';
 
class Comentario {
    
    
     public  function ConsultarComentarioPorUsuario($data) // Actualizado
    {
         echo"//entro a comentario//";
       
    
        $M=new Persona();
        if ($M->SesionIniciada() ){
            
             
                
                   
                $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data; 
                $xml = simplexml_load_string($data);
     
                
                if (!is_object($xml)){
                    
                    throw new Exception('Error en la lectura del XML',1001);

                }

                  
                    (string)$nick=(string)$xml->Comentario->Nick;
                  

                   $a=new ManejadorCassandra();
                   echo"entro a la "; 
                   
                    $x=$a->ConsultaPorParametro('comentario',array('nick2'=>$nick));
                    $z=$x->getAll();
                    return $z;
                        
                    
             
             
             
            
             
     
    
    
        }    
     else {
        return 'no inicio sesion';
    }    
        

    
    }
    
    
   
    
    
      public  function ConsultarComentarioPorId($idcomentario) // Actualizado
    {
     
      $P= new Persona();
      if ($P->SesionIniciada()){  
        
          $a=new ManejadorCassandra();
 
    
          $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
          $z=$x->getAll();
          return $z;
      }
      
      else{
            return 'El usuario no ha iniciado sesion';
        }
    }
        
       public function ConsultarComentarioPorFecha($fecha) // Actualizado
    {
    
        $P= new Persona();
        
        
        if ($P->SesionIniciada()){ 
            $a=new ManejadorCassandra();

    
            $x=$a->ConsultaPorParametro('comentario',array('fechapublicacion'=>$fecha));
            $z=$x->getAll();
            return $z; 
        }
        else{
            return 'El usuario no ha iniciado sesion';
        }
    
   }
   
   
   
    
     public function ConsultarComentarioPorTags($nombre) // Actualizado
    {
    
        $P= new Persona();
        
        
        if ($P->SesionIniciada()){  
            $a=new ManejadorCassandra();


            $x=$a->ConsultaPorParametro('comentario',array('nombre'=>$nombre));
            $z=$x->getAll();
            return $z;

        }
        else {
            return 'El usuario no ha iniciado sesion';
        }
    } //Actualizado
    
    public function EliminarComentario($token,$id,$nick){ // Actualizado
    
        $t=new Token();
        if ($t->ValidarToken($token)==TRUE){

            $a=new ManejadorCassandra();
            
            $z=$this->ConsultarComentarioPorId($id);
            
            if  ($z[$id]['nick']==$nick){

                $x=$a->Eliminar('comentario.'.$id);
            }
            else{
            
                return 'Este usuario no es el autor del comentario, no lo puede eliminar.';
            
            }
     
        }
    
        else{
            
                return 'El token se vencio';
            
        }
       
    }
    
    
    
    
    function ConsultarAdmiteRespuesta($idComentario)
    {
   
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
    $z=$x->getAll();
    
   
    
    
    
    
    return $z[$idComentario]['AdmiteRespuesta'];
    
    
    
    
    } 
    
    
     
    
    
    
    function ConsultarPersonaAquienRespoden($key)
    {
    
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('key'=>$key));
    $w=$x->getAll();
  
    
     $l=$w[$key]['nick'];
     $this->ConsultarEmail($l);
    
     
 
    // $this->ConsultarEmail($j);
  
    
    }
     
    
    
    function ConsultarEmail($nick)
    {
    
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('usuario',array('nick'=>$nick));
    $w=$x->getAll();
  
    
     $l=$w[$nick]['email'];
     
    $correo= new EnvioDeCorreo($email);

    //$this->ConsultarEmail($l);
    
     
 
    // $this->ConsultarEmail($j);
  
    
    }
    
    
    
    
    function InsertarComentario($token,$data)
    { 
        
       $M=new Persona();
        if ($M->SesionIniciada() ){
            
             $T=new Token();
            if (!$T->ValidarToken($token)){
                
                   
                $data='<?xml version="1.0" encoding="UTF-8" ?>'.$data; 
                $xml = simplexml_load_string($data);
     
                
                if (!is_object($xml)){
                    
                    throw new Exception('Error en la lectura del XML',1001);

                }

                    //(string) $token=(string)$Comentario->token;
                    (string) $idComentario=(string)$xml->Comentario->idComentario;
                    (string) $adjunto=(string)$xml->Comentario->adjunto;
                    (string) $admiteRespuesta=(string)$xml->Comentario->admiteRespuesta;
                    (string) $descripcion=(string)$xml->Comentario->descripcion;
                    (string) $meGusta=(string)$xml->Comentario->meGusta;
                    (string) $noMeGusta=(string)$xml->Comentario->noMeGusta;
                    (string) $personaGusta=(string)$xml->Comentario->personaGusta;
                    (string) $personaNoGusta=(string)$xml->Comentario->personaNoGusta;
                    (string) $nick=(string)$xml->Comentario->nick;
                   // (string) $admiteRespuesta=(string)$xml->admiteRespuesta->admiteRespuesta;
                    (string) $idRaiz=(string) $xml->Comentario->idRaiz;
                    (string) $cantidadDeRespuestas=(string)$xml->Comentario->cantidadDeRespuestas;
                    (string) $tags=(string)$xml->Comentario->tags;
                

                   $a=new ManejadorCassandra();
                   echo"entro a la "; 
                   
                     

                    //echo $token . "<br>";
                                
            
                    
                                   
                     $fechaPublicacion=date('j').'/'.date('n').'/'.date('Y');
                     $comentarioLimpioHtml= strip_tags($descripcion);
                     preg_match_all('/#[a-z0-9]#+/i',$descripcion, $matches);

                         foreach($matches as $match) {

                                foreach($match as $nombreTags) {

                                $z=$nombreTags; 
                                echo $z;
                                }
                         }
                        $this->InsertarTags($token,$nombreTags);

                  
                     
                    
                     
                   
                     
                        
                     $x=$a->Insertar('comentario',$idComentario,array ('idComentario'=>$idComentario, 
                                                               'adjunto'=>$adjunto,
                                                               'admiteRespuesta'=>$admiteRespuesta,
                                                               'descripcion'=>$descripcion,
                                                               'meGusta'=>$meGusta,
                                                               'noMeGusta'=>$noMeGusta,
                                                               'personaGusta'=>$personaGusta,
                                                               'personaNoGusta'=>$personaNoGusta,
                                                               'nick'=>$nick,
                                                              // 'admiteRespuesta'=>$admiteRespuesta,
                                                               'idRaiz'=>$idRaiz,
                                                               'cantidadDeRespuestas'=>$cantidadDeRespuestas,
                                                               'tags'=>$tags,
                                                                'fechaPublicacion'=>$fechaPublicacion
                                                                ));
                        return "comentario insertado"; 
             
             
             
             
            
             
            }
    
    else {
        return 'El token se vencio';
    }
    
    
        }    
     else {
        return 'no inicio sesion';
    }    
        
}

    
    
    
    
    function ResponderComentario($token,$data)
    { 
        
       $M=new Persona();
        if ($M->SesionIniciada() ){
            
             $T=new Token();
            if (!$T->ValidarToken($token)){
                
                   
                   $a=new ManejadorCassandra();
                   echo"entro a la "; 
                   
                     

                    //echo $token . "<br>";
                      $z=$this->ConsultarAdmiteRespuesta($idComentario);   
                      
                      
                      if ($z==1){
                        
                      $this->InsertarComentario($token, $data);    
                      $this-> ConsultarPersonaAquienRespoden($idRaiz);
                        
                        return "comentario insertado"; 
             
             
             
            } 
            
            else{
             echo "el usuario no permite respuestas";  
            }
            
             
            }
    
    else {
        return 'El token se vencio';
    }
    
    
        }    
     else {
        return 'no inicio sesion';
    }    
        
    
    
    
    
    }
    
     function InsertarTags($token,$nombre)
   {
       $t=new Token();
       if ($t->ValidarToken($token)==TRUE){ 
      
        
        $a=new ManejadorCassandra();
   
        $x=$a->Insertar ('tags',$nombre,array ('nombre'=>$nombre));
        return $x; 
       
      
           
       
  
   }
   else{
       return'El token se vencio';
   }
   }
    
    
    function ModificarMegustaNoMeGusta($key,$determinante,$nick)
          
      {
        if (isset($_SESSION['Usuario'])){ 
            $a=new ManejadorCassandra();
            
            
        
            $contGusta=$this->ConsultarMeGusta($key);
            $contNoGusta=$this->ConsultarNOMeGusta($key);
           
             $contGusta=$contGusta+1;
             $contNoGusta=$contNoGusta+1;
              if($determinante == 1)
                  
                  
                $x=$a->Insertar('comentario',$key,array ('megusta'=>$contGusta));
            else
                $x=$a->Insertar('comentario',$key,array ('nomegusta'=>$contNoGusta));
            
            return $x;
            
        }
        else{
            return 'El usuario no ha iniciado sesion';
        }
    
      }
    
    
    function ConsultarMeGusta($idcomentario)
    {
     if (isset($_SESSION['Usuario'])){   
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
    
    $z=$x->getAll();
   
        
        return $z[$idcomentario]['megusta'];
     }
     else{
         return 'El usuario no ha iniciado sesion';
     }
    
    }
    
    
    
    function ConsultarNOMeGusta($idcomentario)
    {
     if (isset($_SESSION['Usuario'])){  
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
    $z=$x->getAll();
   
    return $z[$idcomentario]['nomegusta']; 
    
    }
    else{
        return 'El usuario no ha iniciado sesion';
    }
    } 
    
    
    
    function ConsultarPersonaGusta($nick,$key,$determinante)
    {
      
     // if (isset($_SESSION['Usuario'])){   
        $a=new ManejadorCassandra();

        $x=$a->ConsultaPorParametro('comentario',array('personaGusta'=>$nick));
        $z=$x->getAll();
        //return $z;
        
            if ($z== null)
                
            {
                $x=$a->ConsultaPorParametro('comentario',array('personaNoGusta'=>$nick));
                $z=$x->getAll();
                
                
                 if ($z== null) 
                 {
                     $t=new Token();
                     if ($t->ValidarToken($token)!=TRUE)
                     {  
                     $a=new ManejadorCassandra();
                     $x=$a->Insertar('comentario',$key,array ('personaGusta'=>$nick));
                     //$this->ModificarMegustaNoMeGusta($idComentario,$determinante,$nick);
            
                     }
                         
                      else
                      
                          
                      {
                          echo "token se vencio";
                      }
            
                 }
                 
                 else
                     
                 {
                     echo "ya voto";
                     
                 }
            }
            
            else
                
            {
                
                echo "ya voto";
            }
                
                
           // }
                
            
          
                 
                  
               
            
      
      
     // else{
       //   return 'El usuario no ha iniciado sesion';
     // }
    
}
    
}
   
?>
