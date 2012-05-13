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
    
    function ModificarMegustaNoMeGusta($key,$determinante,$nick)
          
      {
        
            $a=new ManejadorCassandra();
            
            
        
            $contGusta=ConsultarMeGusta($key);
            $contNoGusta=ConsultarNOMeGusta($key);
           
             $contGusta=$contGusta+1;
             $contNoGusta=$contNoGusta+1;
            
             if($determinante == 1)
                $x=$a->Insertar('comentario',$key,array ('megusta'=>$contGusta));
            else
                $x=$a->Insertar('comentario',$key,array ('nomegusta'=>$conNotGusta));
            
            return $x;
    
      }
    
    
    function ConsultarMeGusta($idcomentario)
    {
        
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
    //$z=['key']['MeGusta'];
    $z=$x->getAll();
    if ($z[$nick]['megusta']!=null){
        
    return $megusta; 
    }
    
    }
    
    
    
    function ConsultarNOMeGusta($idcomentario)
    {
        
    $a=new ManejadorCassandra();

    
    $x=$a->ConsultaPorParametro('comentario',array('idcomentario'=>$idcomentario));
    $z=$x->getAll();
    if ($z[$nick]['nomegusta']!=null){
        
        return $nomegusta;
        
    };
   
    return $nomegusta; 
    
    }
    
    
}

?>
