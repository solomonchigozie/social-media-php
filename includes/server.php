<?php 

//database 
require('config/db.php');


//register user

$firstname= "";
$lastname= "";
$username="";
$email = "";
$password ="";
$error = [];

if(isset($_POST['register'])){
    //multiple validation 

    $firstname = test_input(mysqli_real_escape_string($conn, $_POST['firstname']));
    $lastname = test_input(mysqli_real_escape_string($conn, $_POST['lastname']));
    $username = test_input(mysqli_real_escape_string($conn, $_POST['username']));
    $email = test_input(mysqli_real_escape_string($conn, $_POST['email']));
    $password = test_input(mysqli_real_escape_string($conn, $_POST['password']));

    if(empty($firstname)){array_push($error, "First name cannot be empty"); }

    if (!preg_match("/^[a-zA-Z-' ]*$/",$firstname)) { array_push($error, "Only letters and white space allowed");}

    if(empty($lastname)){ array_push($error, "Last name cannot be empty");}

    if (!preg_match("/^[a-zA-Z-' ]*$/",$lastname)) { array_push($error, "Only letters and white space allowed");}

    if(empty($username)){array_push($error, "Username cannot be empty"); }

    if(empty($email)){array_push($error, "Email cannot be empty"); }

    if(empty($password)){array_push($error, "Password cannot be empty"); }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { array_push($error, "Invalid email format");}

    $select = mysqli_query($conn, "SELECT * FROM users Where email='$email'");
    $check = mysqli_fetch_array($select);

    if($check){array_push($errors, "Email Has Beeen Taken By Another User");}

    $selectuName = mysqli_query($conn, "SELECT * FROM users Where username='$username'");
    $checkusername = mysqli_fetch_array($selectuName);

    if($checkusername){array_push($errors, "Username Has Beeen Taken By Another User");}

    if(count($error) ==0){
        //encrypt Passwordto database
        $password =  hash('sha256', $password); 

        //generate a random set of pictures already stored in the img folder
        $profile = 'u'.rand(1,12).'.png';

        $query = "INSERT INTO users(firstname, lastname, email, username, profile_picture, password)
        VALUES ('$firstname','$lastname','$email','$username','$profile','$password')";

        mysqli_query($conn, $query);

        $_SESSION['msg'] = "Account has been created, you can now login";
        header('location:login.php');
    }
    
}


//log user in
if(isset($_POST['login'])){
    //this will accept both username and email
    $username = test_input(mysqli_real_escape_string($conn, $_POST['username']));
    $password = test_input(mysqli_real_escape_string($conn, $_POST['password']));

    if(empty($username)){array_push($error, "Username cannot be empty"); }

    if(empty($password)){array_push($error, "Password cannot be empty"); }

    $password = hash('sha256', $password);
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' OR email='$username' AND password='$password'");
    $num = mysqli_fetch_array($query);
            
    if($num != 0)
    {
        header('location:index.php');
        $_SESSION['userid'] = $num['userid'];
        $_SESSION['email'] = $num['email'];
        $_SESSION['username'] = $num['username'];
        $_SESSION['firstname'] = $num['firstname'];
        $_SESSION['lastname'] = $num['lastname'];
        $_SESSION['fullname'] = $num['firstname'] .' '.$num['lastname'];
        $_SESSION['picture'] = $num['profile_picture'];
        $_SESSION['phone'] = $num['phone'];
        $_SESSION['location'] = $num['location'];
        $_SESSION['joined'] = $num['date_joined'];
        $_SESSION['loggedin'] = true;
        session_unset($_SESSION['msg']);
        
    }else{
        array_push($error, "Invalid Credentials");
    }
            

}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>