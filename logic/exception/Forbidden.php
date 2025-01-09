<?php

namespace NSS\Exception;

class Forbidden extends \Exception
{
  protected $message = "You do not have admin access";
  public int $http_response_code = 403;
}
