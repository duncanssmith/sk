<?php

class Mailer
{

  protected $to;
  protected $from;
  protected $subject;
  protected $body;
   
  function __construct($to,$from,$subject,$body){
    $this->to = $to;
    $this->from = $from;
    $this->subject = $subject;
    $this->body = $body;
  }

  function getMailDetails(){
     return "TO: {$this->to} <br/>"."FROM: {$this->from} <br/>"."SUBJECT: {$this->subject} <br/>"."BODY: {$this->body}<br/><br/>"; 
  }

  function sendMailNow($sender){
    $ret = mail($this->to, 
                $this->subject, 
                $this->body, 
                "From: $this->from");

    $msg=sprintf("\n%s mail sent?: [%s]\n",$sender, ($ret? "Yes":"No"));
    return $msg; 
  }
 
  static public function hello(){
    $x = "\n\nHello World\n\n";
    return $x;
  }
}


