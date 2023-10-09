<?php 
    if(isset($_GET['logout']) || $_GET['logout'] ==1){
        session_destroy();
        header("location:index.php");
    }

?>

<nav class="navbar navbar-expand navbar-dark bg-dark osahan-nav-top p-0" style="position: sticky !important; top: 0px;z-index: 10;">
    <div class="container">
        <a class="navbar-brand mr-2" href="index.php"><img src="img/logo.svg" alt></a>
        <ul class="navbar-nav ml-auto d-flex align-items-center">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="feather-home mr-2"></i><span class="d-none d-lg-inline">Home</span></a>
            </li>
            <?php 
                //if user is not logged in
                if(!isset($_SESSION['loggedin'])){
                    ?>
                        <li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown">
                            <a class="nav-link dropdown-toggle pr-0" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle" src="img/u4.png">
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow-sm">
                                <div class="p-3 d-flex align-items-center">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/u4.png" alt>
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">
                                            <a href="login.php">login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                    <?php

                }else{
                    //if user is logged in
            ?>
            <li class="nav-item dropdown no-arrow ml-1 osahan-profile-dropdown">
                <a class="nav-link dropdown-toggle pr-0" href="#" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <img class="img-profile rounded-circle" src="img/<?=$_SESSION['picture']?>" alt="<?=$_SESSION['fullname']?>">
                </a>

                <div class="dropdown-menu dropdown-menu-right shadow-sm">
                    <div class="p-3 d-flex align-items-center">
                        <div class="dropdown-list-image mr-3">
                            <img class="rounded-circle" src="img/<?=$_SESSION['picture']?>" alt="<?=$_SESSION['fullname']?>">
                            <div class="status-indicator bg-success"></div>
                        </div>
                        <div class="font-weight-bold">
                            <div class="text-truncate"><?=$_SESSION['fullname']?></div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="profile.php"><i class="feather-edit mr-1"></i> My Account</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?=$_SERVER['PHP_SELF']?>?logout=1"><i class="feather-log-out mr-1"></i> Logout</a>
                </div>
            </li>

            <?php  } ?>

        </ul>
    </div>
</nav>