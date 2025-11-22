<?php
require_once 'functions.php';

$username = getSession('username');

if ($username) {
    header('Location: dashboard.php');
    exit;
}

$theme = getTheme();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "Please enter both username and password.";
    } else {
        if (authenticateUser($username, $password)) {
            setSession('username', $username);
            header('Location: dashboard.php');
            exit;
        } else {
            $message = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo htmlspecialchars($theme); ?>">
<head>
    <title>Login - Voting App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo htmlspecialchars($theme); ?>">

<h2>Voting App Login</h2>

<?php if ($message): ?>
    <p style="color: red;"><?php echo $message; ?></p>
<?php endif; ?>

<form action="index.php" method="POST">
    Username: <input type="text" name="username">
    <br><br>
    Password: <input type="password" name="password">
    <br><br>
    <button type="submit">Login</button>
</form>
<br>
<a href="register.php">Register here</a>

<?php
// show_source(__FILE__);
?>
</body>
</html>
