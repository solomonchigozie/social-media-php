<?php 
session_start();
if(!isset($_SESSION['loggedin'])){
    header('location:login.php');
}

//database file
require('config/db.php');


//convert timestamp
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
                                    <h5 class="font-weight-bold text-dark mb-1 mt-4"> <a href="#"><?=$_SESSION['fullname']?></a> </h5>
                                    
                                    <a class="font-weight-bold text-dark" href="editprofile.php">@<?=$_SESSION['username']?></a>

                                    <div class="text-center">Joined: <?=date_format(date_create($_SESSION['joined']),"F j\, Y")?></div>
                                    
                                <?php
                                }
                            
                            ?>
                        </div>
                        <div class="overflow-hidden border-top">
                            <a class="font-weight-bold p-3 d-block" href="<?=$_SERVER['PHP_SELF']?>?logout=1"> Log Out </a>
                        </div>
                    </div>
                </aside>

                <main class="col col-xl-6 order-xl-2 col-lg-12 order-lg-2 col-md-12 col-sm-12 col-12">

                    <!-- bio -->
                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Bio <a href="editprofile.php"><i class="feather-edit mr-2"></i></a> </h6>
                        </div>
                        <div class="box-body p-3">
                            <p>
                                <?php 
                                    $userid = $_SESSION['userid'];
                                    $query = mysqli_query($conn, "SELECT * FROM users WHERE userid=$userid ");
                                    $num = mysqli_fetch_array($query);

                                    if($num != 0){
                                        //if its empty
                                        if($num['biography'] == NULL){
                                            echo "<div class='text-center'>Add a bio <a href='editprofile.php'><i class='feather-edit mr-2'></i></a></div>";
                                        }else{
                                            echo $num['biography'];
                                        }
                                        
                                    }
                                
                                ?>
                            </p>
                            
                        </div>
                    </div>

                    <!-- personal information -->
                    <div class="box shadow-sm border rounded bg-white mb-3">
                        <div class="box-title border-bottom p-3">
                            <h6 class="m-0">Personal Information <a href="editprofile.php"><i class="feather-edit mr-2"></i></a></h6>
                        </div>
                        <div class="box-body p-3 border-bottom">
                            <div class="d-flex align-items-top job-item-header pb-2">
                                <div class="mr-2">
                                    <div class="text-dark mb-0 pb-2"><i class="feather-user mr-2"></i> Name : <?=$_SESSION['fullname']?></div>
                                    <div class="text-dark mb-0 py-2"><i class="feather-inbox mr-2"></i> Email : <?=$_SESSION['email']?></div>
                                    <div class="text-dark mb-0 py-2"><i class="feather-phone mr-2"></i> Phone Number : <?=$_SESSION['phone']?></div>
                                    <div class="text-dark mb-0 py-2"><i class="feather-map mr-2"></i> Location: <?=$_SESSION['location']?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php 
                        /**
                         * this gets the post from the posts table and joins with the users table using the posters id on both tables
                         */
                        // $getposts = mysqli_query($conn, "SELECT * FROM posts ORDER BY id DESC limit 10");
                        $getposts = mysqli_query($conn, "SELECT * FROM posts INNER JOIN users on posts.userid=users.userid AND users.userid=$userid ");
                        if(mysqli_num_rows($getposts) >0){

                            while($num = mysqli_fetch_array($getposts)){
                    
                    ?>
                            <div class="box shadow-sm border rounded bg-white mb-3 osahan-post" id="box<?=$num['id']?>">
                                <div class="p-3 text-right border-bottom osahan-post-header text-danger d-flex justify-content-between" >
                                    <div id="req<?=$num['id']?>"></div>
                                    <div class="delete" id="<?=$num['id']?>"  style="cursor:pointer"><i class="feather-trash text-danger"></i> Delete Post</div>
                                </div>
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
                                    <p class="mb-0">
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
                                    <p class="mb-0 text-center">
                                        You haven't made any post yet.
                                    </p>
                                </div>
                            </div>
                            
                            <?php
                    }
                    
                    ?>

                </main>


                
            </div>
        </div>
    </div>

    <!-- footer begins  -->
    <?php require('includes/footer.php') ?>
    <!-- footer ends  -->

    <script src="https://www.ebusinessflow.com/school/assets/sweetalert/sweetalert.min.js"></script>
    <script>
        $("div").on('click', '.delete',function(){
            var id = $(this).attr("id")
            swal({
                title: "Are you sure?",
                text: "This action will remove your post from the feed",
                icon: "info",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    
                    $.ajax({
                        url : 'ajax/deleteposts.php',
                        type : 'post',
                        beforeSend : function(){
                            $("#req"+id).addClass("spinner spinner-border spinner-border-sm")
                        },
                        data : {id : id},
                        success : function(data){
                            $("#req"+id).removeClass("spinner spinner-border spinner-border-sm")

                            if(data ==1){
                                swal({
                                    title: "Post has been deleted",
                                    text: "",
                                    icon: "success",
                                })
                                .then((value) => {
                                    // setTimeout(() =>{
                                        // location.reload();
                                        $("#box"+id).remove()
                                    // }, 1400);
                                });
                            }else{
                                swal(data, "","warning");
                            }

                        }
                    })
                
                }
            });//end of promise sent from alert

        })
    </script>
    
</body>


</html>