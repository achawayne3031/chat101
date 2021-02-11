<?php

    require_once 'include/init.php';

     if(!isset($_SESSION['username'])){
        redirect('login.php');
     }

    $online_users = Chat::get_online_users();
    $offline_users = Chat::get_offline_users();

    if(isset($_GET['user'])){
        $user = $_GET['user'];
        $_SESSION['user2'] = $_GET['user'];

        $chat = new Chat;
        $chat_history = $chat->get_chat_history($_SESSION['username'], $_SESSION['user2']);

    }


    if(isset($_GET['logout'])){
        Session::log_user_out();
    }

   


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Chat</title>
<script src="js/jquery.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/style.css">
<script src="js/bootstrap.min.js"></script>
<script src="js/index.js"></script>
</head>

<body class="chat-room-body">

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-3 col-md-3 col-xl-3 section-bg">
            <div class="d-flex flex-column justify-content-center">

                <!-- <?php if($_SESSION['gender'] == 'male'){ ?>
                    <div class="text-center"><a href="profile.php?myprofile=<?php echo $_SESSION['username']; ?>"><img src="img/male.webp" class="img-fluid rounded-circle img-avatar"></a></div>
                <?php  }else{ ?>
                    <div class="text-center"><img src="img/female.webp" class="img-fluid rounded-circle img-avatar"></div>
                <?php } ?> -->

                <?php if($_SESSION['gender'] == 'male'){ ?>
                    <?php if(!empty($_SESSION['img'])){ ?>
                            <div class="text-center"><a href="profile.php?myprofile=<?php echo $_SESSION['username']; ?>"><img src="img/<?php echo $_SESSION['img']; ?>" class="img-fluid rounded-circle img-avatar"></a></div>
                        <?php }else{ ?>
                            <div class="text-center"><a href="profile.php?myprofile=<?php echo $_SESSION['username']; ?>"><img src="img/male.webp" class="img-fluid rounded-circle img-avatar"></a></div>
                        <?php } ?>
                <?php  }else{ ?>
                    <?php if(!empty($_SESSION['img'])){ ?>
                            <div class="text-center"><a href="profile.php?myprofile=<?php echo $_SESSION['username']; ?>"><img src="img/<?php echo $_SESSION['img']; ?>" class="img-fluid rounded-circle img-avatar"></a></div>
                        <?php }else{ ?>
                            <div class="text-center"><a href="profile.php?myprofile=<?php echo $_SESSION['username']; ?>"><img src="img/female.webp" class="img-fluid rounded-circle img-avatar"></a></div>
                    <?php } ?>
                <?php } ?>


                <div class="text-center mt-2"><span class="session-username-avatar" id="currentUser"><?php echo $_SESSION['username']; ?></span></div>
            </div>
            <a href="chat-room.php?logout=true"><h6 class="mt-1"><span class="btn btn-danger float-right" title="logout"><span class="fa fa-sign-out"></span></span></h6></a>
            <ul class="ul-chat mt-5">
                <?php
                    /////// Load Online Users //////////////
                   while($row = mysqli_fetch_array($online_users)){
                       $username = $row['username'];
                       $img = (!empty($img)) ? $row['img'] : '';
                      // $gender = $row['gender'];

                       if($_SESSION['username'] != $username){
                            echo "<a class='chat-user-links' href='chat-room.php?user=$username'><li class='li-chat'>". $row['username']. "<sup class='badge badge-warning float-right mt-2'>online</sup></li></a>";
                        }
                   }

                   /////// load Offline Users ////////////
                   while($row = mysqli_fetch_array($offline_users)){
                       $username = $row['username'];
                       echo "<a class='chat-user-links' href='chat-room.php?user=$username'><li class='li-chat'>". $row['username']. "<sup class='badge badge-secondary float-right mt-2'>offline</sup></li></a>";
                    }
                ?>
            </ul>
        </div>

        <div class="col-md-9 col-lg-9 col-xl-9 chat-panel pl-0 pr-0 pt-4">
            <div class="chat-log-table" onscroll="stopAutoScroll()" onmouseup="stoppedScroll()">
                <table class="table table-borderless" id="table-active-log">
                    <?php
                        $output = "";      
                        if($chat_history->num_rows != 0){
                            while($row = mysqli_fetch_array($chat_history)){
                                $current = date("g:i a", $row['chat_time']);

                                if($_SESSION['username'] == $row['user1']){
                                    $output .= "<td><span class='user-chat-bg float-right pl-1 pr-3 pt-3 pb-1'>".$row['chat_msg']."<sub class='pl-1'>".$current."</sub></span></td>";
                                }else{
                                    $output .= "<td><span class='receiver-chat-bg pl-1 pr-3 pt-3 pb-1'>".$row['chat_msg']."<sub class='pl-1'>".$current."</sub></span></td>";
                                }
                                $output .= "</tr>";   
                            }
                        }
                        echo $output;
                    ?>
                </table>
            </div>

            <!-- <input type="text" id="path" hidden value="<?php echo (!empty($path)) ? $path : ''; ?>"> -->

                <div class="d-flex justify-content-center p-2" id="input-body-div">
                <?php if(isset($_GET['user'])){ ?>
                    <div class="input-div">
                        <input type="text" class="w-100" name="chat" id="chat">
                        <input type="text" id="session" hidden value="<?php echo $_SESSION['username']; ?>">
                        <input type="text" id="receiver" hidden value="<?php echo $_GET['user']; ?>">
                    </div>
                    <div>
                        <button class="btn btn-primary" onclick="sendChat()"><span class="fa fa-share"></span></button>
                    </div>
                    <?php } ?>
                </div>
               
        </div>

       

    </div>
</div>


<script>
  

  
    
</script>


</body>
</html>