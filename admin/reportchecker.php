<?php

if($_SERVER['REQUEST_METHOD']==='GET'){
    $type = $_GET['type'];
    $id = $_GET['id'];
    if($type == "seller"){
        header("location:seller_reports.php?id='$id'");
    }
    elseif($type == "service_provider"){
        header("location:service_provider_reports.php?id='$id'");
    }
    elseif($type == "product"){
        header("location:product_reports.php?id='$id'");
    }
    else{
        header("location:service_reports.php?id='$id'");   
    }
}



?>