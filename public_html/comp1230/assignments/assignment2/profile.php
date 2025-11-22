<?php
require_once 'functions.php';

$username = getSession('username');
if (!$username) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_theme'])) {

    // --- FIX: Replaced ?? with isset() for old PHP versions ---
    $selected_theme = isset($_POST['theme']) ? $_POST['theme'] : 'Light';

    setTheme($selected_theme);
    header('Location: profile.php');
    exit;
}

$theme = getTheme();
$total_topics = getTotalTopicsCreated($username);
$total_votes = getTotalVotesCast($username);
$history = getUserVotingHistory($username);
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo htmlspecialchars($theme); ?>">
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo htmlspecialchars($theme); ?>">

<div>
    <a href="dashboard.php">Dashboard</a> |
    <a href="topics.php">View Topics</a> |
    <a href="profile.php">My Profile</a> |
    <a href="logout.php">Logout</a>
</div>

<h2>My Profile: <?php echo htmlspecialchars($username); ?></h2>
<hr>
<h3>My Summary</h3>
<ul>
    <li>Topics Created: <?php echo $total_topics; ?></li>
    <li>Votes Cast: <?php echo $total_votes; ?></li>
</ul>

<hr>
<h3>My Voting History</h3>
<?php if (empty($history)): ?>
    <p>You have not voted yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($history as $item): ?>
            <li>
                Voted <b><?php echo htmlspecialchars($item['voteType']); ?></b>
                on "<?php echo htmlspecialchars($item['title']); ?>"
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>
<h3>Set Theme</h3>
<form action="profile.php" method="POST">
    <input type="hidden" name="set_theme" value="1">
    <select name="theme">
        <option value="Light" <?php if ($theme == 'Light') echo 'selected'; ?>>Light</option>
        <option value="Dark" <?php if ($theme == 'Dark') echo 'selected'; ?>>Dark</option>
    </select>
    <button type="submit">Save Theme</button>
</form>

</body>
</html>