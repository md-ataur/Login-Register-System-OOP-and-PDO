<?php

include_once 'lib/Session.php';
include 'lib/Database.php';

class User {
    private $db;
    function __construct() {
        $this->db = new Database();
    }

    /* user registration mechanism*/
    public function userRegistration($data){        
        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];
        $password   = $data['password'];
        $chk_email  = $this->emailCheck($email);

        /* data validation start*/
        if($name == "" OR $username == "" OR $email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must not be Empty</div>";
            return $msg;
        }

        if (strlen($username) < 4){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username is too short</div>";
            return $msg;

        }elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username must only contain alphanumerical, dashes and underscores !</div>";
            return $msg;
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is not valid!</div>";
            return $msg;
        }

        if($chk_email == true){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address already Exist!</div>";
            return $msg;

        } /* data validation end*/


        /* data insert start */
        $sql = "INSERT INTO tbl_user (name, username, email, password) VALUES (:name, :username, :email, :password)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', md5($password));
        $result = $query->execute();
        
        if($result){
            $msg = "<div class='alert alert-success'><strong>Success !</strong> You have been registered!</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>Sorry !</strong> Please check your input field!</div>";
            return $msg;

        } /* data insert end */

    } 
    

    /* email check method */   
    public function emailCheck($email){
        $sql = "SELECT email FROM tbl_user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        } else{
            return false;
        }
    }


    /* Data fetch from database for session */
    public function getLoginUser($email, $password){
        $sql = "SELECT * FROM tbl_user WHERE email = :email AND password = :password LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->bindValue(':password', md5($password));
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }


    /* user login mechanism */
    public function userLogin($data){       
        $email      = $data['email'];
        $password   = $data['password'];
        $chk_email  = $this->emailCheck($email);

        /* data validation start*/
        if($email == "" OR $password == ""){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must not be Empty</div>";
            return $msg;
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is not valid!</div>";
            return $msg;
        }

        if($chk_email == false){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address not Exist!</div>";
            return $msg;

        } /* data validation end*/


        /* Data include inside the session*/
        $value = $this->getLoginUser($email, $password);
        if ($value) {
            Session::init();
            Session::set("login", true);
            Session::set("id", $value->id);
            Session::set("name", $value->name);
            Session::set("username", $value->username);
            Session::set("loginmsg", "<div class='alert alert-success'><strong>Success !</strong> You are Loggedin!</div>");
            header("Location:index.php");

        } else{
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> User or password invalid!</div>";
            return $msg;
        }
    }

    /* data fetch and show index page */
    public function getUserData(){
        $sql = "SELECT * FROM tbl_user ORDER BY id DESC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;

    }


    /* data fetch and show profile page */
    public function getUserById($id){
        $sql = "SELECT * FROM tbl_user WHERE id = :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    /* profile page data update */ 
    public function updateUserData($id, $data){
        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];

        /* data validation start*/
        if($name == "" OR $username == "" OR $email == ""){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must not be Empty</div>";
            return $msg;
        }

        if (strlen($username) < 4){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username is too short</div>";
            return $msg;

        }elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Username must only contain alphanumerical, dashes and underscores !</div>";
            return $msg;
        }

        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> The email address is not valid!</div>";
            return $msg;
        } /* data validation end*/


        /* data update start */
        $sql = "UPDATE tbl_user SET 
                name     = :name,
                username = :username,
                email    = :email 
                WHERE id = :id";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name', $name);
        $query->bindValue(':username', $username);
        $query->bindValue(':email', $email);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        
        if($result){
            $msg = "<div class='alert alert-success'><strong>Success !</strong> Userdata updated successfully!</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>Sorry !</strong> Userdata not updated!</div>";
            return $msg;

        } /* data update end */

    }


    /* Old password check */
    private function checkPassword($id, $oldpass){
        $password = md5($oldpass);
        $sql = "SELECT password FROM tbl_user WHERE id = :id AND password = :password";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->bindValue(':password', $password);
        $query->execute();
        if($query->rowCount() > 0){
            return true;
        } else{
            return false;
        }

    }
    

    /* password update */
    public function updatePassword($id, $passdata){
        $oldpass   = $passdata['oldpass'];
        $newpass   = $passdata['newpass'];
        $chck_pass = $this->checkPassword($id, $oldpass);

        if($oldpass == "" OR $newpass == ""){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Field must not be Empty</div>";
            return $msg;
        }

        if($chck_pass == false){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Old passwrod not exist</div>";
            return $msg;
        }

        if(strlen($newpass) < 6){
            $msg = "<div class='alert alert-danger'><strong>Error !</strong> Password too short</div>";
            return $msg;
        }

        $password = md5($newpass);
        $sql = "UPDATE tbl_user SET password = :password WHERE id = :id";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':password', $password);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        
        if($result){
            $msg = "<div class='alert alert-success'><strong>Success !</strong> Updated Password successfully!</div>";
            return $msg;
        }else{
            $msg = "<div class='alert alert-danger'><strong>Sorry !</strong> Password not updated!</div>";
            return $msg;

        }

    }

}

?>