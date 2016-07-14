<?php

/**
 * Initialization file for xzbase64
 * 
 * @author xZero <xzero@elite7hackers.net>
 * @version 1.0.7
 */
error_reporting(true);

$program = array(
    "version" => "1.0.7",
    "SCRIPT" => preg_replace('/\.php$/', '', __FILE__)
);
$status_message_switch = true;

$HelpCMD = array(
    "-help",
    "/?",
    "/help",
    "-?"
);

// Load all core php files
require "xzbase64_functions.php";
require "xzbase64.php";


