

<?php

    require_once 'init.php';

    class Chat{

        protected static $table = "users";
        protected static $last_activity_table = "last_activity";
        protected static $chat_data_table = "chat_data";
        public $username;
        public $email;
        public $password;
        public $user_id;
        public static $id;
        public $file_path = '';


        public $filename;
        public $type;
        public $size;
        public $tmp_path;
        public $upload_errors_array = array(
            UPLOAD_ERR_OK               =>  "There is no error",
            UPLOAD_ERR_INI_SIZE         =>  "The uploaded file exceeds the upload_max_filesize directive in php.ini",
            UPLOAD_ERR_FORM_SIZE        =>  "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
            UPLOAD_ERR_PARTIAL          =>  "The uploaded file was only partially uploaded",
            UPLOAD_ERR_NO_FILE          =>  "No file was uploaded",
            UPLOAD_ERR_NO_TMP_DIR       =>  "Missing temporary folder",
            UPLOAD_ERR_CANT_WRITE       =>  "Failed to write file to disk",
            UPLOAD_ERR_EXTENSION        =>  "A PHP extension stopped the file upload."
        );


        public static function generate_username($name){
            $full = explode(' ', $name);
            $myRand = mt_rand(99, 9999999);
            $myRand = substr($myRand, 0, 5);
            $username = $full[0].$myRand;
            return $username;
        }

        //////// Register Users/////
        public function RegisterUser($data){
            global $database;

            $username = self::generate_username($data['full_name']);
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
         
            $sql = "INSERT INTO " . static::$table ." (full_name, username, email, password, gender) ";
            $sql .= "VALUES( '";
            $sql .= $database->escape_string($data['full_name']) . "', '";
            $sql .= $database->escape_string($username) . "', '";
            $sql .= $database->escape_string($data['email']) . "', '";
            $sql .= $database->escape_string($password) . "', '";
            $sql .= $database->escape_string($data['gender']) . "')";
    
            if($database->query($sql)){
                self::$id = $database->the_insert_id();
                return true;
            }else{
                return false;
            }



        }


       

        public static function verify_email($email){
            global $database;
            $email = $database->escape_string($email);
            $sql = "SELECT * FROM " . self::$table ." WHERE ";
            $sql .= "email = '{$email}' ";
            $sql .= "LIMIT 1";
           
            $result = self::find_this_query($sql);
            return $result;
        }


        private static function find_this_query($sql){
            global $database;
            $result_row = [];
            $result = $database->query($sql);
            while($row = mysqli_fetch_array($result)){
                $result_row = $row;
            }
            return $result_row;
        }


        public function verify_user($data){
            global $database;

            $email = $database->escape_string($data['email']);
            $sql = "SELECT * FROM " . self::$table ." WHERE ";
            $sql .= "email = '{$email}' ";
            $sql .= "LIMIT 1";
           
            $result = self::find_this_query($sql);
            return $result;

        }

        public function get_all_details_by_username($username){
            global $database;

            $email = $database->escape_string($username);
            $sql = "SELECT * FROM " . self::$table ." WHERE ";
            $sql .= "username = '{$username}' ";
            $sql .= "LIMIT 1";
           
            $result = self::find_this_query($sql);
            return $result;
        }


        public function upload_image($data, $username){

            $details = self::get_all_details_by_username($username);

            $rand_time = time();
            $tmp_path = $data['tmp_name'];
            $valid_extension = array('jpg', 'jpeg', 'png');

           $file = explode('.', basename($data['name']));
           $extension = strtolower(end($file));

           if(in_array($extension, $valid_extension)){
                $image_name = $username.$rand_time.'.'.$extension;
                move_uploaded_file($tmp_path, "img/" .$image_name);

                if(self::store_image_data($image_name, $username)){
                    if(file_exists('img/'. $details['img'])){
                        unlink('img/'. $details['img']);
                    }

                    $_SESSION['img'] = $image_name;
                    
                    return "Image has been uploaded";
                };
               
                 
           }

        }

        public function store_image_data($name, $username){
            global $database;
            $sql = "UPDATE " . self::$table ." SET ";
            $sql .= "img = '" . $database->escape_string($name)      . "'";
            $sql .= " WHERE username = '" . $database->escape_string($username) . "'";
    
            $database->query($sql);
            return (mysqli_affected_rows($database->connection) == 1) ? true : false;
        }


        public static function get_online_users(){
            global $database;
          //  $email = $database->escape_string($data['email']);
            $sql = "SELECT * FROM " . self::$last_activity_table . " WHERE status = 'online' ORDER BY last_time DESC";
            
            $result = $database->query($sql);
            return $result;
           
        }




        public static function get_offline_users(){
            global $database;
        //  $email = $database->escape_string($data['email']);
            $sql = "SELECT * FROM " . self::$last_activity_table . " WHERE status = 'offline' ORDER BY last_time DESC";
            
            $result = $database->query($sql);
            return $result;
        }


        public function load_chat_data($other_user){
            global $database;
            $check_count = 0;
            $log_name = $_SESSION['username'].$other_user;

            $r_log_name = $other_user.$_SESSION['username'];
            $checking_files = false;
            
                if(!file_exists('logs/'.$log_name .'.json')){
                    $check_count++;
                }else{
                    if(file_exists('logs/'.$log_name .'.json')){
                        $this->file_path = 'logs/'.$log_name .'.json';
                    }
                    
                }

                if(!file_exists('logs/'.$r_log_name.'.json')){
                    $check_count++;
                }else{
                    if(file_exists('logs/'.$r_log_name.'.json')){
                        $this->file_path = 'logs/'.$r_log_name.'.json';
                    }
                }

                if($check_count == 2){
                   fopen('logs/'.$log_name.'.json', 'w');
                  // fclose('logs/'.$log_name.'.json');
                    $this->file_path = 'logs/'.$log_name.'.json';
                    $result = self::load_chat_log('logs/'.$log_name.'.json');
                    return $result;
                }

                if($this->file_path != ''){
                    $result = self::load_chat_log($this->file_path);
                    return $result;
                }
                

        }


        public static function load_chat_log($path){
            $data = file_get_contents($path);
            return $json = json_decode($data);
        }

        public function get_path(){
            $current_path = $this->file_path;
            return $current_path;
        }
       

        public function save_chat_log($chat, $receiver){
            global $database;

            $log_id = $_SESSION['username'].$receiver;
            $current_time = time();

         
            $sql = "INSERT INTO chat_log (user1, user2, log_id, chat_msg, chat_time) ";
            $sql .= "VALUES( '";
            $sql .= $database->escape_string($_SESSION['username']) . "', '";
            $sql .= $database->escape_string($receiver) . "', '";
            $sql .= $database->escape_string($log_id) . "', '";
            $sql .= $database->escape_string($chat) . "', '";
            $sql .= $database->escape_string($current_time) . "')";
    
            if($database->query($sql)){
                self::$id = $database->the_insert_id();
                return true;
            }else{
                return false;
            }
        
        }

        public function get_chat_history($current_user, $other_user){
            global $database;
            $path1 = $current_user.$other_user;
            $path2 = $other_user.$current_user;
            $sql = "SELECT * FROM chat_log WHERE log_id = '$path1' OR log_id = '$path2'";
            
            $result = $database->query($sql);
            return $result;

        }
    
    
        public function instantation($the_record){
           // $calling_class = get_called_class();
            $the_object = new self;
            foreach ($the_record as $property => $value) {
                if($the_object->has_property($property)){
                    $the_object->$property = $value;
                }
            }
            return $the_object;
        }
    
    
        private function has_property($property){
            $object_property = get_object_vars($this);
            return array_key_exists($property, $object_property);
        }
    




    }



    if(isset($_POST['chat'])){
        //////// Sanitize the POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $chat = trim($_POST['chat']);
        $receiver = trim($_POST['receiver']);
        $path = $_POST['path'];
        $current_time = time();

        $chat_err = '';
        $receiver_err = '';

        if(empty($chat)){
           $chat_err = 'no chat data';
        }

        if(empty($receiver)){
            $receiver_err = "no receiver";
        }

        if(empty($chat_err) && empty($receiver_err)){
            $chat_class = new Chat;
            $chat_class->save_chat_log($chat, $receiver);
        }


    }



