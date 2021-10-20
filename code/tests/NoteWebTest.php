<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class NoteWebTest extends WebTestCase
{
    public function testInput(): void
    {
        $client = static::createClient();
        $client->request(
            'POST', 
            '/notes',  
            array(),
            array(),
            array(
                "HTTP_HOST" => "localhost:8001",
                'CONTENT_TYPE' => 'application/json'),
            json_encode(["title"=>"WebTestCase", "text"=>"sddsddd"])
        );
        
        //$this->assertJson($client->getResponse()->getContent());
        $this->assertEquals(JsonResponse::HTTP_CREATED, $client->getResponse()->getStatusCode(), 'HTTP code is not ' . JsonResponse::HTTP_CREATED);
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');

    }

    public function getOneNote() {
        $client = static::createClient();
        $client->request(
            'GET', 
            '/notes/5', 
            array(), 
            array(), 
            array("HTTP_HOST" => "localhost:8001"));

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode(), 'HTTP code is not ' . JsonResponse::HTTP_OK);
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');
    }


    public function testGetAllNotes() {
        $client = static::createClient();
        $client->request(
            'GET', 
            '/notes', 
            array(), 
            array(), 
            array("HTTP_HOST" => "localhost:8001"));

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode(), 'HTTP code is not ' . JsonResponse::HTTP_OK);
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');
    }

    public function testNoteUpdate() {
        $client = static::createClient();
        $client->request(
            'PUT', 
            '/notes/2',  
            array(),
            array(),
            array(
                "HTTP_HOST" => "localhost:8001",
                'CONTENT_TYPE' => 'application/json'),
            json_encode(["title"=>"WebTestCase update", "text"=>"Updated text"])
        );
        
        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode(), 'HTTP code is not ' . JsonResponse::HTTP_OK);
        $this->assertTrue($client->getResponse()->headers->contains('Content-Type', 'application/json'), 'Invalid JSON response');
    }


    public function testNoteDeletion() {
        $client = static::createClient();
        $client->request(
            'DELETE', 
            '/notes/6', 
            array(), 
            array(), 
            array("HTTP_HOST" => "localhost:8001"));

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $client->getResponse()->getStatusCode(), 'HTTP code is not ' . JsonResponse::HTTP_NO_CONTENT);
    }


}
