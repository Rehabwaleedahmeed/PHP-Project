<?php
require_once "../config/Database.php";
require_once "../models/User.php";

class authController {

    private $user;

    public function __construct(){

        $db = new Database();
        $conn = $db->connect();

        $this->user = new User($conn);
    }

    public function login($email,$password){

        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->user->conn->prepare($query);

        $stmt->bindParam(":email",$email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user && password_verify($password,$user['password'])){

            session_start();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            header("Location: /home");

        } else {

            echo "Invalid login";

        }
    }

    public function logout(){

        session_start();
        session_destroy();

        header("Location: /login");
    }
}