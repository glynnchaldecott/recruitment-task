<?php

namespace glynnchaldecott\recruitmenttask\filehandlers;

use PHPUnit\Framework\TestCase;

/**
 * Tests the csvhandler class to ensure it is functioning as anticipated.
**/
class csvhandlerTest extends TestCase
{
    
    // Passes a valid file through the handler to ensure it functions correctly.
    public function testValidFile()
    {
        $handler = new csvhandler();
        $handler->processFile('tests/testfiles/file.csv');
        
        $this->assertEquals(
            $handler->returnResults(),
            array(
                array("name" => "John", "active" => 'true', "value" => '500'),
                array("name" => "Mark", "active" => 'true', "value" => '250'),
                array("name" => "Paul", "active" => 'false', "value" => '100'),
                array("name" => "Ben", "active" => 'true', "value" => '150')
            )
        );
    }
    
    // Passes a non-existant file to the handler.
    public function testMissingFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $handler = new csvhandler();
        $handler->processFile('missing.csv');
    }
    
    // Passes an invalid file type to the handler.
    public function testWrongFileType()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $handler = new csvhandler();
        $handler->processFile('tests/testfiles/file.xml');
    }
    
    // Passes an irregular file to the handler. This is where the data columns don't match the header.
    public function testIrregularFile()
    {
        $this->expectException(\RuntimeException::class);
        
        $handler = new csvhandler();
        $handler->processFile('tests/testfiles/error.csv');
    }
    
}