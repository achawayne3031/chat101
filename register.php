<?php

    require_once 'include/init.php';

    $data = [
        'full_name' => '',
        'email' => '',
        'password' => '',
        'gender' => '',
        'full_name_err' => '',
        'email_err' => '',
        'password_err' => '',
        'gender_err' => ''
    ];

    if(isset($_POST['submit'])){
         //////// Sanitize the POST
         $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

         $data = [
            'full_name' => trim($_POST['full_name']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'gender' => (!empty($_POST['gender'])) ? trim($_POST['gender']): '',
            'full_name_err' => '',
            'email_err' => '',
            'password_err' => '',
            'gender_err' => ''
        ];

        if(empty($data['full_name'])){
            $data['full_name_err'] = "Enter your full name";
        }

        if(empty($data['email'])){
            $data['email_err'] = "Enter your email";
        }else{
            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $data['email_err'] = "Invalid email address";
              }
        }

        if(empty($data['password'])){
            $data['password_err'] = "Enter your password";
        }else{
            if(strlen($data['password']) < 8){
                $data['password_err'] = "Password must be 8 or more characters";
            }
        }

        if(empty($_POST['gender'])){
            $data['gender_err'] = "Select your gender";
        }


         if(empty($data['full_name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['gender_err'])){
             if(empty(Chat::verify_email($data['email']))){
                 if(Chat::RegisterUser($data)){
                     $data = [
                        'full_name' => '',
                        'email' => '',
                        'password' => '',
                        'gender' => '',
                        'full_name_err' => '',
                        'email_err' => '',
                        'password_err' => '',
                        'gender_err' => ''

                     ];
                     $msg = "Registration Successful";
                 }  
             }else{
                 $data = [
                     'full_name' => trim($_POST['full_name']),
                     'email' => trim($_POST['email']),
                     'password' => trim($_POST['password']),
                     'gender' => trim($_POST['gender']),
                     'full_name_err' => '',
                     'email_err' => 'email has been registered already',
                     'password_err' => '',
                     'gender_err' => ''
                 ];
             } 
         }






    }




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
                <h5 class="title">SignUp<h5>
                    <?php
                        if(isset($msg)){
                            echo "<div class='alert alert-success'>
                                <h6 class='text-center alert-text'>" .$msg. "</h6>
                            </div>";
                        }
                    ?>
                    <hr>
                <form action="register.php" method="POST">
                    <div class="form-group mb-4">
                        <label class="label-text">Full Name <sup>*</sup></label>
                        <input name="full_name" type="text" class="sign-input form-control <?php echo (!empty($data['full_name_err'])) ? 'is-invalid' : '' ; ?>" placeholder="Full Name..." value="<?php echo $data['full_name']; ?>">
                        <span class="invalid-feedback"><?php echo $data['full_name_err']; ?></span>
                    </div>

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

                        <div class="form-group mb-3">
                            <label class="label-text">Gender <sup>*</sup></label>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" <?php echo ($data['gender'] == 'male') ? 'checked' : ''; ?> class="form-check-input" name="gender" value="male"><span class="input-gender">Male</span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" <?php echo ($data['gender'] == 'female') ? 'checked' : ''; ?> class="form-check-input" name="gender" value="female"><span class="input-gender">Female</span>
                                </label>
                            </div>
                            <span class="gender-err"><?php echo $data['gender_err']; ?></span>
                        </div>

                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-success"><span class="fa fa-edit"></span> Register</button>
                        <a href="login.php" class="btn btn-light"><span class="fa fa-sign-in"></span> Login</a>
                    </div>
                </form>

            </div>

        </div>
    </div>
</section>


</body>
</html>