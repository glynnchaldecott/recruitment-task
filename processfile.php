<?php
/**
 * Acts as a command line wrapper to run the processor class.
**/

require_once 'vendor/autoload.php';

use glynnchaldecott\recruitmenttask\processor;

//Converts the standard argv into key pair array for easier use.
$args = array();
for ($i = 1; $i < count($argv); $i++) {
    $key = substr($argv[$i], 0, strpos($argv[$i], "="));
    $value = substr($argv[$i], strpos($argv[$i], "=") + 1, strlen($argv[$i]) - strpos($argv[$i], "="));
    $args[$key] = $value;
}

if (!isset($args["--input"])) {
    throw new InvalidArgumentException("Missing --input argument. Please supply an input file.");
}

if (!isset($args["--output"])) {
    processor::processFile($args["--input"]);
} else {
    processor::processFile($args["--input"],$args["--output"]);
}