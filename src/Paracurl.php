<?php
namespace Craftrac;

/**
 * This class is used as a wrapper for curl requests against an endpoint
 *  @param string $endpoint
 *  @param array $config
 *  @return array|string
 */
class Paracurl
{
    private $curl;
    private $username;
    private $password;
    private $endpoint;
    private $apiUrl;
    private $apiToken;


    public function __construct($apiName, $endpoint, $fileEnv=false) 
    {
        $this->curl = curl_init();
        $this->endpoint = $endpoint;

        if ($fileEnv) readDotEnv(); 

        // Read parameters from env according to the API name
        $this->baseUrl = getenv("PARACURL_{$apiName}_BASEURL");
        $this->username = getenv("PARACURL_{$apiName}_USERNAME");
        $this->password = getenv("PARACURL_{$apiName}_PASSWORD");
        $this->token = getenv("PARACURL_{$apiName}_TOKEN"); // Optional

        if (!$this->baseUrl) {
            throw new \Exception("Missing PARACURL_{$apiName}_BASEURL");
        }

        // if (!$this->token && (!$this->username || !$this->password)) {
        //     throw new \Exception("Missing PARACURL API credentials");
        // }

    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    public function get($data = false)
    {
        $url = $this->buildUrl($this->endpoint);

        if ($data) {
            $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        return $this->exec("GET", $url);
    }

    public function post($data)
    {
        $url = $this->buildUrl($this->endpoint);
        return $this->exec("POST", $url, $data);
    }

    public function put($data)
    {
        $url = $this->buildUrl($this->endpoint);
        return $this->exec("PUT", $url, $data);
    }

    public function delete()
    {
        $url = $this->buildUrl($this->endpoint); 
        return $this->exec("DELETE", $url);
    }

    public function update($data)
    {
        $url = $this->buildUrl($this->endpoint);
        return $this->exec("PUT", $url, $data);
    }

    public function exec($method, $url, $data = false)
    {
        curl_reset($this->curl);

        // Optional Authentication:
        if ($this->username && $this->password) {
            curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($this->curl, CURLOPT_USERPWD, "$this->username:$this->password");
        } elseif ($this->token) {
            curl_setopt(
                $this->curl, 
                CURLOPT_HTTPHEADER, 
                array('Authorization: Bearer ' . $this->token
            ));
            curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($this->curl, CURLOPT_USERPWD, "$this->token");
        } else {
            curl_setopt($this->curl, CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json', 
                    'Accept: application/json'
                )
            );
        }

        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 8);

        $response = curl_exec($this->curl);

        if (curl_errno($this->curl)) {
            throw new \Exception('cURL error: ' . curl_error($this->curl));
        }

        return $response;
    }

    private function buildUrl($endpoint)
    {
        return rtrim($this->baseUrl, '/') . '/' . ltrim($endpoint, '/');
    }

}
