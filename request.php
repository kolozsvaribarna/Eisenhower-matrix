<?php

require_once "db.php";

function handleRequest() {
    if (isset($_POST["signup-redirect"])) {
        Header("Location: signup.php");
    }

    if (isset($_POST["logout-form"])) {
        $_SESSION["loggedIn"] = false;
        $_SESSION["username"] = "";
        $_SESSION["userID"] = "";
        header("Location: login.php");
    }

    if (isset($_POST["submit-login"]) && $_SESSION["loggedIn"] == false) {
        $username = $_POST["username"];
        $password = $_POST["pwd"];

        if ($username != "" && $password != "") {
            if (userExists($username)) {
                $pwHash = getHashForUsername($username);
                if (password_verify($password, $pwHash)) {
                    $_SESSION["username"] = $username;
                    $_SESSION["loggedIn"] = true;
                    $_SESSION["userID"] = getUserID($username);

                    header("Location: login.php");
                } else {
                    echo "<div class='msg msg-error'>Incorrect password!</div>";
                }
            } else {
                echo "<div class='msg msg-error'>This username is already taken!</div>";
            }
        } else {
            echo "<div class='msg msg-error'>Please fill out all fields!</div>";
        }
    }

    if (isset($_POST["submit-signup"])) {
        $username = $_POST["username"];
        $password = $_POST["pwd"];
        $confPassword = $_POST["pwd2"];

        if ($password != $confPassword) {
            echo "<div class='msg msg-error'>Passwords don't match!</div>";
            die;
        }

        if ($username != "" && $password != "" && $confPassword != "") {

            $hash_pw = password_hash($password, PASSWORD_DEFAULT);

            $userExists = userExists($username);

            if (!$userExists)
            {
                addUser($username, $hash_pw);
                Header("Location: login.php");
            }
            else echo "<div class='msg msg-error'>This username is already taken!</div>";

        }
        else {
            echo "<div class='msg msg-error'>Please fill out all fields!</div>";
        }
    }

    if (isset($_POST["submit-change-pwd"])) {
        $pw = $_POST["pwd"];
        $pw2 = $_POST["pwd2"];

        if ($pw == "" || $pw2 == "") {
            echo "<div class='msg msg-error'>Please fill out all fields!</div>";
            die;
        }

        if ($pw != $pw2) {
            echo "<div class='msg msg-error'>Passwords don't match!</div>";
            die;
        }

        $hash = password_hash($pw, PASSWORD_DEFAULT);
        $res = changeUserPassword($hash);
        if ($res) {
            echo "<div class='msg msg-success'>Your password has been changed!</div>";
        }
    }

    if (isset($_POST["login-redirect"])) {
        Header("Location: login.php");
    }
}