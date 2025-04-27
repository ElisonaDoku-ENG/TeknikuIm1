<?php
require_once '../includes/config.php';
require_once '../includes/auth_functions.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirm = sanitize($_POST['confirm_password']);
    $userType = sanitize($_POST['user_type']);

    // Validate
    if($password !== $confirm) {
        $error = "Fjalëkalimet nuk përputhen!";
    } elseif(strlen($password) < 6) {
        $error = "Fjalëkalimi duhet të ketë të paktën 6 karaktere!";
    } else {
        if(registerUser($username, $email, $password, $userType)) {
            if($userType === 'technician') {
                // Redirect to technician profile completion
                $_SESSION['temp_user'] = $username;
                redirect('complete_technician.php');
            } else {
                // Auto-login client
                authenticate($username, $password);
                redirect('../client/dashboard.php');
            }
        } else {
            $error = "Regjistrimi dështoi. Ju lutem provoni përsëri.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Regjistrohu - Tekniku Im</title>
    <!-- Add your CSS here -->
</head>
<body>
<div class="auth-container">
    <h2>Regjistrohu</h2>

    <?php if(isset($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="username">Emri i përdoruesit:</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Fjalëkalimi:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Konfirmo fjalëkalimin:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <div class="form-group">
            <label for="user_type">Unë jam:</label>
            <select id="user_type" name="user_type" required>
                <option value="client">Klient</option>
                <option value="technician">Specialist</option>
            </select>
        </div>

        <button type="submit" class="btn">Regjistrohu</button>
    </form>

    <p>Keni tashmë llogari? <a href="login.php">Identifikohu këtu</a></p>
</div>
</body>
</html>