<?php


 include 'user.php';
include 'user-pdo.php';

session_start();


   


 $user = new User('Dude','Dude@gmail.com','bblbl','blblbl');
 $userd = new User('Dude','Dude@gmail.com','bblbl','blblbl');
//  $userd->register('blbl','blbl','Dude@gmail.com','bblbl','blblbl');
//   $user->register('Dude','blbl','Dude@gmail.com','bblbl','blblbl');
$userd->isConnected();
   echo $userd->getLogin();
var_dump($_SESSION);

echo $user->GetAllInfos();

$users = new Userpdo();



var_dump($_SESSION);
$users->DelatePdo('shifdedflrki');
$testa = new Userpdo();

$testa->RegisterPdo('sgfhjgkk','ddfghj','Duojlhjkhde@gmail.com','blblbl','blblblbl');

 echo $testa->GetLoginPdo();
 
?>