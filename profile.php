<?php

    require_once 'include/init.php';

    if(!isset($_GET['myprofile'])){
        redirect('login.php');
    }else{
        
        $result = Chat::get_all_details_by_username($_GET['myprofile']);
       // print_r($result);
    }


    $data = [
        'img' => '',
        'img_err' => '',
    ];

    if(isset($_POST['submit'])){
         //////// Sanitize the POST
          $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                
            $data = [
                'img' => $_FILES['img'],
                'img_err' => '',
            ];

        if(empty($data['img'])){
            $data['img_err'] = "Pick an image";
        }

        if(!is_array($data['img'])){
            $data['img_err'] = "There was no file uploaded";
        }

        $valid_extension = array('jpg', 'jpeg', 'png');

        $file = explode('.', basename($data['img']['name']));
        $extension = strtolower(end($file));

       if(!in_array($extension, $valid_extension)){
            $data['img_err'] = "only image files allowed (jpg, jpeg, png)";
       }


        if(empty($data['img_err'])){
            $img = $_FILES['img'];
            $result = Chat::upload_image($img, $_GET['myprofile']);
            $msg = $result;
            
        }

        $result = Chat::get_all_details_by_username($_GET['myprofile']);


    }







?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="js/jquery.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
</head>
<body>

<section class="bg">
    <div class="container">
        <div class="row mt-5 pt-4">
            <div class="col-lg-4 col-md-4 col-xl-4 m-auto bg-light p-3 pt-4 reg-body-col">
                <h5 class="title text-center">My Profile</h5>

                    <?php if($_SESSION['gender'] == 'male'){ ?>
                        <?php if(!empty($_SESSION['img'])){ ?>
                                <div class="text-center"><img src="img/<?php echo $_SESSION['img']; ?>" class="img-fluid rounded-circle img-avatar"></div>
                            <?php }else{ ?>
                                <div class="text-center"><img src="img/male.webp" class="img-fluid rounded-circle img-avatar"></div>
                            <?php } ?>
                    <?php  }else{ ?>
                        <?php if(!empty($_SESSION['img'])){ ?>
                                <div class="text-center"><img src="img/<?php echo $_SESSION['img']; ?>" class="img-fluid rounded-circle img-avatar"></div>
                            <?php }else{ ?>
                                <div class="text-center"><img src="img/female.webp" class="img-fluid rounded-circle img-avatar"></div>
                        <?php } ?>
                    <?php } ?>

                    <?php
                        if(isset($msg)){
                            echo "<div class='alert alert-success'>
                                <h6 class='text-center alert-text'>" .$msg. "</h6>
                            </div>";
                        }

                        // if(isset($_SESSION['username'])){
                        //     echo $_SESSION['username'];
                        // }
                    ?>
                    <hr>
                <form action="profile.php?myprofile=<?php echo $_GET['myprofile']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="form-group mb-4">
                        <label class="label-text">Upload Image <sup>*</sup></label>
                        <div class="d-flex">
                            <div>
                                <input name="img" type="file" class="form-control">
                            </div>
                            <div>
                                <button type="submit" name="submit" class="btn btn-success">Upload</button>
                            </div>
                        </div>
                        <span class="gender-err"><?php echo $data['img_err']; ?></span>
                    </div>
                </form>

                <table>
                    <tr>
                        <sup>Username</sup>
                        <h6><?php echo $result['username']; ?></h6>
                    </tr>
                        <hr>
                    <tr>
                        <sup>Email</sup>
                        <h6><?php echo $result['email']; ?></h6>
                    </tr>
                        <hr>
                    <tr>
                        <sup>Gender</sup>
                        <h6><?php echo $result['gender']; ?></h6>
                    </tr>


                    


                </table>

            </div>

        </div>

    </div>
</section>


</body>
</html>