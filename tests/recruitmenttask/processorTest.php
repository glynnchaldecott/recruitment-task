<?php

namespace glynnchaldecott\recruitmenttask;

use PHPUnit\Framework\TestCase;

/**
 * Tests the main processor class to ensure it is working.
**/
class processorTest extends TestCase
{
    
    // Tests a valid file with output specified.
    public function testValidFileOutput()
    {
        processor::processFile('tests/testfiles/file.xml','tests/testfiles/output.txt');
        
        $output = file_get_contents('tests/testfiles/output.txt');
        
        $this->assertEquals('900', $output);
    }
    
    // Tests a missing file.
    public function testMissingFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        processor::processFile('tests/testfiles/nofile.xml');
    }
    
    // Tests an invalid file.
    public function testWrongFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        processor::processFile('tests/testfiles/wrongfile.log');
    }
    
}