<?php 
session_start();
if(!isset($_SESSION['loggedin'])){
    header('location:login.php');
}

//database file
require('../config/db.php');

$error = [];
if(isset($_POST['id'])){
    //continue
    $ownersid = $_SESSION['userid'];
    $id = test_input(mysqli_real_escape_string($conn, $_POST['id']));

    if(!is_numeric($id)){array_push($error, "invalid");}

    //check if the post belongs to the user requesting a delete
    $verifyUser = mysqli_query($conn, "SELECT * FROM posts Where userid='$ownersid' AND id=$id ");
    if(mysqli_num_rows($verifyUser) ==0){array_push($error, "invalid request");}

    if(count($error) ==0){
        //delete post
        $delete = mysqli_query($conn, "DELETE from posts where id=$id ");

        if($delete){
            //just return 1, the ui will handle the rest
            echo 1;
        }else{
            //this error could be related to  the server because everything has been done properly
            echo "An unknown error occured";
        }
    }else{
        //return the errors
        echo implode(", ", $error);
    }

}else{
    header('location:login.php');
}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>