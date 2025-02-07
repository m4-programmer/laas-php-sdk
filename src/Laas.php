<?php

namespace Peteradeojo\LAAS;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Peteradeojo\LAAS\LaasLogDTO;

class Laas
{
  private static $instance = null;

  private function __construct()
  {
  }

  public static function getInstance()
  {
    if (!static::$instance) {
      static::$instance = new static();
    }

    return static::$instance;
  }

  public function sendLog(LaasLogDTO $log)
  {
    $response = (new Client);
    $data = [
      'level' => $log->level,
      'text' => $log->message
    ];

    try {
      $response = $response->post('https://laas-api-nest.onrender.com/logs', [
        'json' => $data,
        'headers' => [
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
          'APP_ID' => getenv('LAAS_APP_TOKEN'),
        ]
      ]);
    } catch (ClientException $e) {
      $response = $e->getResponse();
    }
    return $response;
  }
}
