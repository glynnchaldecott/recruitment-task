<?php

namespace glynnchaldecott\recruitmenttask\filehandlers;

/**
 * An abstract file handler, outlining the functionality required to be returned by the classed which extend it.
**/
abstract class abstracthandler
{
    protected $results = array();   //Allows for multiple files to be loaded before the results are returned.
    
    // Needs to be implemented by the extending class, defines the logic to standardise the results independant
    // of file type loaded.
    abstract public function processFile($fileName);
    
    // Validates that the file being loaded is of the expected type by checking the extension.
    protected function validateFileExtension($fileName, $expectedExtension)
    {
        $nameParts = explode(".", $fileName);
        
        if (strtoupper(end(($nameParts))) != strtoupper($expectedExtension))
        {
            throw new \InvalidArgumentException(
                "Supplied file is not of the expected type: " . $expectedExtension
            );
        }
    }
    
    // Combines the results from the implementing class together.
    protected function addResults($newValues)
    {
        $this->results[] = $newValues;
    }
    
    // Merges the results from an implementing class together when the function returns more that one row at a time.
    protected function mergeResults($newValues)
    {
        $this->results = array_merge($this->results, $newValues);
    }
    
    // Returns the $result variable when required.
    public function returnResults()
    {
        return $this->results;
    }
    
    // Loops through complex arrays to flatten them.
    protected function flatten($array)
    {
        $levelResults = array();
        $results = array();
        
        // Loops through level values, where an array or object flattens the next level,
        // where values applies these to the level results.
        foreach ($array as $key => $value) {
            if (is_array($value) or is_object($value)) {
                $temp = self::flatten((array)$value);
                $results = array_merge($temp, $results);
            } else {
                if (gettype($value) == 'boolean') {
                    $levelResults[$key] = (($value) ? 'true' : 'false');
                } else {
                    $levelResults[$key] = (string)$value;
                }
            }
        }
        
        // Copies higher level values onto lower levels so that the array remains 2 dimensional.
        // Will duplicate the values over multiple rows should this happen.
        if (count($levelResults) > 0 and count($results) > 0) {
            $resultsCount = count($results);
            for ($i = 0; $i < $resultsCount; $i ++) {
                foreach ($levelResults as $key => $value) {
                    $results[$i][$key] = $value;
                }
            }
        } else if (count($results) == 0 and count($levelResults) > 0) {
            $results[] = $levelResults;
        }
        
        return $results;
    }
    
}