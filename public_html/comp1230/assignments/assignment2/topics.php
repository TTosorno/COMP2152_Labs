<?php
require_once 'functions.php';

$username = getSession('username');
if (!$username) {
    header('Location: index.php');
    exit;
}

$theme = getTheme();
$all_topics = getTopics();
?>
<!DOCTYPE html>
<html lang="en" class="<?php echo htmlspecialchars($theme); ?>">
<head>
    <title>All Topics</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?php echo htmlspecialchars($theme); ?>">

<div>
    <a href="dashboard.php">Dashboard</a> |
    <a href="topics.php">View Topics</a> |
    <a href="profile.php">My Profile</a> |
    <a href="logout.php">Logout</a>
</div>

<h2>All Voting Topics</h2>

<?php if (empty($all_topics)): ?>
    <p>No topics created yet.</p>
<?php else: ?>
    <?php foreach ($all_topics as $topic): ?>
        <div style="border: 1px solid #999; padding: 10px; margin-bottom: 15px;">
            <h3><?php echo htmlspecialchars($topic['title']); ?></h3>
            <p><?php echo htmlspecialchars($topic['description']); ?></p>
            <i>By: <?php echo htmlspecialchars($topic['creator']); ?></i>

            <?php $votes = getVoteResults($topic['topicID']); ?>
            <p>
                <b>Votes:</b>
                <?php echo $votes['up']; ?> Up,
                <?php echo $votes['down']; ?> Down
            </p>

            <?php if (hasVoted($username, $topic['topicID'])): ?>
                <b>(You have already voted)</b>
            <?php else: ?>
                <a href="vote.php?id=<?php echo $topic['topicID']; ?>&type=up">Upvote</a> |
                <a href="vote.php?id=<?php echo $topic['topicID']; ?>&type=down">Downvote</a>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>