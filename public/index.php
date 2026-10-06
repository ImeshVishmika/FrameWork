<?php
define("BASE", dirname(__DIR__));

require_once BASE . '/app/core/Router.php';
require_once BASE . '/app/mapping/Mapping.php';

$reqUri = $_SERVER["REQUEST_URI"];

Mapping::config();
Router::reRoute();
