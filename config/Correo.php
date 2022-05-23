<?php
include ("phpmailer.php");

class Correo
{

    private $contrasena;

    private $correoAdministrador;

    private $correoBea;

    public function __construct()
    {
        $this->contrasena = "Merendalia19";
        $this->correoAdministrador = "info@merendalia.es";
        $this->correoBea = "blozares@gmail.com";
    }

    /**
     * enviarMailsReserva
     * Envía el mail de reserva
     *
     * @param  $mail
     * @param  $nombre
     * @param  $dia
     * @param  $hora_entrada
     * @param  $hora_salida
     * @param  $telefono
     * @param  $comentario
     */
    public function enviarMailsReserva($mail, $nombre, $dia, $hora_entrada, $hora_salida, $telefono, $comentario, $whatsapp)
    {
        $imagen = 'https://preview.ibb.co/bMeFeK/merendalia_logotipo_RGB_01.png';
        
        $smtp = new PHPMailer();
        
        // Indicamos que vamos a utilizar un servidor SMTP
        $smtp->IsSMTP();
        
        // Definimos el formato del correo con UTF-8
        $smtp->CharSet = "UTF-8";
        
        // autenticación contra nuestro servidor smtp
        $smtp->SMTPAuth = true;
        $smtp->SMTPSecure = "ssl";
        $smtp->Host = "smtp.buzondecorreo.com";
        $smtp->Username = $this->correoAdministrador;
        $smtp->Password = $this->contrasena;
        $smtp->Port = 465;
        
        // datos de quien realiza el envio
        $smtp->From = "info@merendalia.es"; // from mail
        $smtp->FromName = "Administrador de Merendalia"; // from mail name
                                                         
        // Indicamos las direcciones donde enviar el mensaje con el formato
                                                         // "correo"=>"nombre usuario"
                                                         // Se pueden poner tantos correos como se deseen
        $mailTo = array(
            $mail => $nombre
        );
        
        // establecemos un limite de caracteres de anchura
        $smtp->WordWrap = 50; // set word wrap
                              
        // NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
                              // cualquier programa de correo pueda leerlo.
                              
        // Definimos el contenido HTML del correo
        $contenidoHTML = "<head>";
        $contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
        $contenidoHTML .= "</head><body>";
        $contenidoHTML .= "<h1 style='color: #d8c12d'>¡Hola " . $nombre . "!</h1>";
        $contenidoHTML .= "<p>En merendalia hemos recibido tu solicitud, vamos a revisar lo que nos pides, ver si es posible, y nos pondremos en contacto contigo a la mayor brevedad posible.
											</br>Un saludo y ¡¡gracias por contactar con nosotros!!</p>
                                                                                        </br><strong>Teléfono de contacto:</strong> 983 85 73 69
											</br>
											</br><a href='https://www.merendalia.es'><img src='" . $imagen . "' height='50'/></a>
											</br><p style='font-size: 10px;'><strong>AVISO SEGURIDAD</strong>
											</br><strong>MERENDALIA C.B</strong> le informa que su dirección de correo electrónico, así como el resto de los datos de carácter personal de su tarjeta de visita que nos facilite, serán objeto de tratamiento automatizado en nuestros ficheros, con la finalidad de gestionar la agenda de contactos de nuestra empresa, para el envío de comunicaciones profesionales y/o personales por vía electrónica. Vd. podrá en cualquier momento ejercer el derecho de acceso, rectificación, cancelación y oposición en los términos establecidos en la Ley Orgánica 15/1999. El responsable del tratamiento es  <strong>MERENDALIA C.B</strong> con domicilio en CALLE PARAÍSO 2, BAJO, 47003, VALLADOLID.
											</br>El contenido de esta comunicación, así como el de toda la documentación anexa, es confidencial y va dirigido únicamente al destinatario del mismo. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucción. Gracias.</p>";
        $contenidoHTML .= "</body>\n";
        
        // Definimos el contenido en formato Texto del correo
        // $contenidoTexto="Contenido en formato Texto";
        // $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";
        
        // Definimos el subject
        $smtp->Subject = "Merendalia";
        
        // Adjuntamos el archivo "leameLWP.txt" al correo.
        // Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
        // archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
        // script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
        // /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
        // /home/xve/test/leameLWP.txt
        $rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
        // $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");
        
        // Indicamos el contenido
        $smtp->MsgHTML($contenidoHTML); // Text body HTML
        
        foreach ($mailTo as $mail => $name) {
            $smtp->ClearAllRecipients();
            $smtp->AddAddress($mail, $name);
            
            // Envía el correo.
            if ($smtp->Send()) {
                $this->enviarCorreoInformativoReserva($mail, $nombre, $dia, $hora_entrada, $hora_salida, $telefono, $comentario, $whatsapp);
                $envio = "OK";
            } else {
                $envio = "KO";
            }
        }
        
        return $envio;
    }

