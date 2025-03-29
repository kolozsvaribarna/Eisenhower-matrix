<?php

session_start();

require_once "html.php";
require_once "request.php";

htmlStart("Profile");

checkUserLogin();

displaySideBarNav();
displayProfileOptions();

handleRequest();

htmlEnd();