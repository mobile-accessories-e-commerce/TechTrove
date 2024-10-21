<?php
include '../connect.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $type = $_POST['cat_type'];
    $cat_name = $_POST['cat_name'];

    if($type=='product'){
        $quary = "INSERT product_catogory (name) VALUE ('$cat_name')";
    }else{
        $quary = "INSERT service_catogory (name) VALUE ('$cat_name')";
    }

    $result = mysqli_query($con,$quary);
    if($result){
        header("location:admindashbord.php");
    }
}




?>