<?php
require_once 'functions.php';

$theme = getTheme();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "Username and password are required.";
    } else {
        if (registerUser($username, $password)) {
            header('Location: index.php');
            exit;
        } else {
            $message = "Username already taken.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo htmlspecialchars($theme); ?>">
<head>
    <title>Register - Voting App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo htmlspecialchars($theme); ?>">

<h2>Register Account</h2>

<?php if ($message): ?>
    <p style="color: red;"><?php echo $message; ?></p>
<?php endif; ?>

<form action="register.php" method="POST">
    Username: <input type="text" name="username">
    <br><br>
    Password: <input type="password" name="password">
    <br><br>
    <button type="submit">Register</button>
</form>
<br>
<a href="index.php">Login here</a>

</body>
</html>