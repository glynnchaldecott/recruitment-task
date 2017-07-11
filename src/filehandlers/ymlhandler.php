<?php

namespace glynnchaldecott\recruitmenttask\filehandlers;

/**
 * Implements the abstracthandler to load YML files.
**/
class ymlhandler extends abstracthandler
{
    
    // Loops through the YML using the first row as the header row.
    public function processFile($fileName)
    {
        // Checks the file supplied exists.
        if (!file_exists($fileName)) {
            throw new \InvalidArgumentException(
                "Supplied file does not exist."
            );
        }
        
        // Checks the extension is a YML.
        parent::validateFileExtension($fileName, "yml");
        
        $file = file_get_contents($fileName);
        
        // Read file.
        $yml = \yaml_parse($file);
        
        $flatYML = self::flatten($yml);
        
        parent::mergeResults($flatYML);
    }
    
}