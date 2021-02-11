<?php

    require_once 'include/init.php';


        if(!empty($_SESSION['user2'])){
            $chat = new Chat;
            $chat_history = $chat->get_chat_history($_SESSION['username'], $_SESSION['user2']);
    
            $output = '';
            while($row = mysqli_fetch_array($chat_history)){
                $current = date("g:i a", $row['chat_time']);
                $output .= "<tr>";
                if($_SESSION['username'] == $row['user1']){
                    $output .= "<td><span class='user-chat-bg float-right pl-1 pr-3 pt-3 pb-1'>".$row['chat_msg']."<sub class='pl-1'>".$current."</sub></span></td>";
                }else{
                    $output .= "<td><span class='receiver-chat-bg pl-1 pr-3 pt-3 pb-1'>".$row['chat_msg'] ."<sub class='pl-1'>".$current."</sub></span></td>";
                }
                $output .= "</tr>";
            }

            echo $output;

        }