    /**
     * enviarCorreoInformativoReserva
     * Envía el correo informando al administrador de la reserva
     *
     * @param  $mail
     * @param  $nombre
     * @param  $dia
     * @param  $hora_entrada
     * @param  $hora_salida
     * @param  $telefono
     * @param  $comentario
     */
    public function enviarCorreoInformativoReserva($mail, $nombre, $dia, $hora_entrada, $hora_salida, $telefono, $comentario, $whatsapp)
    {
        $imagen = 'https://preview.ibb.co/bMeFeK/merendalia_logotipo_RGB_01.png';
        
        $smtp = new PHPMailer();
        
        // Indicamos que vamos a utilizar un servidor SMTP
        $smtp->IsSMTP();
        
        // Definimos el formato del correo con UTF-8
        $smtp->CharSet = "UTF-8";
        
        // autenticación contra nuestro servidor smtp
        $smtp->SMTPAuth = true;
        $smtp->SMTPSecure = "ssl";
        $smtp->Host = "smtp.buzondecorreo.com";
        $smtp->Username = $this->correoAdministrador;
        $smtp->Password = $this->contrasena;
        $smtp->Port = 465;
        
        // datos de quien realiza el envio
        $smtp->From = "info@merendalia.es"; // from mail
        $smtp->FromName = "Administrador de Merendalia"; // from mail name
                                                         
        // Indicamos las direcciones donde enviar el mensaje con el formato
                                                         // "correo"=>"nombre usuario"
                                                         // Se pueden poner tantos correos como se deseen
        $mailTo = array(
            $this->correoAdministrador => "Administrador",
            $this->correoBea => "Beatriz"
        );
        
        // establecemos un limite de caracteres de anchura
        $smtp->WordWrap = 50; // set word wrap
                              
        // NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
                              // cualquier programa de correo pueda leerlo.
                              
        // Definimos el contenido HTML del correo
        $contenidoHTML = "<head>";
        $contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
        $contenidoHTML .= "</head><body>";
        $contenidoHTML .= "<h1 style='color: #d8c12d'>¡Hola Administrador!</h1>";
        $contenidoHTML .= "<p>" . $nombre . " ha realizado una reserva.</p>
                                            </br><p><strong>Dia: </strong>" . $dia . ".</p>
                                            </br><p><strong>Hora entrada: </strong>" . $hora_entrada . ".</p>
                                            </br><p><strong>Hora salida: </strong>" . $hora_salida . ".</p>";
        
        if ($comentario != null) {
            $contenidoHTML .= "</br><p><strong>Comentario: </strong>" . $comentario . ".</p>";
        }
        $contenidoHTML .= "</br><p>Comprueba que esté todo correcto y confirma su asistencia.</p>
											</br><p><strong>Mail: </strong>" . $mail . ".</p>";
        if ($telefono != null) {
            $contenidoHTML .= "</br><p><strong>Teléfono: </strong>" . $telefono . ".</p>";
        }
        
        if ($whatsapp == "OK") {
            $contenidoHTML .= "</br><p>" . $nombre . " acepta ser añadido a la <i>Lista de difusión por whatsapp.</i></p>";
        }
        
        $contenidoHTML .= "</br>
						  </br><p><a href='https://www.merendalia.es'><img src='" . $imagen . "' height='50'/></a></p>";
        
        $contenidoHTML .= "</body>\n";
        
        // Definimos el contenido en formato Texto del correo
        // $contenidoTexto="Contenido en formato Texto";
        // $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";
        
        // Definimos el subject
        $smtp->Subject = "Merendalia";
        
        // Adjuntamos el archivo "leameLWP.txt" al correo.
        // Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
        // archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
        // script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
        // /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
        // /home/xve/test/leameLWP.txt
        $rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
        // $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");
        
        // Indicamos el contenido
        $smtp->MsgHTML($contenidoHTML); // Text body HTML
        
        foreach ($mailTo as $mail => $name) {
            $smtp->ClearAllRecipients();
            $smtp->AddAddress($mail, $name);
            
            $smtp->Send(); // Envía el correo.
        }
    }

