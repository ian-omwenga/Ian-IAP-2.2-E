<?php
class authentication
{
    public function signup($conn){

        if(isset($_POST["signup"])){
            $fullname = $conn->real_escape_string($_POST["fullname"]);
            $email_address = $_POST["email_address"];
            $username = $_POST["username"];

$cols = ['fullname', 'email', 'username', 'genderId', 'roleId'];
$vals = [$fullname, $email_address, $username, 1, 1];
$data = array_combine($cols, $vals);
$insert = $conn->insert('users', $data);
    if($insert === TRUE){
        header('Location: signup.php');
        exit();
    }else{
      
        die($insert);
    }
        }
    }
}







