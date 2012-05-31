<?php

require_once 'Datos/ManejadorCassandra.php';

 

 
class Comentario {
    
    
    function ConsultarComentarioPorUsuario($usuario)
    {
    
    if (isset($_SESSION['Usuario'])){ 
    $a=new ManejadorCassandra();
  
    
    $x=$a->ConsultaPorParametro('comentario',array('nick'=>$usuario));
    $z=$x->getAll();
    return $z;
              
    }
    else {
        return 'El usuario no ha iniciado sesion';
    }
    }
    
   
    
    
     function ConsultarComentarioPorId($idcomentario)
    {
     
    if (isset($_SESSION['Usuario'])){ 
    $a=new ManejadorCassandra();
 
    
    $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
    $z=$x->getAll();
    return $z;
    }
    else{
        return 'El usuario no ha iniciado sesion';
    }
    }
    
        
     function ConsultarComentarioPorFecha($fecha)
    {
    
    if (isset($_SESSION['Usuario'])){ 
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('fechapublicacion'=>$fecha));
    $z=$x->getAll();
    return $z; 
    }
    else{
        return 'El usuario no ha iniciado sesion';
    }
    
   }
   
   
   
    
    function ConsultarComentarioPorTags($nombre)
    {
    
    if (isset($_SESSION['Usuario'])){ 
    $a=new ManejadorCassandra();
  
    
    $x=$a->ConsultaPorParametro('comentario',array('nombre'=>$nombre));
    $z=$x->getAll();
    return $z;
              
    }
    else {
        return 'El usuario no ha iniciado sesion';
    }
    }
    
     function EliminarComentario($token,$id){
    
    $t=new Token();
    if ($t->ValidarToken($token)==TRUE){
        
    $a=new ManejadorCassandra();
    
    $x=$a->Eliminar('comentario.'.$id);
     
    }
    
    else{
    return 'El token se vencio';
    }
       
    }
        
    
    function InsertarComentario($token,$idcomentario,$idcomentarioraiz,$adjunto,$descripcion,$megusta,$nomegusta,$nick)
    {
    $t=new Token();
    if ($t->ValidarToken($token)!='true'){
    //$t=new Tags();
   // if ($t->ConsultarTagsPorNombre($tag)!=NULL){
    $a=new ManejadorCassandra();
    $fechapublicacion=date('j').'/'.date('n').'/'.date('Y');
    $comentarioLimpioHtml= strip_tags($descripcion);
    $x=$a->Insertar('comentario',$idcomentario,array ('idcomentario'=>$idcomentario,
                                             'idcomentarioraiz'=>$idcomentarioraiz,
                                             'adjunto'=>$adjunto, 
                                             'descripcion'=>$descripcion,
                                             'fechapublicacion'=>$fechapublicacion,
                                             'megusta'=>$megusta,
                                             'nomegusta'=>$nomegusta,
                                             'nick'=>$nick,
                                             //'tag'=>$tag,
       
        
        
        ));
    
  
    
    preg_match_all('/#[a-z0-9]+#/i',$descripcion, $matches);

        foreach($matches as $match) {
    
        foreach($match as $nombreTags) {
          
            $z=$nombreTags; 
            
         InsertarTags($token,$nombreTags);
           
          
        //echo $token . "<br>";
   }
}
    return $x; 
    //}
    return 'El tag no existe';
    }
    return 'El token se vencio';
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
