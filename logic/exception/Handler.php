<?php

namespace NSS\Exception;

use NSS\Utils\Response;
use NSS\Utils\Status;

class Handler
{
  function __construct(private \Throwable $e)
  {
    $this->sendHTTPHeader();
    $this->respond();
  }

  static function handle()
  {
    set_exception_handler(fn(\Throwable $e) => new Handler($e));
  }

  private function getHTTPResponseCode(): int
  {
    if (isset($this->e->http_response_code)) return $this->e->http_response_code;
    return 200;
  }

  private function sendHTTPHeader()
  {
    header("Content-Type:application/json");
    http_response_code($this->getHTTPResponseCode());
  }

  private function respond()
  {
    Response::respond(Status::Error, $this->e->getMessage());
  }

}
