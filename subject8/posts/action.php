<?php
    require_once "../db.php";

    $mode = $_POST['mode'] ?? $_GET['mode'] ?? "";

    switch ($mode) {
        case 'create':
            $pstmt = $db->prepare("INSERT INTO posts (id, userid, category, title, text, img) VALUES (null, :userid, :category, :title, :text, :img)");

            $img = null;

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $img = $_FILES['img']['name'];
                move_uploaded_file(
                    $_FILES['img']['tmp_name'],
                    "../upload/" . $img
                );
            }

            $pstmt->execute([
                'userid'   => $_SESSION['user']['id'],
                'category' => $_POST['category'],
                'title'    => $_POST['title'],
                'text'     => $_POST['comment'],
                'img'      => $img
            ]);

            header("Location: ../index.php");
            exit;

            break;

        case 'update':
            $pstmt = $db->prepare("UPDATE posts set category = :category, title = :title, text = :text, img = :img WHERE id = :id");

            $img = null;

            if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
                $img = $_FILES['img']['name'];
                move_uploaded_file(
                    $_FILES['img']['tmp_name'],
                    "../upload/" . $img
                );
            }

            $pstmt->execute([
                "category" => $_POST['category'],
                "title" => $_POST['title'],
                "text" => $_POST['comment'],
                "img" => $img,
                "id" => $_POST['postid']
            ]);

            header("Location: ../index.php");
            exit;

            break;

        case 'delete':
            $pstmt = $db->prepare("DELETE FROM posts WHERE id = :id");
            $pstmt->execute([
                "id" => $_GET['id']
            ]);

            header("Location: ../index.php");
            exit;

            break;
    }
?>