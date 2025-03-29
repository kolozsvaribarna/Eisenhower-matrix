<?php

require_once "html.php";
require_once "request.php";

if(!isset($_SESSION["loggedIn"])) $_SESSION["loggedIn"] = false;
session_start();

htmlStart("Login");

displayUserLoggedIn();

handleRequest();

htmlEnd();