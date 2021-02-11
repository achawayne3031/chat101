

<?php

    require_once 'init.php';
    session_start();

    class Session{

        public static $is_logged = false;
        protected static $user_table = "users";
        protected static $last_activity_table = "last_activity";

        public static function login_user($data){

            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['id'] = $data['id'];
            $_SESSION['gender'] = $data['gender'];
            $_SESSION['img'] = $data['img'];
            self::is_logged_in();

            self::save_last_activity($_SESSION['username'], 'online', 'login');

            redirect('chat-room.php');

        }
        

        public static function save_last_activity($username, $status, $action){
            global $database;

            $username = $database->escape_string($username);
            $sql = "SELECT * FROM " . self::$last_activity_table . " WHERE ";
            $sql .= "username = '{$username}' ";
            $sql .= "LIMIT 1";

            $result_row = [];
            $result = $database->query($sql);
            while($row = mysqli_fetch_array($result)){
                $result_row = $row;
            }

            $date = time();

            if(empty($result_row)){

                $sql = "INSERT INTO " . static::$last_activity_table ." (username, status, action, last_time) ";
                $sql .= "VALUES( '";
                $sql .= $database->escape_string($username) . "', '";
                $sql .= $database->escape_string($status) . "', '";
                $sql .= $database->escape_string($action) . "', '";
                $sql .= $database->escape_string($date) . "')";
    
                if($database->query($sql)){
                  //  self::$id = $database->the_insert_id();
                    return true;
                }else{
                    return false;
                }

            }else{

                $sql = "UPDATE " . self::$last_activity_table ." SET ";
                $sql .= "username = '" . $database->escape_string($username)      . "', ";
                $sql .= "status = '" . $database->escape_string($status)      . "', ";
                $sql .= "action = '" . $database->escape_string($action)    . "', ";
                $sql .= "last_time = '" . $database->escape_string($date)    . "' ";
                $sql .= " WHERE username = '" . $database->escape_string($username) . "'";

                $database->query($sql);
               // return (mysqli_affected_rows($database->connection) == 1) ? true : false;
            }

        }


        public function is_logged_in(){
            if(isset($_SESSION['username'])){
               self::$is_logged = true;
            }
        }

        public static function log_user_out(){
            self::save_last_activity($_SESSION['username'], 'offline', 'logout');
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            unset($_SESSION['id']);
            unset($_SESSION['gender']);
            self::$is_logged = false;

            redirect('login.php');
        }

    }




