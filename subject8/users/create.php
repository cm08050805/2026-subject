<?php
    $email = $_POST['userid'] ?? "";
    $name = $_POST['username'] ?? "";
    $password = $_POST['userpass'] ?? "";
    $password_confirm = $_POST['userpass2'] ?? "";

    if (!$email || !$name || !$password || !$password_confirm) {
        header("Location: ../join.php?error=empty");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../join.php?error=email");
        exit;
    }

    if ($password !== $password_confirm) {
        header("Location: ../join.php?error=password");
        exit;
    }
?>
<form id="move" method="post" action="action.php">
    <input type="hidden" name="mode" value="create">
    <input type="hidden" name="email" value="<?=$email?>">
    <input type="hidden" name="name" value="<?=$name?>">
    <input type="hidden" name="password" value="<?=$password?>">
</form>

<script>
    document.getElementById('move').submit();
</script>
