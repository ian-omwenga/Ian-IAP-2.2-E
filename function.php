<?php
class fnc{
  var $name;
  public $fname;
  protected $username;
  public $yob;
  public $age;
  private $password;

  public function computer_user($fname){
    return $fname;
  }

  public function user_age($fname, $yob){
    $user = $this->computer_user($fname);
    $age= date('Y') - $yob;
    return $user . " is " . $age . " years old.";
  }

  public function hash_pass($pass){
    return password_hash($pass, PASSWORD_DEFAULT);
  }
}

$Obj = new fnc();
print $Obj->user_age('Momanyi', 2004);
print '<br>';
?>
