<?php 
# if request sent using HTTP_X_REQUESTED_WITH
if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ){
  if (isset($_POST['name']) AND isset($_POST['email']) AND isset($_POST['message'])) {
    $to = 'hemgui@gmail.com';

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    if (strlen($name)>0 && strlen($email)>0 && strlen($message)>0)
    {
        $sent = email($to, $email, $name, "CV - formulaire contact", $message);
        if ($sent) {
          echo 'Message envoyé !';
        } else {
          echo 'Le message n\'a pas pu être envoyé. Vous pouvez m\'envoyer un mail à <a href="mailto://hemgui@gmail.com" target="_blank">hemgui@gmail.com</a>';
        }
    }
     else {
        echo 'Tous les champs sont obligatoires.';
     }
  }
  else {
    echo 'Tous les champs sont obligatoires.';
  }
  return;
}

/**
 * Email send with headers
 *
 * @return bool | void
 **/
function email($to, $from_mail, $from_name, $subject, $message){
  $header = array();
  $header[] = "MIME-Version: 1.0";
  $header[] = "From: {$from_name}<{$from_mail}>";
  /* Set message content type HTML*/
  $header[] = "Content-type:text/html; charset=iso-8859-1";
  $header[] = "Content-Transfer-Encoding: 7bit";
  if( mail($to, "CV - formulaire contact", $message, implode("\r\n", $header)) ) return true; 
}
?>