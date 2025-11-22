<?php
require_once 'functions.php';

$username = getSession('username');
if (!$username) {
    header('Location: index.php');
    exit;
}

// --- FIX: Replaced ?? with isset() for old PHP versions ---
$topicID = isset($_GET['id']) ? $_GET['id'] : null;
$voteType = isset($_GET['type']) ? $_GET['type'] : null;

if ($topicID && $voteType && ($voteType === 'up' || $voteType === 'down')) {
    vote($username, $topicID, $voteType);
}

header('Location: topics.php');
exit;
?>