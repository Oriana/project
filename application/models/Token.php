    <?php



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

       $ipusuario=str_replace(".","",$this->ip);
       $z=$r+$ipusuario+$this->getidUsuario();
       $v.=$r.'_'.$z.'_'.strtotime('now');
       $this->valor=$v;

    } //Actualizado

    public function ValidarToken($token){

       $valor=false;

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
       $ip=$random+str_replace(".","",$this->ip)+$idUsuario;
       $tiempo=$Valores[3];

       if (($Valores[2]==$ip) && ((strtotime('now')-$tiempo)<301) ){

           $valor=true;


       }

       return $valor;


    } // actualizado Probar

    public function ObtenerToken($nick,$ip){

           $this->setidUsuario($nick);
           $this->setValor();
           $this->ip=$ip;
           return $this->valor;

    } // Actualizado

    private  function setidUsuario($id){

        $this->idUsuario=$id;
    }

    private  function getidUsuario(){

        return  $this->idUsuario;
    }

    }



    ?>
