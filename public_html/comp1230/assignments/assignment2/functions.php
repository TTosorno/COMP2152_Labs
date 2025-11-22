<?php

function getID()
{
    $file_name = 'ids';
    if (!file_exists($file_name)) {
        touch($file_name);
        $handle = fopen($file_name, 'r+');
        $id = 0;
    } else {
        $handle = fopen($file_name, 'r+');
        $current_id_content = fread($handle, filesize($file_name));

        if (empty($current_id_content)) {
            $id = 0;
        } else {
            $id = (int)$current_id_content;
        }
        rewind($handle);
        ftruncate($handle, 0);
    }

    fwrite($handle, ++$id);
    fclose($handle);
    return $id;
}

function registerUser($username, $password) {
    $filename = 'users.txt';
    if (!file_exists($filename)) {
        file_put_contents($filename, '');
    }
    $users = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($users as $user) {
        $parts = explode(':', $user, 2);
        $existingUser = $parts[0];
        if (trim($existingUser) === trim($username)) {
            return false;
        }
    }
    $newUser = trim($username) . ':' . trim($password) . PHP_EOL;
    file_put_contents($filename, $newUser, FILE_APPEND);
    return true;
}

function authenticateUser($username, $password) {
    $filename = 'users.txt';
    if (!file_exists($filename)) return false;

    $users = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($users as $user) {
        $parts = explode(':', $user, 2);
        if (count($parts) < 2) continue;

        list($storedUser, $storedPass) = $parts;
        if (trim($storedUser) === trim($username) && trim($storedPass) === trim($password)) {
            return true;
        }
    }
    return false;
}

function createTopic($username, $title, $description) {
    $filename = 'topics.txt';
    $topicID = getID();

    $clean_title = str_replace('|', '', $title);
    $clean_desc = str_replace('|', '', $description);

    $newTopic = "{$topicID}|{$username}|{$clean_title}|{$clean_desc}" . PHP_EOL;
    file_put_contents($filename, $newTopic, FILE_APPEND);
    return true;
}

function getTopics() {
    $filename = 'topics.txt';
    $topics = [];

    if (!file_exists($filename)) return $topics;

    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $parts = explode('|', $line, 4);
        if (count($parts) === 4) {
            list($id, $creator, $title, $desc) = $parts;
            $topics[] = [
                'topicID' => $id,
                'creator' => $creator,
                'title' => $title,
                'description' => $desc
            ];
        }
    }
    return $topics;
}

function vote($username, $topicID, $voteType) {
    if (hasVoted($username, $topicID)) return false;
    $filename = 'votes.txt';

    $newVote = "{$username} {$topicID} {$voteType}" . PHP_EOL;

    file_put_contents($filename, $newVote, FILE_APPEND);
    return true;
}

function hasVoted($username, $topicID) {
    $filename = 'votes.txt';
    if (!file_exists($filename)) return false;

    $votes = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($votes as $vote) {
        $parts = explode(' ', $vote);
        if (count($parts) < 3) continue;

        list($voter, $tID, $type) = $parts;
        if ($voter === $username && $tID == $topicID) {
            return true;
        }
    }
    return false;
}

function getVoteResults($topicID) {
    $filename = 'votes.txt';
    $results = ['up' => 0, 'down' => 0];

    if (!file_exists($filename)) return $results;

    $votes = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($votes as $vote) {
        $parts = explode(' ', $vote);
        if (count($parts) < 3) continue;

        list($voter, $tID, $type) = $parts;
        if ($tID == $topicID) {
            if ($type === 'up') $results['up']++;
            elseif ($type === 'down') $results['down']++;
        }
    }
    return $results;
}

function getUserVotingHistory($username) {
    $filenameVotes = 'votes.txt';
    $history = [];
    if (!file_exists($filenameVotes)) return $history;

    $votes = file($filenameVotes, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $topics = getTopics();

    $topic_map = [];
    foreach ($topics as $topic) {
        $topic_map[$topic['topicID']] = $topic['title'];
    }

    foreach ($votes as $vote) {
        $parts = explode(' ', $vote);
        if (count($parts) < 3) continue;

        list($voter, $topicID, $voteType) = $parts;
        if ($voter === $username) {
            $history[] = [
                'topicID' => $topicID,
                'title' => isset($topic_map[$topicID]) ? $topic_map[$topicID] : 'Unknown Topic',
                'voteType' => $voteType
            ];
        }
    }
    return $history;
}

function getTotalTopicsCreated($username) {
    $topics = getTopics();
    $count = 0;
    foreach ($topics as $topic) {
        if ($topic['creator'] === $username) $count++;
    }
    return $count;
}

function getTotalVotesCast($username) {
    $filename = 'votes.txt';
    if (!file_exists($filename)) return 0;

    $votes = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $count = 0;
    foreach ($votes as $vote) {
        $parts = explode(' ', $vote);
        if (count($parts) < 3) continue;

        list($voter, $topicID, $type) = $parts;
        if ($voter === $username) $count++;
    }
    return $count;
}

function setSession($key, $value) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION[$key] = $value;
    return true;
}

// --- START FIX ---
function getSession($key) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Replaces: return $_SESSION[$key] ?? null;
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
}

function setCookie($key, $value) {
    if (php_sapi_name() == 'cli') {
        $_COOKIE[$key] = $value;
    } else {
        setcookie($key, $value, time() + (86400 * 30), "/");
    }
    return true;
}

function getCookie($key) {
    // Replaces: return $_COOKIE[$key] ?? null;
    return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
}

function setTheme($theme) {
    return setCookie('theme_preference', $theme);
}

function getTheme() {
    // Replaces: return getCookie('theme_preference') ?? 'Light';
    $theme = getCookie('theme_preference');
    return isset($theme) ? $theme : 'Light';
}
// --- END FIX ---

?>