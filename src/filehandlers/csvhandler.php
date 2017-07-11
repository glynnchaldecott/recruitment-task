<?php

namespace glynnchaldecott\recruitmenttask\filehandlers;

/**
 * Implements the abstracthandler to load CSV files.
**/
class csvhandler extends abstracthandler
{
    
    // Loops through the CSV using the first row as the header row.
    public function processFile($fileName)
    {
        // Checks the file supplied exists.
        if (!file_exists($fileName)) {
            throw new \InvalidArgumentException(
                "Supplied file does not exist."
            );
        }
        
        // Checks the extension is a CSV.
        parent::validateFileExtension($fileName, "csv");
        
        // Opens the file if it can.
        $file = fopen($fileName, "r");
        
        // Loops through the file storing the results.
        $rowCount = 0;
        while (($row = fgetcsv($file)) !== FALSE) {
            // If first row sets the header array and continues.
            if (!isset($header)) {
                $header = $row;
                $rowCount = count($row);
                
                continue;
            }
            
            //If there is a discrepency between the number of columns in the header or data error.
            if ($rowCount !== count($row)) {
                fclose($file);
                throw new \RuntimeException(
                    "Header and data column mismatch."
                );
            }
            
            $tempArray = array();
            for ($o = 0; $o < $rowCount; $o ++) {
                $tempArray[$header[$o]] = $row[$o];
            }
            
            parent::addResults($tempArray);
        }
        
        fclose($file);
    }
}