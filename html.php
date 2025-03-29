<?php

function htmlStart($title = "Eisenhower Matrix") {
    echo <<<HTML
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
            <meta http-equiv='X-UA-Compatible' content='ie=edge'>
            <title>$title</title>
            <link rel='stylesheet' href='style.css'>
          </head>
        <body>
        <script src='navbar.js'></script>
    HTML;
}

function htmlEnd() {
    echo "</body> </html>";
}

function displayLoginForm()
{
    echo <<<HTML
    <div class='basic-form'><h2>Login</h2>
    <form action='login.php' method='post'>
        <section>
            <label for='username'>Username</label><br>
            <input id="username" name='username' type='text'><br>
            <label for='pwd'>Password</label><br>
            <input name='pwd' id="pwd" type='password'>
            
            <input type="checkbox" name="pwdToggle" id="pwdToggle" class="hidden-checkbox" onclick="togglePassword()">
            <label for="pwdToggle" class="eye-label"></label>
        </section>
        <section class='submit-section'>
            <input type='submit' name='submit-login' value='Login'>
            <p class="primary-color">Don't have an account yet? Sign up below</p>
            <input type='submit' name='signup-redirect' value='Sign up'>
        </section>
    </form></div>
HTML;
}

function displaySignUpForm() {
    echo <<<HTML
    <div class='basic-form'>
    <h2>Sign up</h2>
    <form action='signup.php' method='post'>
        <section>
            <label for='username'>Username</label><br>
            <input id="username" name='username' type='text'><br>
            <label for='pwd'>Password</label><br>
            <input name='pwd' id="pwd" type='password'><br>
            <label for='pwd2'>Confirm password</label><br>
            <input name='pwd2' id="pwd2" type='password'>
            
            <input type="checkbox" name="pwdToggle" id="pwdToggle" class="hidden-checkbox" onclick="toggleAllPasswords()">
            <label for="pwdToggle" class="eye-label"></label>
        </section>
        <section class='submit-section'>
            <input type='submit' name='submit-signup' value='Sign up'>
            <input type='submit' name='login-redirect' value='Back to login'>
        </section>
    </form></div>
HTML;
}

function displayUserLoggedIn() {
    if (!isset($_SESSION["loggedIn"])) $_SESSION["loggedIn"] = false;
    if (!$_SESSION["loggedIn"]) {
        displayLoginForm();
    }
    else {
        header("Location: index.php");
    }
}

function displayLogOutButton()
{
    echo <<<HTML
        <form action='login.php' method='post'>
            <input type='submit' name='logout-form' value='Log out'>
        </form>
HTML;
}

function displaySideBarNav() {
    $username = $_SESSION["username"];
    echo <<<HTML
    <div id="mySidepanel" class="sidepanel">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a class="disabled" href="">user <span class="primary-color">$username</span></a>
        <a href="index.php" target="_self">main page</a>
        <a href="about.php" target="_self">about</a>
        <a href="profile.php">profile</a>
        <a>
        <form action='login.php' method='post'><input class="sidebar-logout" type='submit' name='logout-form' value='Log out'></form>
        </a>
    </div>
    <button class="openbtn" onclick="openNav()">&#9776;</button>
HTML;
}

function displayProfileOptions() {
    $username = $_SESSION["username"];
    echo <<<HTML
    <form class="basic-form" action="profile.php" method="post">
    <h2>Profile page</h2>
        <section>
           <p>Logged in as <span class="primary-color">$username</span></p>
           <p>Change password</p>
           <label for="pwd">New password</label><br>
           <input type="password" id="pwd" name="pwd" value=""><br>
           <label for="pwd2">Password again</label><br>
           <input type="password" id="pwd2" name="pwd2" value="">
           
           <input type="checkbox" name="pwdToggle" id="pwdToggle" class="hidden-checkbox" onclick="toggleAllPasswords()">
            <label for="pwdToggle" class="eye-label"></label>
        </section>
        <section class="submit-section">
            <input type="submit" name="submit-change-pwd" value="Change password">
        </section>
    </form>
HTML;
}

function checkUserLogin() {
    if (!isset($_SESSION["loggedIn"])) $_SESSION["loggedIn"] = false;
    if (!$_SESSION["loggedIn"]) {
        header("Location: login.php");
    }
}