<?php

session_start();

$conf = include 'conf.php';

define("SERVER", $conf["DB_HOST"]);
define("USER", $conf["DB_USER"]);
define("PASSWORD", $conf["DB_PASS"]);
define("DATABASE", $conf["DB_NAME"]);

function userExists($username) {
    $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    $prep = $mysqli->prepare("SELECT userID FROM users WHERE username = ?");
    $prep->bind_param("s", $username);
    $prep->execute();
    $prep->store_result();
    $mysqli->close();

    return $prep->num_rows > 0;
}
function addUser($username, $hashed_pw) {
    if (userExists($username)) return false;

    $mysqli = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
    $prep = $mysqli->prepare("INSERT INTO `users` (`username`, `pw_hash`) VALUES (?, ?)");
    $prep->bind_param("ss", $username, $hashed_pw);
    $res = $prep->execute();
    $mysqli->close();
    return $res;
}

function getHashForUsername($username) {
    if (!userExists($username)) return null;

    $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    $pw = $mysqli->prepare("SELECT pw_hash FROM users WHERE username = ?");
    $pw->bind_param("s", $username);
    $pw->execute();
    $pw->bind_result($pw_hash);
    $pw->fetch();
    $pw->close();
    $mysqli->close();
    return $pw_hash ?? null;
}

function getUserID($username_) {
    $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    $res = $mysqli->prepare("SELECT userID FROM users WHERE username = ?");
    $res->bind_param("s", $username_);
    $res->execute();
    $res->bind_result($username);
    $res->fetch();
    $res->close();
    $mysqli->close();
    return $username;
}

function changeUserPassword($pw) {
    $userID = $_SESSION['userID'];
    $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);
    $prep = $mysqli->prepare("UPDATE users SET pw_hash = ? WHERE userID = ?");
    $prep->bind_param("ss", $pw, $userID);
    $res = $prep->execute();
    $mysqli->close();
    return $res;
}

/* HANDLING POST */

$conn = new mysqli(SERVER, USER, PASSWORD, DATABASE);

// Read JSON data -> separate file?
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['action'])) {
    $action = $data['action'];

    if (function_exists($action)) {
        $action($conn, $data);
    } else {
        echo "Invalid action!";
    }
} else {
    echo "No action specified!";
}

function addContent($conn, $data) {
    if (!isset($data['box_id']) || !isset($data['content']) || !isset($_SESSION['userID'])) {
        echo "Missing required fields!";
        return;
    }

    $content = $conn->real_escape_string($data['content']);
    $box_id = $conn->real_escape_string($data['box_id']);
    $userID = $_SESSION['userID'];

    $sql = "INSERT INTO data (userID, box_id, content) VALUES ('$userID', '$box_id', '$content')";

    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "Error inserting: " . $conn->error;
    }
}

function deleteContent($conn, $data) {
    if (!isset($data['box_id']) || !isset($data['content']) || !isset($_SESSION['userID'])) {
        echo "Missing required fields!";
        return;
    }

    $content = $conn->real_escape_string($data['content']);
    $box_id = $conn->real_escape_string($data['box_id']);
    $userID = $_SESSION['userID'];

    $sql = "DELETE FROM `data` WHERE userID = '$userID' AND box_id = '$box_id' AND content = '$content';";

    if ($conn->query($sql) === TRUE) {
        echo "Data deleted successfully!";
    } else {
        echo "Error delete: " . $conn->error;
    }
}



$conn->close();