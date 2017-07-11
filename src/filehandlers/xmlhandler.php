<?php

namespace glynnchaldecott\recruitmenttask\filehandlers;

/**
 * Implements the abstracthandler to load XML files.
**/
class xmlhandler extends abstracthandler
{
    
    // Loops through the XML using the first row as the header row.
    public function processFile($fileName)
    {
        // Checks the file supplied exists.
        if (!file_exists($fileName)) {
            throw new \InvalidArgumentException(
                "Supplied file does not exist."
            );
        }
        
        // Checks the extension is a xml.
        parent::validateFileExtension($fileName, "xml");
        
        $file = file_get_contents($fileName);
        
        // Read file.
        $xml = ((array) new \SimpleXMLElement($file));
        
        $flatXML = parent::flatten($xml);
        
        parent::mergeResults($flatXML);
    }
    
}