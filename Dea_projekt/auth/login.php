<?php
require_once '../includes/config.php';
require_once '../includes/auth_functions.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    $userType = authenticate($username, $password);

    if($userType) {
        redirect($userType === 'client' ? '../client/dashboard.php' : '../technician/dashboard.php');
    } else {
        $error = "Kredenciale të pasakta. Ju lutem provoni përsëri.";
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Identifikohu - Tekniku Im</title>
    <!-- Add your CSS here -->
</head>
<body>
<div class="auth-container">
    <h2>Identifikohu</h2>

    <?php if(isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="username">Emri i përdoruesit:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Fjalëkalimi:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn">Identifikohu</button>
    </form>

    <p>Nuk keni llogari? <a href="register.php">Regjistrohu këtu</a></p>
</div>
</body>
</html>