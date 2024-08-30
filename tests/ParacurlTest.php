<?php

use PHPUnit\Framework\TestCase;
use Craftrac\Paracurl;

class ParacurlTest extends TestCase
{
    public function testGetRequest()
    {
        readDotEnv('.env.example');

        // Instantiate the Curlo class with the mock API name and endpoint
        $curlo = new Paracurl('TESTAPI', '/posts/1');

        // Mocking cURL execution
        $response = $curlo->get();

        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Assert that the response contains the expected data
        $this->assertIsArray($responseData);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals(1, $responseData['id']);
    }
}

