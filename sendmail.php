<?php
header('Access-Control-Allow-Origin: *');  

$Fname = $_GET["isim"];
$Lname = $_GET["eposta"];
$gender = $_GET["telefon"];
$food = $_GET["mesaj"];
$sub = "Makine Park Iletisim";

    $toEmail = "firat@kirmizi.gen.tr";
    $email_message = "Form details below.\n\n";
    $email_message .= "Name: ".$Fname."\n";
    $email_message .= "Email: ".$Lname."\n";
    $email_message .= "Telephone: ".$gender."\n";
    $email_message .= "Message: ".$food."\n";
    $mailHeaders = "From: " . $Fname . "<". $Lname .">\r\n";
    $mailHeaders .= 'MIME-Version: 1.0' . "\r\n"; 
    $mailHeaders .= "Content-Type: text/plain;charset=charset=utf-8"; 
    if(mail($toEmail, $sub, $email_message, $mailHeaders, $lang)) {
        echo json_encode("sent");
    } else {
        echo json_encode("error");
    }
?>