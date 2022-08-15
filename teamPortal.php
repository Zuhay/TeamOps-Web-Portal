<?php
require_once ("Models/TeamDataSet.php");
require_once("Models/ProjectDataset.php");
$view = new stdClass();
$view->pageTitle = "Team Portal";

$projectDataset = new ProjectDataset();

//$view->projectDataset = $projectDataset->getProject("");
session_start();