    /**
     * enviarMailsConsulta
     * Envía el mail de contacto
     * 
     * @param  $mail
     * @param  $nombre
     * @param  $telefono
     * @param  $consulta
     * @return string
     */
    public function enviarMailsConsulta($mail, $nombre, $telefono, $consulta, $whatsapp)
    {
        $imagen = 'https://preview.ibb.co/bMeFeK/merendalia_logotipo_RGB_01.png';
        
        $smtp = new PHPMailer();
        
        // Indicamos que vamos a utilizar un servidor SMTP
        $smtp->IsSMTP();
        
        // Definimos el formato del correo con UTF-8
        $smtp->CharSet = "UTF-8";
        
        // autenticación contra nuestro servidor smtp
        $smtp->SMTPAuth = true;
        $smtp->SMTPSecure = "ssl";
        $smtp->Host = "smtp.buzondecorreo.com";
        $smtp->Username = $this->correoAdministrador;
        $smtp->Password = $this->contrasena;
        $smtp->Port = 465;
        
        // datos de quien realiza el envio
        $smtp->From = "info@merendalia.es"; // from mail
        $smtp->FromName = "Administrador de Merendalia"; // from mail name
        
        // Indicamos las direcciones donde enviar el mensaje con el formato
        // "correo"=>"nombre usuario"
        // Se pueden poner tantos correos como se deseen
        $mailTo = array(
            $mail => $nombre
        );
        
        // establecemos un limite de caracteres de anchura
        $smtp->WordWrap = 50; // set word wrap
        
        // NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
        // cualquier programa de correo pueda leerlo.
        
        // Definimos el contenido HTML del correo
        $contenidoHTML = "<head>";
        $contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
        $contenidoHTML .= "</head><body>";
        $contenidoHTML .= "<h1 style='color: #d8c12d'>¡Hola " . $nombre . "!</h1>";
        $contenidoHTML .= "<p>En merendalia hemos recibido tu consulta, nos pondremos en contacto contigo a la mayor brevedad posible.
											</br>Un saludo y ¡¡gracias por contactar con nosotros!!</p>
                                                                                        </br><strong>Teléfono de contacto:</strong> 983 85 73 69
											</br>
											</br><a href='https://www.merendalia.es'><img src='" . $imagen . "' height='50'/></a>
											</br><p style='font-size: 10px;'><strong>AVISO SEGURIDAD</strong>
											</br><strong>MERENDALIA C.B</strong> le informa que su dirección de correo electrónico, así como el resto de los datos de carácter personal de su tarjeta de visita que nos facilite, serán objeto de tratamiento automatizado en nuestros ficheros, con la finalidad de gestionar la agenda de contactos de nuestra empresa, para el envío de comunicaciones profesionales y/o personales por vía electrónica. Vd. podrá en cualquier momento ejercer el derecho de acceso, rectificación, cancelación y oposición en los términos establecidos en la Ley Orgánica 15/1999. El responsable del tratamiento es  <strong>MERENDALIA C.B</strong> con domicilio en CALLE PARAÍSO 2, BAJO, 47003, VALLADOLID.
											</br>El contenido de esta comunicación, así como el de toda la documentación anexa, es confidencial y va dirigido únicamente al destinatario del mismo. En el supuesto de que usted no fuera el destinatario, le solicitamos que nos lo indique y no comunique su contenido a terceros, procediendo a su destrucción. Gracias.</p>";
        $contenidoHTML .= "</body>\n";
        
        // Definimos el contenido en formato Texto del correo
        // $contenidoTexto="Contenido en formato Texto";
        // $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";
        
        // Definimos el subject
        $smtp->Subject = "Merendalia";
        
        // Adjuntamos el archivo "leameLWP.txt" al correo.
        // Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
        // archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
        // script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
        // /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
        // /home/xve/test/leameLWP.txt
        $rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
        // $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");
        
        // Indicamos el contenido
        $smtp->MsgHTML($contenidoHTML); // Text body HTML
        
        foreach ($mailTo as $mail => $name) {
            $smtp->ClearAllRecipients();
            $smtp->AddAddress($mail, $name);
            
            // Envía el correo.
            if ($smtp->Send()) {
                $this->enviarCorreoInformativoConsulta($mail, $nombre, $telefono, $consulta, $whatsapp);
                $envio = "OK";
            } else {
                $envio = "KO";
            }
        }
        
        return $envio;
    }
    
