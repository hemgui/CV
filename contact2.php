<?php 


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

$sent = email("hemgui@gmail.com", "toto@gmail.com", "Guillaume H", "CV - formulaire contact", "un corps de message de test");
var_dump($sent);