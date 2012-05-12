<?php

require_once 'Datos/ManejadorCassandra.php';
require_once 'Tags.php';
 

 
class Comentario {
    function ConsultarComentarioPorUsuario($usuario)
    {
        
    $a=new ManejadorCassandra();
  
    
    $x=$a->ConsultaPorParametro('comentario',array('nick'=>$usuario));
    $z=$x->getAll();
    return $z;
        
        
        
    }
    
     function ConsultarComentarioPorTags($tag)
    {
        
    $a=new ManejadorCassandra();
 
    
    $x=$a->ConsultaPorParametro('comentario',array('tags'=>$tag));
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
    
     function EliminarComentario($id)
    {
        
    $a=new ManejadorCassandra();
    
    $x=$a->Eliminar('comentario.'.$id);
      
    }
    
        
    
    function InsertarComentario($key,$adjunto,$descripcion,$fechapublicacion,$megusta,$nomegusta,$nick,$tag)
    {
    
    $t=new Tags();
    if ($t->ConsultarTagsPorNombre($tag)!=NULL){
    $a=new ManejadorCassandra();
    
    $x=$a->Insertar('comentario',$key,array ('adjunto'=>$adjunto, 
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
    
    
     function ModificarComentario($key,$adjunto,$descripcion,$fechapublicacion,$megusta,$nomegusta)
    {
        
            $a=new ManejadorCassandra();
           
    
            $x=$a->Insertar('comentario',$key,array ('adjunto'=>$adjunto, 
                                                  'descripcion'=>$descripcion,
                                                  'fechapublicacion'=>$fechapublicacion,
                                                  'megusta'=>$megusta,
                                                  'nomegusta'=>$nomegusta,
                                               
  
                                                   ));
             return $x;
    }
    
}

?>
