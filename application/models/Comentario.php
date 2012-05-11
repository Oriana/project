<?php

require_once 'Datos/ManejadorCassandra.php';
 

 
class Comentario {
    function ConsultarComentarioPorUsuario($usuario)
    {
        
    $a=new ManejadorCassandra();
    $a->Conectar();
    
    $x=$a->ConsultaPorParametro('comentario',array('nick'=>$usuario));
    $z=$x->getAll();
    return $z;
        
        
        
    }
    
     function ConsultarComentarioPorTags($tag)
    {
        
    $a=new ManejadorCassandra();
    $a->Conectar();
    
    $x=$a->ConsultaPorParametro('comentario',array('tags'=>$tag));
    $z=$x->getAll();
    return $z;
    }
        
     function ConsultarComentarioPorFecha($fecha)
    {
        
    $a=new ManejadorCassandra();
    $a->Conectar();
    
    $x=$a->ConsultaPorParametro('comentario',array('fechapublicacion'=>$fecha));
    $z=$x->getAll();
    return $z; 
    
    
    }
    
     function EliminarComentarioPorNick($nick)
    {
        
    $a=new ManejadorCassandra();
    $a->Conectar();
    
    $x=$a->Eliminar('comentario.'.$nick);
     
    
    
    }
    
}

?>
