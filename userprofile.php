<?php 
session_start();


//db
require('config/db.php');


//get the posters information from the database using the get method and redirect 
// to the index if a wrong or non existing id is passed
if(isset($_GET['sessionid'])){
    $id = $_GET['sessionid'];

    //get posters information from the database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE userid=$id ");
    $num = mysqli_fetch_array($query);

    if($num != 0){
        $userid = $num['userid'];
        $email = $num['email'];
        $username = $num['username'];
        $firstname = $num['firstname'];
        $lastname = $num['lastname'];
        $fullname = $num['firstname'] .' '.$num['lastname'];
        $picture = $num['profile_picture'];
        $phone = $num['phone'];
        $location = $num['location'];
        $joined = $num['date_joined'];
    }else{
        header('location:index.php'); 
    }

}else{
    header('location:index.php');
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
    <title>PHPour - Profile</title>
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

                <aside class="col col-xl-3 order-xl-1 col-lg-12 order-lg-1 col-12">
                    <div class="box mb-3 shadow-sm border rounded bg-white profile-box text-center">
                        <div class="py-4 px-3 border-bottom">
                            <img src="img/<?=$picture?>" class="img-fluid mt-2 rounded-circle" alt="user">
                            <h5 class="font-weight-bold text-dark mb-1 mt-4"> <a class="text-primary"><?=$fullname?></a> </h5>
                            
                            <a class="font-weight-bold text-secondary" >@<?=$username?></a>

                            <div class="text-center">Joined: <?=date_format(date_create($joined),"F j\, Y")?></div>
                                
                        </div>
                    </div>
                </aside>

                <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">

                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Bio </h6>
                        </div>
                        <div class="box-body p-3">
                            <p>
                                <?php 
                                    // $userid = $_SESSION['userid'];
                                    $query = mysqli_query($conn, "SELECT * FROM users WHERE userid=$userid ");
                                    $num = mysqli_fetch_array($query);

                                    if($num != 0){
                                        //if its empty
                                        if($num['biography'] == NULL){
                                            echo "<div class='text-center'>No bio</div>";
                                        }else{
                                            echo $num['biography'];
                                        }
                                        
                                    }
                                
                                ?>
                            </p>
                            
                        </div>
                    </div>

                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Personal Information</h6>
                        </div>
                        <div class="box-body p-3 border-bottom">
                            <div class="d-flex align-items-top job-item-header pb-2">
                                <div class="mr-2">
                                    <div class="text-dark mb-0 pb-2"><i class="feather-user mr-2"></i> Name : <?=$fullname?></div>
                                    <div class="text-dark mb-0 py-2"><i class="feather-inbox mr-2"></i> Email : <?=$email?></div>
                                    <div class="text-dark mb-0 py-2"><i class="feather-phone mr-2"></i> Phone Number : <?=$phone?></div>
                                    <div class="text-dark mb-0 py-2"><i class="feather-map mr-2"></i> Location: <?=$location?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </main>


                <aside class="col col-xl-3 order-xl-3 col-lg-12 order-lg-3 col-12">
                    <div class="box shadow-sm mb-3 rounded bg-white ads-box text-center overflow-hidden">
                        <img src="img/ads1.jpg" class="img-fluid" alt="Responsive image">
                        
                    </div>
                </aside>
            </div>
        </div>
    </div>

    <!-- footer begins  -->
    <?php require('includes/footer.php') ?>
    <!-- footer ends  -->
    
</body>


</html>