<?php
    require_once "../db.php";

    $mode = $_POST['mode'] ?? $_GET['mode'] ?? "";

    switch ($mode) {
        case 'create':
            $pstmt = $db->prepare("INSERT INTO comments (id, postid, userid, text) VALUES (null, :postid, :userid, :text)");

            $pstmt->execute([
                "postid" => $_POST['postid'],
                "userid" => $_SESSION['user']['id'],
                "text" => $_POST['comment']
            ]);

            header("Location: ../view.php?id=" . $_POST['postid']);
            exit;

            break;

        case 'delete':
            $pstmt = $db->prepare("DELETE FROM comments WHERE id = :id");
            $pstmt->execute([
                "id" => $_GET['id']
            ]);

            header("Location: ../view.php?id=" . $_GET['postid']);
            exit;

            break;
    }
?>