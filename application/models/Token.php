<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Token
 *
 * @author Aka-Anto
 */
class Token {
    //put your code here
    
    private $idUsuario;
    private $valor;
    private $ip;
    
   public  function Token(){
        
       
    }
    
    
   private function setValor(){
        $v=$this->getidUsuario()."_";
        $i=0;
        $r='';
        while ($i<4){
            
            $r.=rand(1, 8);
            $i++;
        }
        
       $ipusuario=str_replace(".","",$this->getIP());
       $z=$r+$ipusuario+$this->getidUsuario();
       $v.=$r.'_'.$z.'_'.strtotime('now');
       $this->valor=$v;
        
    }
    
    
    
   private  function setidUsuario($id){
        
        $this->idUsuario=$id;
    }
    
    private  function getidUsuario(){
        
        return  $this->idUsuario;
    }
    
    
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
    
    
   public function ValidarToken($token){
       
       $x=strtok($token);
       $i=0;
       $tok = strtok($token, "_");
       $Valores='';
        while ($tok !== false) {
            $Valores[$i]=$tok;
            $i++;
            $tok = strtok("_");
        }
        
       $idUsuario=$Valores[0];
       $random=$Valores[1];
       $ip=$random+str_replace(".","",$this->getIP())+$idUsuario;
       $tiempo=$Valores[3];
      
       if (($Valores[2]==$ip) && ((strtotime('now')-$tiempo)<301) ){
           return 'true';
       }
       
       
       return 'false';
       
   }
    
   public function ObtenerToken($id){
       
       $this->setidUsuario($id);
       $this->setValor();
       $this->ip=$this->getIP();
       return $this->valor;
   }
    
}

$t=new Token();
$x=$t->ObtenerToken('anto');
echo $x."<br/>";
echo $t->ValidarToken('anto_3232_130233_1336846988');

?>
