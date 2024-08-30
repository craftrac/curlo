# Paracurl

Paracurl is a simple PHP wrapper for making HTTP API requests using cURL. It provides an easy-to-use interface for sending `GET`, `POST`, and `PUT` requests, with support for basic authentication and token-based authentication.

## Features

- Supports `GET`, `POST`, and `PUT` HTTP methods.
- Easily configure API endpoints and credentials via environment variables.
- Built-in support for basic authentication or token-based authentication.
- Simple and intuitive interface for making API calls.

## Installation

To install Paracurl, you can simply add it to your project using Composer:

```bash
composer require cractrac/paracurl
```

## Usage

You may use multiple API configurations. If the API requires basic authentication, you can use the following USERNAME and PASSWORD environment variables:
Otherwise use TOKEN environment variable

```php
PARACURL_<API_NAME>_BASEURL
PARACURL_<API_NAME>_USERNAME
PARACURL_<API_NAME>_PASSWORD
PARACURL_<API_NAME>_TOKEN
```

## Examples

```php
// Initialize Paracurl
$paracurl = new Paracurl('<API_NAME>', '<endpoint>');

// Send a GET request
$response = $paracurl->get();
$responseData = json_decode($response, true);

// Send a GET request with url data
$data = [
    'key' => 'value'
];
$response = $paracurl->get($data);
$responseData = json_decode($response, true);

// Send a POST request with body data
$data = [
    'key' => 'value'
];
$response = $paracurl->post($data);
$responseData = json_decode($response, true);

// Send a PUT request with body data
$data = [
    'key' => 'value'
];
$response = $paracurl->put($data);
$responseData = json_decode($response, true);
```


