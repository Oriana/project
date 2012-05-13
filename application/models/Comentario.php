<?php

require_once 'Datos/ManejadorCassandra.php';
require_once 'Tags.php';
require_once 'Token.php';
 

 
class Comentario {
    
    
    function ConsultarComentarioPorUsuario($usuario)
    {
        
    $a=new ManejadorCassandra();
  
    
    $x=$a->ConsultaPorParametro('comentario',array('nick'=>$usuario));
    $z=$x->getAll();
    return $z;
        
           
    }
    
   
    
    
     function ConsultarComentarioPorId($idcomentario)
    {
        
    $a=new ManejadorCassandra();
 
    
    $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
    $z=$x->getAll();
    return $z;
    }
    
        
     function ConsultarComentarioPorFecha($fecha)
    {
        
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('fechapublicacion'=>$fecha));
    $z=$x->getAll();
    return $z; 
    
    
    }
    
     function EliminarComentario($token,$id){
    
    $t=new Token();
    if ($t->ValidarToken($token)==TRUE){
        
    $a=new ManejadorCassandra();
    
    $x=$a->Eliminar('comentario.'.$id);
     
    }
    
    return 'El token se vencio';
    
    
        
    }
        
    
    function InsertarComentario($token,$idcomentario,$idcomentarioraiz,$adjunto,$descripcion,$fechapublicacion,$megusta,$nomegusta,$nick,$tag)
    {
    $t=new Token();
    if ($t->ValidarToken($token)=='true'){
    $t=new Tags();
    if ($t->ConsultarTagsPorNombre($tag)!=NULL){
    $a=new ManejadorCassandra();
    
    $x=$a->Insertar('comentario',$idcomentario,array ('idcomentario'=>$idcomentario,
                                             'idcomentarioraiz'=>$idcomentarioraiz,
                                             'adjunto'=>$adjunto, 
                                             'descripcion'=>$descripcion,
                                             'fechapublicacion'=>$fechapublicacion,
                                             'megusta'=>$megusta,
                                             'nomegusta'=>$nomegusta,
                                             'nick'=>$nick,
                                             'tag'=>$tag,
       
        ));
    return $x; 
    }
    return 'El tag no existe';
    }
    return 'El token se vencio';
    }
    

    
    
    
}

?>
