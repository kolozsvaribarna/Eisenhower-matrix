<?php

require_once "html.php";
require_once "matrix-html.php";

session_start();
htmlStart();

checkUserLogin();

displaySideBarNav();

displayMatrix();

boxScript();

htmlEnd();