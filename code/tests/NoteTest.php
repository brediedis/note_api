<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NoteTest extends ApiTestCase
{
    // public function testInput(): void
    // {
    //     $client = static::createClient();
    //     $client->request(
    //         'POST', 
    //         '/notes',  
    //         array(),
    //         array(),
    //         array(
    //             "HTTP_HOST" => "192.168.2.196:8001",
    //             'CONTENT_TYPE' => 'application/json'),
    //         '[{"title":"Api Test case","text":"text1"},{"title":"Api test case 2","text":"text2"}]'
    //     );
    //     $response = $client->getResponse();
    //     $this->assertSame(201, $response->getStatusCode());
    // }

    // public function testGetAllNotes() {
    //     $client = static::createClient();
    //     $client->enableProfiler();
    //     $crawler = $client->request(
    //         'GET', 
    //         '/', 
    //         array(), 
    //         array(), 
    //         array("HTTP_HOST" => "192.168.2.196:8001/index.php"));
    //         $this->assertResponseIsSuccessful();
    // }
}
