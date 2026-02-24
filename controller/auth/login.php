<?php

use Core\Database;

$config = require base_path('config/config.php');
$db = new Database($config['database']);

view_path('auth', 'index');