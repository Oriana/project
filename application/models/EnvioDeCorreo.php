<?php

require ('class.phpmailer.php');

function mandarEmail($email) {

$mail = new PHPMailer ();

$mail -> From = "karlarodriguez16@gmail.com";

$mail -> FromName = "karla rodriguez";

$mail -> AddAddress   ($email);

$mail -> Subject = "Usted ha resivido una respuesta";

$mail -> Body = "<h3>Hola:
                     Te han respondido una publicacion
                     Para mas informacion te invitamos a que ingreses en nuestra Red Social
                     Gracias
                     El equipo de Red Social</h3>";

$mail -> IsHTML (true);



$mail->IsSMTP();

$mail->Host = 'ssl://smtp.gmail.com';

$mail->Port = 465;

$mail->SMTPAuth = true;

$mail->Username = 'karlarodriguez16@gmail.com';

$mail->Password = 'sfsyk12201';
echo "probando";


if(!$mail->Send()) {

        echo 'Error: ' . $mail->ErrorInfo;

}

else {

      echo 'Mail enviado!';

}

}

?>