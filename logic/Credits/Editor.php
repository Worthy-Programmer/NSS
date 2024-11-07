<?php

namespace Fahd\NSS\Credits;

use Fahd\NSS\DB as DB;
use Fahd\NSS\Response;
use Fahd\NSS\Status;

class Editor
{

  const USER_TABLE_NAME = "user";
  readonly array $result;

  private DB $db;
  public function __construct(private Selector $selector) {}

  public function edit() {

  }
}
