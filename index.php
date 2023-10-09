<?php 
session_start();

/**
 * we use sessions to keep users logged in and restrict access to
 * various pages but for this page a user is allowed to 
 * access it without being logged in. 
 */


 //this is the database configuration file
require('config/db.php');

/**
 * check if a user is logged in then assign user session to a function 
 * which is used later beneath this page
 */
if(isset($_SESSION['loggedin'])){

    $userid = $_SESSION['userid'];
}

//this is triggered when a user make a post
$error = [];
$post = "";
$location ="";
$weather = "";
if(isset($_POST['post'])){
    $post = test_input(mysqli_real_escape_string($conn, $_POST['postbody']));
    $location = test_input(mysqli_real_escape_string($conn, $_POST['location']));
    $weather = test_input(mysqli_real_escape_string($conn, $_POST['weather']));

    /**
     * validate user post input and store all errors in an errors array
     * which is returned to the user.
     */
    if(empty($post)){array_push($error, "Please add a post"); }
    if(empty($location)){array_push($error, "Please add a location"); }
    if(empty($weather)){array_push($error, "Please add a weather condition"); }

    if(strlen($weather) > 3){array_push($error, "Enter a valid weather condition"); }

    if(!is_numeric($weather)){array_push($error, "Enter a numeric value for the weather condition");}else{
        if($weather >=100 ){
            array_push($error, "Enter a valid weather condition");
        }
    }

    if(!empty($_FILES["image"]["name"])){
        $imgfile=$_FILES["image"]["name"];
        // get the image extension
        $extension = substr($imgfile,strlen($imgfile)-4,strlen($imgfile));
        // allowed extensions
        $allowed_extensions = array(".jpg","jpeg",".png",".gif");
        // Validation for allowed extensions .in_array() function searches an array for a specific value.

        if ($_FILES["image"]["size"] > 500000) {
            array_push($error, "Sorry, your file is too large");
        }
        elseif(!in_array($extension,$allowed_extensions)){
            array_push($error, "Invalid format. Only jpg / jpeg/ png /gif format allowed");
        }
        else{
            //rename the image file
            $imgnewfile=md5($imgfile).$extension;
            $target_dir = "uploads/";
            $target_file = $target_dir . $imgnewfile;

            
            // Code for move image into directory
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                array_push($error, "could not save image"); 
            }
        }
    }

    if(count($error) ==0){
        //if there are no errors in the request, store the post requests in the database 
        if(!empty($_FILES["image"]["name"])){
            //if there is an image
            $query = "INSERT INTO posts(userid, post, location, weather,image) 
            VALUES ('$userid','$post','$location','$weather','$imgnewfile')";
        }else{
            //if no image was added
            $query = "INSERT INTO posts(userid, post, location, weather) 
            VALUES ('$userid','$post','$location','$weather')";
        }


        mysqli_query($conn, $query);

        $post="";$location="";$weather="";
        $_SESSION['msg'] = "Your post has been shared successfully";
    }else{
        $_SESSION['error'] = implode(", ", $error);
    }


}


