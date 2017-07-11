<?php
namespace glynnchaldecott\recruitmenttask;

use PHPUnit\Framework\TestCase;

/**
 *
 * Tests the aggregator class, which holds a static function for aggregating arrays
 * with a where clause.
 *
**/
final class aggregatorsTest extends TestCase
{

    /**
     * Tests a valid call to the sum function.
    **/
    public function testValidArray()
    {
        $this->assertEquals(
            aggregators::sum(
                array(
                    array("Filter" => 1, "Amount" => 123),
                    array("Filter" => 2, "Amount" => 100),
                    array("Filter" => 6, "Amount" => 99),
                    array("Filter" => 1, "Amount" => 7)
                ),
                "Amount",
                array(
                    array(
                        "FilterColumn" => "Filter",
                        "Filter" => 1,
                        "Operator" => "="
                    )
                )
            ),
            130
        );
    }
    
    /**
     * Tests sending a 1D array to the Sum function.
    **/
    public function testInvalid1DArray()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        aggregators::sum(
            array(1,2,3),
            "Amount"
        );
    }
    
    /**
     * Tests sending a filter for a column that doesn't exist in the supplied array.
    **/
    public function testInvalidFilter()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        aggregators::sum(
            array(
                array("Filter" => 1, "Amount" => 123),
                array("Filter" => 2, "Amount" => 100),
                array("Filter" => 6, "Amount" => 99),
                array("Filter" => 1, "Amount" => 7)
            ),
            "Amount",
            array(
                array(
                    "FilterColumn" => "NoColumn",
                    "Filter" => 1,
                    "Operator" => "="
                )
            )
        );
    }
    
    /**
     * Tests sending a filter for an operator that can't be handled.
    **/
    public function testInvalidOperator()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        aggregators::sum(
            array(
                array("Filter" => 1, "Amount" => 123),
                array("Filter" => 2, "Amount" => 100),
                array("Filter" => 6, "Amount" => 99),
                array("Filter" => 1, "Amount" => 7)
            ),
            "Amount",
            array(
                array(
                    "FilterColumn" => "NoColumn",
                    "Filter" => 1,
                    "Operator" => "#"
                )
            )
        );
    }
    
    /**
     * Tests sending a filter for a aggregator column that doesn't exist.
    **/
    public function testInvalidAggColumn()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        aggregators::sum(
            array(
                array("Filter" => 1, "Amount" => 123),
                array("Filter" => 2, "Amount" => 100),
                array("Filter" => 6, "Amount" => 99),
                array("Filter" => 1, "Amount" => 7)
            ),
            "NoColumn"
        );
    }
    
    /**
     * Tests sending an array with a character in the aggregated column.
    **/
    public function testCharacterAmounts()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        aggregators::sum(
            array(
                array("Filter" => 1, "Amount" => "One hundred"),
                array("Filter" => 2, "Amount" => 100),
                array("Filter" => 6, "Amount" => 99),
                array("Filter" => 1, "Amount" => 7)
            ),
            "Amount"
        );
    }
    
}