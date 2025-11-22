<?php
require_once 'functions.php';

$username = getSession('username');
if (!$username) {
    header('Location: index.php');
    exit;
}

$theme = getTheme();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_topic'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (empty($title) || empty($description)) {
        $message = "Title and description are required.";
    } else {
        if (createTopic($username, $title, $description)) {
            header('Location: topics.php');
            exit;
        } else {
            $message = "Error creating topic.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo htmlspecialchars($theme); ?>">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo htmlspecialchars($theme); ?>">

<div>
    <a href="dashboard.php">Dashboard</a> |
    <a href="topics.php">View Topics</a> |
    <a href="profile.php">My Profile</a> |
    <a href="logout.php">Logout</a>
</div>

<h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2>

<?php if ($message): ?>
    <p style="color: red;"><?php echo $message; ?></p>
<?php endif; ?>

<hr>
<h3>Create a New Topic</h3>
<form action="dashboard.php" method="POST">
    <input type="hidden" name="create_topic" value="1">
    Title: <br>
    <input type="text" name="title" size="50">
    <br><br>
    Description: <br>
    <textarea name="description" rows="4" cols="50"></textarea>
    <br><br>
    <button type="submit">Create Topic</button>
</form>

</body>
</html>