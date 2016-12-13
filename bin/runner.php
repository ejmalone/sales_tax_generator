<?php

require __DIR__ . '/../vendor/autoload.php';

use models\Product;
use models\OrderItem;
use models\Order;
use models\Invoice;


try {

    $filename = getFilename($argv);
    $filepath = getFilePath($filename);
    $json     = getFileContents($filepath);

    $invoice = new Invoice();
    
    // var_dump($json);exit();

    $order = Order::buildFromJsonArray($json);

    $invoice->setOrder($order);

    echo "----------------";
    echo $invoice->pp();
    echo "----------------";
    
    exit(0);
}
catch (\Exception $e) {
    
    echo "\n";
    echo "Failure to run. Did you execute via \"composer run-script runner [example filename].json\"?\n";
    echo "Error message: {$e->getMessage()}\n";
    echo "\n\n";

    exit(1);
}


/**
 * Attempt to get the filename passed from the system's $argv global parameter
 *
 * @param array $argv
 *
 * @return string the passed filename
 *
 * @throws Exception if the filename wasn't found in the array
 */
function getFilename($argv) {
    
    if (empty($argv[1]))
        throw new \Exception("filename missing from command line argument list");

    return $argv[1];
}

/**
 * Attempt to build and validate the file path for the filename used
 * in this script
 *
 * @param string $filename
 *
 * @return string the full system file path for the json file to parse
 *
 * @throws Exception if the file path is invalid
 */
function getFilePath($filename) {

    $filepath = __DIR__ . '/../examples/' . $filename;

    if (!is_file($filepath))
        throw new \Exception(sprintf("file missing at %s", $filepath));

    if (!is_readable($filepath))
        throw new \Exception(sprintf("file is not readable at %s", $filepath));

    return realpath($filepath);
}

/**
 * Attempt to read and parse the json file contents necessary for this script
 *
 * @param string $filepath the full file path to read the file from
 *
 * @return string the parsed json file
 *
 * @throws Exception if the file was invalid json
 */
function getFileContents($filepath) {
    
    $contents = file_get_contents($filepath);

    if (empty($contents))
        throw new \Exception(sprintf("file contents were empty at %s", $filepath));

    $json = json_decode($contents, true);
    
    $lastErrorMsg = json_last_error_msg();
    $lastError    = json_last_error();

    if ($lastError !== JSON_ERROR_NONE)
        throw new \Exception("json failed to parse with error %i, message \"%s\"", $lastError, $lastErrorMsg);

    return $json;
}
