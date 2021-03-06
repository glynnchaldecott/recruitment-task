<?php

namespace glynnchaldecott\recruitmenttask\filehandlers;

use PHPUnit\Framework\TestCase;

class xmlhandlerTest extends TestCase
{
    
    // Passes a valid file through the handler to ensure it functions correctly.
    public function testValidFile()
    {
        $handler = new xmlhandler();
        $handler->processFile('tests/testfiles/file.xml');
        
        $this->assertEquals(
            $handler->returnResults(),
            array(
                array("name" => "Ben", "active" => 'true', "value" => '150'),
                array("name" => "Paul", "active" => 'false', "value" => '100'),
                array("name" => "Mark", "active" => 'true', "value" => '250'),
                array("name" => "John", "active" => 'true', "value" => '500')
            )
        );
    }
    
    // Passes a non-existant file to the handler.
    public function testMissingFile()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $handler = new xmlhandler();
        $handler->processFile('missing.xml');
    }
    
    // Passes an invalid file type to the handler.
    public function testWrongFileType()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $handler = new xmlhandler();
        $handler->processFile('tests/testfiles/file.csv');
    }
    
}