<?php

require_once '../initializer.php';

if($_POST['mail'] == '') {
  echo json_encode(array('result' => 'warning', 'message' => 'Inserisci la mail'));
}else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
  echo json_encode(array('result' => 'warning', 'message' => 'Mail non valida'));
} else {
  $email = $_POST['mail'];
  $result=$dbh->getUserRecover($email);

  $nome = $result["Nome"];
  $cognome =$result["Cognome"];
  $id = $result["IdUtente"];
  $newpassword = genPw();

  //send the message, check for errors
  if (!sendMail($nome, $cognome, $id, $newpassword, $email) || !($result=$dbh->updatePassword(hash('sha512', $newpassword)))) {
    echo json_encode(array('result' => 'error', 'message' => 'Errore nell invio della email'));
  } else {
    echo json_encode(array('result' => 'ok', 'message' => 'Controlla la tua posta elettronica'));
  }
}

function genPw(){
  $colori = array(
      'bianco'
    , 'viola'
    , 'giallo'
    , 'verde'
    , 'blu'
    , 'celeste'
    , 'arancione'
    , 'nero'
    , 'marrone'
    , 'indaco'
    , 'rosso'
    , 'grigio'
    , 'magenta'
    , 'ciano'
    , 'zaffiro'


  );

  $animali = array(
      'cane'
    , 'gatto'
    , 'coccodrillo'
    , 'topo'
    , 'anatra'
    , 'cicogna'
    , 'acquila'
    , 'lupo'
    , 'bue'
    , 'zebra'
    , 'leone'
    , 'fagiano'
    , 'donnola'
    , 'lama'
    , 'macaco'


  );

  $rand_keys1 = array_rand($colori, 2);
  $rand_keys2 = array_rand($animali, 2);
  $newpassword = $colori[$rand_keys1[0]] . $animali[$rand_keys2[0]] . $rand_keys1[0].$rand_keys2[0];

  return $newpassword;
}


function sendMail($nome, $cognome, $id, $newpassword, $email){

  $message = "<b>- Email inviata automaticamente. Non è possibile rispondere -</b>
              <br>
              <br>".date("Y/m/d, H:i:s")."
              <br>
              <br>Gentile ".$nome ." ".$cognome.",
              <br>La tua password è stata reimpostata e sarà possibile modificarla dopo il log-in,
              <br>ecco i tuoi nuovi dati:
              <br>ID UTENTE: ".$id."
              <br><Stong>PASSWORD</Strong>: ".$newpassword."<br>";


  $subject = 'Recupero password personale - Sistema di riciclaggio BioDiesel';

          // To send HTML mail, the Content-type header must be set
  $headers[] = 'MIME-Version: 1.0';
  $headers[] = 'Content-type: text/html; charset=iso-8859-1';





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

  //Username to use for SMTP authentication - use full email address for gmail
  $mail->Username = "eventi@agriturismomarcheok.it";

  //Password to use for SMTP authentication
  $mail->Password = ".E0JTXQv{?Ru*"; //passsssssssssssssssssss?????

  //Set who the message is to be sent from
  $mail->setFrom('eventi@agriturismomarcheok.it', 'TicketTwo');
  $mail->AddReplyTo("no-reply@agriturismomarcheok.it","No Reply");

  //Set who the message is to be sent to
  $mail->addAddress($email, $nome." ".$cognome);

  $mail->IsHTML(true);
  //Set the subject line
  $mail->Subject = $subject;

  $mail->Body    = $message;

  //TO DO
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  return $mail->send();
}


?>
