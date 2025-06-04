<?php

session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();
session_destroy();

header('Location: ../mainPage.php');