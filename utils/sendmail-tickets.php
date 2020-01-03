<?php

require_once '../initializer.php';
require('../pdf/code39.php');

$Id = $_POST['IdAcquisto'];
$biglietti = $dbh->getCartToPrint($Id);
$userInfo = $dbh->getUserByCart($Id);

$pdf = new PDF_Code39();
// Column headings
$header = array('Nome', 'Cognome', 'Data Nascita', 'Titolo', 'DataInizio', 'Barcode');

$filename="../doc/biglietti.pdf";
// Data loading

var_dump($biglietti);

$pdf->SetFont('Arial','',14);

foreach( $biglietti as $biglietto){
    $pdf->AddPage();
    $pdf->Code39(80,40,$biglietto,2,20);
}

$pdf->Output($filename, 'F');

$message = "<b>- Email inviata automaticamente. Non rispondere -</b>
            <br>
            <br>".date("Y/m/d, H:i:s")."
            <br>
            <br>Gentile ".$userInfo[0]["Nome"] ." ".$userInfo[0]["Cognome"].",
            <br>
            <br>Le confermiamo l'acquisto presso il sito TicketTwo, In allegato puo trovare i biglietti. 
            <br>Scaricali e stampali per mostrarli all'ingresso. Altrimenti mostrali con il tuo telefono.";


$subject = 'Acquisto Biglietti - Prenotazione Eventi TicketTwo';

        // To send HTML mail, the Content-type header must be set
$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=UTF-8';





//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../phpmail/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'mail.agriturismomarcheok.it';

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = true;

$mail->CharSet = 'UTF-8';

$mail->AddAttachment('../doc/biglietti.pdf', $name = 'biglietti.pdf',  $encoding = 'base64', $type = 'application/pdf');

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "eventi@agriturismomarcheok.it";

//Password to use for SMTP authentication
$mail->Password = ";Ttbuq2VR&wR"; //passsssssssssssssssssss?????

//Set who the message is to be sent from
$mail->setFrom('eventi@agriturismomarcheok.it', 'TicketTwo');
$mail->AddReplyTo("no-reply@agriturismomarcheok.it","No Reply");

//Set who the message is to be sent to
$mail->addAddress($userInfo[0]["Mail"], $userInfo[0]["Nome"]." ".$userInfo[0]["Cognome"]);

$mail->IsHTML(true);
//Set the subject line
$mail->Subject = $subject;

$mail->Body = $message;

//TO DO
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->send();

?>

