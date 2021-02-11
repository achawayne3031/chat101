<?php

    require_once 'include/init.php';



    $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',
    ];

    if(isset($_POST['submit'])){
         //////// Sanitize the POST
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

         $data = [
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'email_err' => '',
            'password_err' => '',
        ];

        if(empty($data['email'])){
            $data['email_err'] = "Enter your email";
        }

        if(empty($data['password'])){
            $data['password_err'] = "Enter your password";
        }


        if(empty($data['email_err']) && empty($data['password_err'])){
            
            $res = Chat::verify_user($data);
            if(empty($res)){
                $msg = "Invalid credential";
               // print_r($res);
            }else{
                $hashed_password = $res['password'];
                if(password_verify($data['password'], $hashed_password)){
                    Session::login_user($res);
                    //print_r($res);
                  //  redirect('chat-room.php');

                }
        
            }

            
        }






    }




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                <h5 class="title">Login<h5>
                    <?php
                        if(isset($msg)){
                            echo "<div class='alert alert-success'>
                                <h6 class='text-center alert-text'>" .$msg. "</h6>
                            </div>";
                        }
                    ?>
                    <hr>
                <form action="login.php" method="POST">

                    <div class="form-group mb-4">
                        <label class="label-text">Email <sup>*</sup></label>
                        <input name="email" type="text" class="sign-input form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : '' ; ?>" placeholder="Email..." value="<?php echo $data['email']; ?>">
                        <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="label-text">Password <sup>*</sup></label>
                        <input name="password" type="text" class="sign-input form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : '' ; ?>" placeholder="Password..." value="<?php echo $data['password']; ?>">
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-success"><span class="fa fa-sign-in"></span> Login</button>
                        <a href="register.php" class="reg-link mt-1">Already Registered ? Not Yet</a>
                    </div>
                </form>

            </div>

        </div>

    </div>
</section>


</body>
</html>