    /**
     * enviarCorreoInformativoContacto
     * Envía el correo informando al administrador de la consulta
     * 
     * @param  $mail
     * @param  $nombre
     * @param  $telefono
     * @param  $consulta
     */
    public function enviarCorreoInformativoConsulta($mail, $nombre, $telefono, $consulta, $whatsapp)
    {
        $imagen = 'https://preview.ibb.co/bMeFeK/merendalia_logotipo_RGB_01.png';
        
        $smtp = new PHPMailer();
        
        // Indicamos que vamos a utilizar un servidor SMTP
        $smtp->IsSMTP();
        
        // Definimos el formato del correo con UTF-8
        $smtp->CharSet = "UTF-8";
        
        // autenticación contra nuestro servidor smtp
        $smtp->SMTPAuth = true;
        $smtp->SMTPSecure = "ssl";
        $smtp->Host = "smtp.buzondecorreo.com";
        $smtp->Username = $this->correoAdministrador;
        $smtp->Password = $this->contrasena;
        $smtp->Port = 465;
        
        // datos de quien realiza el envio
        $smtp->From = "info@merendalia.es"; // from mail
        $smtp->FromName = "Administrador de Merendalia"; // from mail name
        
        // Indicamos las direcciones donde enviar el mensaje con el formato
        // "correo"=>"nombre usuario"
        // Se pueden poner tantos correos como se deseen
        $mailTo = array(
            $this->correoAdministrador => "Administrador",
            $this->correoBea => "Beatriz"
        );
        
        // establecemos un limite de caracteres de anchura
        $smtp->WordWrap = 50; // set word wrap
        
        // NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
        // cualquier programa de correo pueda leerlo.
        
        // Definimos el contenido HTML del correo
        $contenidoHTML = "<head>";
        $contenidoHTML .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">";
        $contenidoHTML .= "</head><body>";
        $contenidoHTML .= "<h1 style='color: #d8c12d'>¡Hola Administrador!</h1>";
        $contenidoHTML .= "<p>" . $nombre . " ha realizado una consulta.</p>";
        
        if ($consulta != null) {
            $contenidoHTML .= "</br><p><strong>Consulta: </strong>" . $consulta . ".</p>";
        }
        
        $contenidoHTML .= "</br><p><strong>Mail: </strong>" . $mail . ".</p>";
        
        if ($telefono != null) {
            $contenidoHTML .= "</br><p><strong>Teléfono: </strong>" . $telefono . ".</p>";
        }
        
        if ($whatsapp == "OK") {
            $contenidoHTML .= "</br><p>" . $nombre . " acepta ser añadido a la <i>Lista de difusión por whatsapp.</i></p>";
        }
        
        $contenidoHTML .= "</br>
						  </br><p><a href='https://www.merendalia.es'><img src='" . $imagen . "' height='50'/></a></p>";
        
        $contenidoHTML .= "</body>\n";
        
        // Definimos el contenido en formato Texto del correo
        // $contenidoTexto="Contenido en formato Texto";
        // $contenidoTexto.="\n\nhttp://www.lawebdelprogramador.com";
        
        // Definimos el subject
        $smtp->Subject = "Merendalia";
        
        // Adjuntamos el archivo "leameLWP.txt" al correo.
        // Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
        // archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
        // script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
        // /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
        // /home/xve/test/leameLWP.txt
        $rutaAbsoluta = substr($_SERVER["SCRIPT_FILENAME"], 0, strrpos($_SERVER["SCRIPT_FILENAME"], "/"));
        // $smtp->AddAttachment($rutaAbsoluta."/leameLWP.txt", "LeameLWP.txt");
        
        // Indicamos el contenido
        $smtp->MsgHTML($contenidoHTML); // Text body HTML
        
        foreach ($mailTo as $mail => $name) {
            $smtp->ClearAllRecipients();
            $smtp->AddAddress($mail, $name);
            
            $smtp->Send(); // Envía el correo.
        }
    }

    /**
     * console_log
     * Sacamos por consola lo que le pasemos
     *
     * @param
     *            $data
     */
    function console_log($data)
    {
        echo '<script>';
        echo 'console.log(' . json_encode($data) . ')';
        echo '</script>';
    }
}