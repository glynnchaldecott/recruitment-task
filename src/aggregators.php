<?php

namespace glynnchaldecott\recruitmenttask;

/**
 * This is a class for handling array aggregation, each function would be static,
 * and this could be extended to handle more than purely summation.
**/
final class aggregators
{
    
    //Tests that the filter array contains all the necessary columns to perform the aggregation.
    private static function testFilters($filters)
    {
        foreach ($filters as $filter) {
            if (
                !isset($filter["FilterColumn"]) or
                !isset($filter["Filter"]) or
                !isset($filter["Operator"])
            ) {
                throw new \InvalidArgumentException(
                    "Filters supplied are not valid,"
                    . " and are missing one of the required values."
                );
            }
        }
    }
    
    // Static function to sum specified column from the supplied data array, with the optional to filters.
    public static function sum($data, $aggColumn, $filters = array())
    {
        self::testFilters($filters);   //Tests to ensure supplied filters are valid.
        
        $finalValue = 0;
        //Loops through array to sum specified column.
        foreach ($data as $row) {
            //Checks array is 2 dimensional.
            if (!is_array($row)) {
                throw new \InvalidArgumentException(
                    "Data array supplied not valid, needs to be 2 dimensional."
                );
            }
            
            //Tests specified aggregator column exists.
            if (!isset($row[$aggColumn])) {
                throw new \InvalidArgumentException(
                    "Missing aggColumn in data array."
                );
            }
            
            //Tests specified aggregator column contains a numeric value.
            if (!is_numeric($row[$aggColumn])) {
                throw new \InvalidArgumentException(
                    "aggColumn contains non-numeric values."
                );
            }
            
            //Loops through supplied filters to check if the row is a match.
            $match = true;
            foreach ($filters as $filter) {
                if (!isset($row[$filter["FilterColumn"]])) {
                    throw new \InvalidArgumentException(
                        "Data array supplied not valid, missing column specified in filter."
                    );
                }
                
                switch ($filter["Operator"]) {
                    case "=":
                        $match = (strtoupper($row[$filter["FilterColumn"]]) == strtoupper($filter["Filter"]));
                        break;
                    case ">=":
                        $match = ($row[$filter["FilterColumn"]] >= $filter["Filter"]);
                        break;
                    case "<=":
                        $match = ($row[$filter["FilterColumn"]] <= $filter["Filter"]);
                        break;
                    case "<>":
                    case "!==":
                        $match = ($row[$filter["FilterColumn"]] !== $filter["Filter"]);
                        break;
                    default:
                        throw new \InvalidArgumentException(
                            "Unknown operator supplied."
                        );
                }
                
                //If any of the filters don't match there is no need to loop further.
                if (!$match) {
                    break;
                }
            }
            
            //Adds the figures up.
            if ($match) {
                $finalValue += $row[$aggColumn];
            }
        }
        
        return $finalValue;
    }
    
}