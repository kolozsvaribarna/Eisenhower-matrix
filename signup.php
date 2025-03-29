<?php

require_once "html.php";
require_once "request.php";

htmlStart("Sign up");

displaySignUpForm();
handleRequest();

htmlEnd();