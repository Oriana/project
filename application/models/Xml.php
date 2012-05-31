<?php


   class Xml {
    
    
    public static function StringaXml($string){
        
       return  new SimpleXMLElement($string);
    }
    
    
    public static function ArregloXml($nombres,$valores,$Padre,$Hijo){

$xml='';
$xml.='<'.$Padre.'>';
$xml.='<'.$Hijo.'>';
for ($i=0;$i<sizeof($nombres);$i++){

$xml.='<'.$nombres[$i].'>'.$valores[$i].'</'.$nombres[$i].'>';
}
$xml.='</'.$Hijo.'>';
$xml.='</'.$Padre.'>';
return $xml;
}



 




}

?>
