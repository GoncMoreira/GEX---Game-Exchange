<?php

declare(strict_types=1);

require_once('Database/connect.db.php');
require_once('Database/games.db.php');
require_once('Interface/generic.int.php');
require_once('Interface/sell_item.int.php');
session_set_cookie_params(0, '/', 'localhost', true, true);
session_start();

draw_header("Purchase");
draw_buy_items();
draw_footer();