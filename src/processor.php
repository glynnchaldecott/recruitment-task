<?php

namespace glynnchaldecott\recruitmenttask;

use glynnchaldecott\recruitmenttask\filehandlers;

/**
 * Processes a supplied file and stores a total in either a file or as output.
**/
final class processor
{
    // Processes the supplied file.
    public static function processFile($fileName, $output = "php://stdout")
    {
        if (!file_exists($fileName)) {
            throw new \InvalidArgumentException(
                "Supplied file doesn't exist."
            );
        }
        
        $fileNameParts = explode(".", $fileName);
        $extension = strtoupper(end($fileNameParts));
        
        // Assigns the appropriate class to the handler.
        switch ($extension) {
            case "CSV":
                $handler = new filehandlers\csvhandler();
                break;
            case "XML":
                $handler = new filehandlers\xmlhandler();
                break;
            case "YML":
                $handler = new filehandlers\ymlhandler();
                break;
            default:
                throw new \InvalidArgumentException(
                    "Invalid file type supplied."
                );
        }
        
        // Tries to retrieve answer.
        try {
            $handler->processFile($fileName);
            $results = $handler->returnResults();
            
            //print_r($results);
            
            $value = aggregators::sum(
                $results,
                "value",
                array(
                    array(
                        "FilterColumn" => "active",
                        "Filter" => "true",
                        "Operator" => "="
                    )
                )
            );
            
            $outputFile = fopen($output, "w");
            fwrite($outputFile, $value);
            fclose($outputFile);
        } catch (\Exception $e) {
            echo "There was an error while processing the file: " . $e->getMessage() . "\n";
        }
        
        
    }
    
}