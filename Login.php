<?php

declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/games.int.php');
require_once('Interface/register_login.int.php');

    session_set_cookie_params(0, '/', 'localhost', true, true);
    session_start();

draw_header("Login");
draw_login();
draw_footer();

