<?php

class Log{
  public function message($sender,$messageType,$data){
    print $messageType." - ".$data."\n";
  }
}

class SubscriptionList{
  var $list=array();

  public function add($obj,$method){
    $this->list[]=array($obj, $method);
  }

  public function invoke(){
    $args=func_get_args();
    foreach($this->list as $1){
      call_user_func_array($1,$args);
    }
  }
}

class CustomerList{
  public $listeners;

  public function CustomerList(){
    $this->listeners = new SubscriptionList();
  }

  public function addUser($user){
    $this->listeners->invoke($this,"add", "$user");
  }
}

$1= new Log();
$c1= new CustomerList();
$c1->listeners->add($1,'message');
$c1->addUser("starbuck");
?>




?>