//function to sanitize input
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//function to convert timestamp to human readable stamp e.g 3 days ago etc.
function time_Ago($time) {
  
    // Calculate difference between current
    // time and given timestamp in seconds
    $diff     = time() - $time;
      
    // Time difference in seconds
    $sec     = $diff;
      
    // Convert time difference in minutes
    $min     = round($diff / 60 );
      
    // Convert time difference in hours
    $hrs     = round($diff / 3600);
      
    // Convert time difference in days
    $days     = round($diff / 86400 );
      
    // Convert time difference in weeks
    $weeks     = round($diff / 604800);
      
    // Convert time difference in months
    $mnths     = round($diff / 2600640 );
      
    // Convert time difference in years
    $yrs     = round($diff / 31207680 );
      
    // Check for seconds
    if($sec <= 60) {
        echo "$sec seconds ago";
    }
      
    // Check for minutes
    else if($min <= 60) {
        if($min==1) {
            echo "one minute ago";
        }
        else {
            echo "$min minutes ago";
        }
    }
      
    // Check for hours
    else if($hrs <= 24) {
        if($hrs == 1) { 
            echo "an hour ago";
        }
        else {
            echo "$hrs hours ago";
        }
    }
      
    // Check for days
    else if($days <= 7) {
        if($days == 1) {
            echo "Yesterday";
        }
        else {
            echo "$days days ago";
        }
    }
      
    // Check for weeks
    else if($weeks <= 4.3) {
        if($weeks == 1) {
            echo "a week ago";
        }
        else {
            echo "$weeks weeks ago";
        }
    }
      
    // Check for months
    else if($mnths <= 12) {
        if($mnths == 1) {
            echo "a month ago";
        }
        else {
            echo "$mnths months ago";
        }
    }
      
    // Check for years
    else {
        if($yrs == 1) {
            echo "one year ago";
        }
        else {
            echo "$yrs years ago";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content>
    <meta name="author" content>
    <link rel="icon" type="image/png" href="img/fav.png">
    <title>PHPour</title>

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

                <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-1 col-md-12 col-sm-12 col-12">

                    <!-- your thoughts -->
                    <?php 
                        //only logged in users can see a post box
                        if(isset($_SESSION['loggedin'])){
                    ?>

                        <div class="box shadow-sm border rounded bg-white mb-3 osahan-share-post">
                            <ul class="nav nav-justified border-bottom osahan-line-tab" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"aria-controls="home" aria-selected="true"><i class="feather-edit"></i> Share an update</a>
                                </li>
                            </ul>
                            <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>" enctype="multipart/form-data">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="p-3 d-flex align-items-center w-100" href="#">
                                            <div class="w-100">
                                                <textarea placeholder="Write your thoughts..."  class="form-control border-0 p-0 shadow-none" rows="4" name="postbody"><?=$post?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top p-3 d-flex align-items-center">

                                    <div class="mr-auto ">
                                        <a href="#"  class="text-link small mr-4" data-toggle="modal" data-target="#exampleModal">
                                            <i class="feather-map-pin"></i> Add location and Weather
                                        </a>
                                        <a href="#"  class="text-danger small" data-toggle="modal" data-target="#pictureModal">
                                            <i class="feather-camera"></i> Add a photo
                                        </a>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel"></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="location">Location</label>
                                                    <div class="input-group">
                                                        <input type="text" placeholder="Enter Location" value="<?=$location?>" name="location" id="location" class="form-control">
                                                        <div class="input-group-prepend">
                                                        <div class="input-group-text" id="btnGroupAddon"><i class="feather-map-pin"></i> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="weather">Current Weather </label>
                                                    <div class="input-group">
                                                        <input type="number" maxlength="3" placeholder="Enter Weather condition" value="<?=$weather?>" name="weather" id="weather"  class="form-control">

                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text" id="btnGroupAddon">&deg;C &nbsp;<i class="feather-cloud"></i> </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Add to post</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="pictureModal" tabindex="-1" role="dialog" aria-labelledby="pictureModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="pictureModalLabel"></h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="image">Photo</label>
                                                    <div class="input-group">
                                                        <input type="file" placeholder="Enter image" value="<?=$location?>" name="image" id="image" class="form-control">
                                                        <div class="input-group-prepend">
                                                        <div class="input-group-text" id="btnGroupAddon"><i class="feather-camera"></i> </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Add to post</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex-shrink-1">
                                        <button type="submit" name="post"  class="btn btn-primary btn-sm">Post</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    <?php
                        }
                    ?>
                    
                    <?php 

                        /**
                         * this gets the post from the posts table and joins with the users table using the posters id on both tables
                         * THE POSTS ARE DISPLAYED IN A RANDOM ORDER
                         */
                        // $getposts = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC limit 10");
                        $getposts = mysqli_query($conn, "SELECT * FROM posts INNER JOIN users on posts.userid=users.userid ORDER BY ID DESC ");
                        if(mysqli_num_rows($getposts) >0){

                            while($num = mysqli_fetch_array($getposts)){

                    ?>
                    <div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
                        <div class="p-3 d-flex align-items-center border-bottom osahan-post-header">
                            <a href="userprofile.php?sessionid=<?=$num['userid']?>" class="dropdown-list-image mr-3">
                                <img class="rounded-circle" src="img/<?=$num['profile_picture']?>" alt>
                                <div class="status-indicator bg-success"></div>
                            </a>
                            <a href="userprofile.php?sessionid=<?=$num['userid']?>" class="">
                                <div class="text-truncate font-weight-bold text-dark"><?=$num['firstname']?> <?=$num['lastname']?></div>
                                <div class="text-secondary ">@<?=$num['username']?></div>
                            </a>
                            
                            <span class="ml-auto small"><?php // echo  timeago($num['date_added']);
                                echo time_Ago(strtotime(date($num['date_added'])));
                            ?></span>
                        </div>
                        <div class="p-3 border-bottom osahan-post-body">
                            <p class="mb-2">
                                <?=$num['post']?>
                            </p>
                            <?php 
                                if($num['image'] != NULL){
                                    echo '<img src="uploads/'.$num['image'].'" alt="ads" class="img-fluid">';
                                }
                            ?>
                            
                        </div>
                        <div class="p-3 border-bottom osahan-post-footer">
                            <a href="#" class="mr-3 text-secondary"><i class="feather-cloud text-danger"></i> <?=$num['weather']?> &deg;C</a>
                            <a href="#" class="mr-3 text-secondary"><i class="feather-map-pin text-danger"></i>  <?php //$num['location']?><?=$num[3]?></a>
                        </div>
                    </div>

                    <?php 
                            }
                            

                        }else{
                            ?>
                                <div class="box shadow-sm border rounded bg-white mb-3 osahan-post">
                                    <div class="p-3 border-bottom osahan-post-body">
                                        <p class="mb-0">
                                            No post found
                                        </p>
                                    </div>
                                </div>
                                
                                <?php
                        }

                    ?>


                </main>
                <aside class="col col-xl-3 order-xl-1 col-lg-6 order-lg-2 col-md-6 col-sm-6 col-12" >

                    <div class="box mb-3 shadow-sm border rounded bg-white profile-box text-center" >
                        <div class="py-4 px-3 border-bottom">
                            <?php 
                                if(!isset($_SESSION['loggedin'])){
                                    ?>
                                        <img src="img/u4.png" class="img-fluid mt-2 rounded-circle" alt="icon">
                                        <h5 class="font-weight-bold text-dark mb-1 mt-4">
                                            <a href="login.php">Login</a> 
                                            / <a href="register.php">create a new account</a>
                                        </h5>
                                    <?php
                                }else{
                                    ?>
                                    <img src="img/<?=$_SESSION['picture']?>" class="img-fluid mt-2 rounded-circle" alt="user">
                                    <h5 class="font-weight-bold text-dark mb-1 mt-4"> <a href="profile.php"><?=$_SESSION['fullname']?></a> </h5>
                                    <a class="font-weight-bold text-secondary" href="profile.php">@<?=$_SESSION['username']?></a>
                                <?php
                                }
                            
                            ?>
                        </div>
                    </div>

                </aside>

                <aside class="col col-xl-3 order-xl-3 col-lg-6 order-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3 d-flex align-items-center">
                            <h6 class="m-0"><i class='feather-cloud text-primary'></i> Weather Check </h6>
                        </div>
                        <div class="box-body p-3">
                            <?php 
                                //generate random weather
                                //with daily checks
                                // $getposts = mysqli_query($conn, "SELECT * FROM posts where date(date_added)=current_date ORDER BY RAND() LIMIT 1");

                                //without daily checks, fetching from anytmie
                                $getposts = mysqli_query($conn, "SELECT * FROM posts ORDER BY RAND() LIMIT 1");
                                if(mysqli_num_rows($getposts) >0){
                                    $row = mysqli_fetch_assoc($getposts);
                                    // print_r($row);
                                    echo "" .$row['weather'] . "&deg;C at " . $row['location'] ." on ". date_format(date_create($row['date_added']),"F j\, Y");
                                }
                            ?>
                        </div>
                    </div>
                </aside>
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
                    toastr.error('<?php print_r($_SESSION['error'])?> ', 'Post error',{"closeButton": true})
                <?php
                unset($_SESSION['error']);
            }

            
        
        ?>
    </script>

</body>


</html>