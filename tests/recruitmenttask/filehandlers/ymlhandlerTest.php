<?php

namespace glynnchaldecott\recruitmenttask\filehandlers;

use PHPUnit\Framework\TestCase;

class ymlhandlerTest extends TestCase
{
    
    // Passes a valid file through the handler to ensure it functions correctly.
    public function testValidFile()
    {
        $handler = new ymlhandler();
        $handler->processFile('tests/testfiles/file.yml');
        
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
        
        $handler = new ymlhandler();
        $handler->processFile('missing.yml');
    }
    
    // Passes an invalid file type to the handler.
    public function testWrongFileType()
    {
        $this->expectException(\InvalidArgumentException::class);
        
        $handler = new ymlhandler();
        $handler->processFile('tests/testfiles/file.csv');
    }
    
}