<?php 
session_start();

//validation 
//all the registration validation comes from the file beneath
require('includes/server.php');

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
    <div class="bg-white">
        <div class="container">
            <div class="row justify-content-center align-items-center d-flex vh-100">
                <div class="col-md-4 mx-auto">
                    <div class="osahan-login py-4">
                        <div class="text-center mb-4">
                            <a href="index.php"><img src="img/logo.svg" alt></a>
                            <h5 class="font-weight-bold mt-3">Join PHPour</h5>
                        </div>
                        <form method="post" action="<?=htmlspecialchars($_SERVER["PHP_SELF"])?>" enctype="multipart/form-data">
                            <?php 
                                foreach($error as $errors){
                                    ?>
                                        <span class="badge badge-danger"><?=$errors?></span> <br>
                                    <?php
                                }
                            
                            ?>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-1" for="firstname">First name</label>
                                        <div class="position-relative icon-form-control">
                                            <i class="feather-user position-absolute"></i>
                                            <input type="text" id="firstname" name="firstname" value="<?=$firstname?>" required  class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-1" for="lastname">Last name</label>
                                        <div class="position-relative icon-form-control">
                                            <i class="feather-user position-absolute"></i>
                                            <input type="text" id="lastname" name="lastname" value="<?=$lastname?>" required  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="mb-1" for="username">Username</label>
                                        <div class="position-relative icon-form-control">
                                            <i class="feather-octagon position-absolute"></i>
                                            <input type="text" id="username" name="username" value="<?=$username?>" required  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1" for="email">Email</label>
                                <div class="position-relative icon-form-control">
                                    <i class="feather-at-sign position-absolute"></i>
                                    <input type="email" id="email" name="email" value="<?=$email?>" required  class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-1" for="password">Password (6 or more characters)</label>
                                <div class="position-relative icon-form-control">
                                    <i class="feather-unlock position-absolute"></i>
                                    <input type="password" id="password" name="password" required  class="form-control">
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block text-uppercase" type="submit" name="register" >Join </button>

                            <div class="py-3 d-flex align-item-c">
                                <span class="ml-auto"> Already on PHPour ? <a class="font-weight-bold" href="login.php"> Sign in</a></span>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script src="vendor/slick/slick.min.js"></script>

    <script src="js/osahan.js"></script>
    <script src="js/rocket-loader.min.js" data-cf-settings="5df22122ad34e02e62e862c4-|49" defer></script>

    <script>
        // toastr.success('I do not think that word means what you think it means.', 'Inconceivable!',{"closeButton": true})
        <?php 
            if(isset($_SESSION['msg'])){
                ?>
                    toastr.success('<?php print_r($_SESSION['msg']) ?>', 'Success',{"closeButton": true})
                <?php
            }
        
        ?>
    </script>

</body>


</html>