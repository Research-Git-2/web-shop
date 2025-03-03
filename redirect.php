<?php
session_start();
require_once('db.php');

$_SESSION['user_id'] = $user['id'];
$_SESSION['avatar'] = $user['avatar'];
$_SESSION['login'] = $login;

echo json_encode(["success" => true, "redirect" => "index.html"]);
exit;
?>
