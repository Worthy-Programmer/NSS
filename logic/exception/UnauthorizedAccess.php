<?php

namespace NSS\Exception;

class UnauthorizedAccess extends \Exception {
  protected $message = "Access Denied";
  protected int $http_response_code = 401;
}