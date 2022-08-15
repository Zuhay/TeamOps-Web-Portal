<?php
$view = new stdClass();
$view->pageTitle = 'Home';

session_start();
require_once ('Views/index.phtml');