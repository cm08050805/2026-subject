<?php
    require_once "../db.php";

    $mode = $_POST['mode'] ?? $_GET['mode'] ?? "";

    switch ($mode) {
        case 'create':
            $pstmt = $db->prepare("INSERT INTO users (id, email, name, password) VALUES (null, :email, :name, :password)");

            $pstmt->execute([
                "email" => $_POST['email'],
                "name" => $_POST['name'],
                "password" => $_POST['password']
            ]);

            header("Location: ../index.php");
            exit;

            break;

        case 'login':
            $pstmt = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            
            $pstmt->execute([
                "email" => $_POST['userid'],
                "password" => $_POST['userpass']
            ]);

            $user = $pstmt->fetch();

            if (!$user) {
                header("Location: ../index.php");
                exit;
            } 

            $_SESSION['user'] = [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name
            ];

            header("Location: ../index.php");
            exit;
            
            break;

        case 'logout':
            unset($_SESSION['user']);

            header("Location: ../index.php");
            exit;
            
            break;
    }
?>