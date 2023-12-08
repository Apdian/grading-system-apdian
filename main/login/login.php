<?php
require_once("../db_conn.php");
session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $data = [
        "email" => $email,
        "pwd" => $password,
    ];
    if (!empty($email) && !empty($password)) {
        dataValidation($conn, $data);
    } else {
        echo "All field must be filled";
    }
} else {
}
function dataValidation($conn, $data)
{
    $stmt = $conn->prepare("SELECT * FROM teachers WHERE email = :email AND pwd = :pwd ");
    $stmt->execute($data);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($stmt->rowCount() > 0) {
        foreach ($results as $result) {
            //setup sessions
            $_SESSION['userId'] = $result['id'];
            $_SESSION['email'] = $result['email'];

            echo "User login successfully";
        }
    } else {
        echo "User doesn't exist";
    }
}
