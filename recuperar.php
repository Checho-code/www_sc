<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require('conexion/conexion.php');


//Load Composer's autoloader
require 'phpMailer/Exception.php';
require 'phpMailer/PHPMailer.php';
require 'phpMailer/SMTP.php';

//Busco el registro  del usuario 
if (!empty($_POST["enviar"])) {

    if (!empty($_POST['correo'])) {

        $datos = '';
        $correo =$_POST['correo'];

        $buscar_usuario = mysqli_query($conexion, "SELECT nombre_usuario,(aes_decrypt(clave,'AES'))AS recup FROM usuarios WHERE email ='$correo'");
        $row_usuario = mysqli_fetch_assoc($buscar_usuario);
        $password = $row_usuario['recup'];
        $nom=$row_usuario['nombre_usuario'];

        if ($row_usuario >= 1) {
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'juanda7426@gmail.com';
                $mail->Password = 'evcpwtjhttysoppt';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                //Recipients
                $mail->setFrom('juanda7426@gmail.com', 'Sol Comercial');
                $mail->addAddress("$correo");

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Recuperacion de clave';
                $mail->Body = 'Hola que tal Señor(a) <b>'. $nom . '</b>, esta es su contraseña <b>' . $password . '</b>, por favor guardala en un lugar seguro, recuerda que <b>Solcomercial</b> esta para servirte ';

?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Muy bien',
                        text: 'Correo enviado, revisa tu correo!',
                        confirmButtonColor: '#177c03',

                    })
                </script>
            <?php
                $mail->send();
                header('Location:login.php');
            } catch (Exception $e) {
                echo " Error: {$mail->ErrorInfo}";
            }
        } else { ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Correo no encontrado',
                    confirmButtonColor: '#177c03',

                })
            </script>
        <?php

        }
    } else { ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Campo vacio, por favor verifica!',
                confirmButtonColor: '#177c03',

            })
        </script>
<?php


    }
}
