<?php
session_start();
if(!isset($_SESSION['loggedin'])){
    header('location:login.php');
}

//database file
require('config/db.php');

$userid = $_SESSION['userid'];
$bio = '';
$error = [];
//update BIO
if(isset($_POST['updatebio'])){
    $bio = test_input(mysqli_real_escape_string($conn, $_POST['bio']));

    //VALIDATION FOR BIO
    if(empty($bio)){array_push($error, "bio cannot be empty"); }

    if(count($error) == 0){
        //update bio
        $query = mysqli_query($conn, "UPDATE users SET biography='$bio' WHERE userid=$userid ");
        $_SESSION['msg'] = "Bio updated successfully";
    }else{
        $_SESSION['error'] = "Bio cannot be empty"; 
    }

}


//UPDATE USER PROFILE INFORMATION
$profile_error = [];
if(isset($_POST['updateprofile'])){
    $firstname = test_input(mysqli_real_escape_string($conn, $_POST['firstname']));
    $lastname = test_input(mysqli_real_escape_string($conn, $_POST['lastname']));
    $email = test_input(mysqli_real_escape_string($conn, $_POST['email']));
    $location = test_input(mysqli_real_escape_string($conn, $_POST['location']));
    $phone = test_input(mysqli_real_escape_string($conn, $_POST['phone']));


    if(empty($firstname)){array_push($profile_error, "firstname cannot be empty"); }
    if(empty($lastname)){array_push($profile_error, "lastname cannot be empty"); }
    if(empty($location)){array_push($profile_error, "location cannot be empty"); }
    if(empty($phone)){array_push($profile_error, "phone number cannot be empty"); }

    if(count($profile_error) ==0){
        //update

        $query = mysqli_query($conn, "UPDATE users SET firstname='$firstname', lastname='$lastname', location='$location', phone='$phone' WHERE userid=$userid ");
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['fullname'] = $firstname .' '.$lastname;
        $_SESSION['phone'] = $phone;
        $_SESSION['location'] = $location;
        $_SESSION['msg'] = "Profile information has been updated successfully";
    }

}


//FUNTION TO SANITZE FORM INPUT AGAINST UNWANTED CHARACTERS ETC.
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//fetch user information to fill input boxes
$query = mysqli_query($conn, "SELECT * FROM users WHERE userid=$userid ");
$num = mysqli_fetch_array($query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content>
    <meta name="author" content>
    <link rel="icon" type="image/png" href="img/fav.png">
    <title>PHPour - Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick-theme.min.css" />
    <link href="vendor/icons/feather.css" rel="stylesheet" type="text/css">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />
</head>

<body>

    <!-- nav begins-->
    <?php require('includes/nav.php') ?>
    <!-- nav ends  -->

    <div class="py-4">
        <div class="container">
            <div class="row">

                <aside class="col-md-4">
                    <div class="mb-3 border rounded bg-white profile-box text-center w-10">
                        <div class="p-4 d-flex align-items-center">
                            <img src="img/<?=$_SESSION['picture']?>" class="img-fluid rounded-circle" alt="<?=$_SESSION['fullname']?>">
                            
                        </div>
                    </div>
                    <div class="border rounded bg-white mb-3">
                        <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>">
                            <div class="box-body">
                                <div class="p-3 border-bottom">
                                    <div class="form-group mb-4">
                                        <label class="mb-1">BIO</label>
                                        <div class="position-relative">
                                            <textarea class="form-control" rows="4" cols="42" name="bio" placeholder="Enter Bio"><?=htmlspecialchars($num['biography'])?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="overflow-hidden text-center p-3">
                                    <button class="font-weight-bold btn btn-light rounded p-3 d-block btn-block" type="submit" name="updatebio"> SAVE </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </aside>
                <main class="col-md-8">
                    <div class="border rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Edit Basic Info</h6>
                        </div>
                        <div class="box-body p-3">
                            <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>"  class="js-validate">
                                <?php 
                                    foreach($profile_error as $errors){
                                        ?>
                                            <span class="badge badge-danger"><?=$errors?></span> <br>
                                        <?php
                                    }
                                
                                ?>
                                <div class="row">

                                    <div class="col-sm-6 mb-2">
                                        <div class="js-form-message">
                                            <label id="firstnameLabel" class="form-label">
                                                First Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="firstname" value="<?=$num['firstname']?>" placeholder="Enter your first name" 
                                                    aria-label="Enter your name" required="" id="firstnameLabel" 
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="js-form-message">
                                            <label id="lastnameLabel" class="form-label">
                                                Last Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="lastname" value="<?=$num['lastname']?>" placeholder="Enter your last name" 
                                                    aria-label="Enter your name"  id="lastnameLabel"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6 mb-2">
                                        <div class="js-form-message">
                                            <label id="usernameLabel" class="form-label">
                                                Username
                                                <!-- <span class="text-danger">*</span> -->
                                            </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="username" value="<?=$num['username']?>" placeholder="Enter your user name" 
                                                    aria-label="Enter your username" readonly disabled required="" id="usernameLabel"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="js-form-message">
                                            <label id="email" class="form-label">
                                                Email
                                                <!-- <span class="text-danger">*</span> -->
                                            </label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" value="<?=$num['email']?>" placeholder="Enter your email" 
                                                    aria-label="Enter your email" readonly disabled  required="" id="email"
                                                >
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-6 mb-2">
                                        <div class="js-form-message">
                                            <label id="locationLabel" class="form-label">
                                                Location
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="location" value="<?=$num['location']?>" 
                                                    placeholder="Enter your location" aria-label="Enter your location" required="" >
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-2">
                                        <div class="js-form-message">
                                            <label id="phoneNumberLabel" class="form-label">
                                                Phone number
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-group">
                                                <input class="form-control" type="tel" name="phone" value="<?=$num['phone']?>" 
                                                    placeholder="Enter your phone number" aria-label="Enter your phone number" required="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 text-left ml-auto">
                                        <a class="font-weight-bold btn btn-link rounded p-3 btn-outline-secondary mx-2" href="profile.php"> &nbsp;&nbsp;&nbsp;&nbsp; Cancel &nbsp;&nbsp;&nbsp;&nbsp; </a>
                                        <button class="font-weight-bold btn btn-primary rounded p-3" type="submit" name="updateprofile"> &nbsp;&nbsp;&nbsp;&nbsp; Save Changes &nbsp;&nbsp;&nbsp;&nbsp; </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


    <!-- footer begins  -->
    <?php require('includes/footer.php') ?>
    <!-- footer ends  -->

    <script>
        <?php 
            if(isset($_SESSION['msg'])){
                ?>
                    toastr.success('<?php print_r($_SESSION['msg']) ?>', 'Success',{"closeButton": true})
                <?php
                unset($_SESSION['msg']);
            }

            if(isset($_SESSION['error'])){
                ?>
                    toastr.error('<?php print_r($_SESSION['error']) ?>', 'Error',{"closeButton": true})
                <?php
                unset($_SESSION['error']);
            }
        
        ?>
    </script>


</body>


</html>