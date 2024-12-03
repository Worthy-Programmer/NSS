<?php

namespace Fahd\NSS\Utils;


class Response {
    public function __construct(public Status $status, public mixed $response){return $this;}

    public function send()  {
      die($this->getRes());
    }

    public function getRes() {
      return json_encode(['status' => $this->status, "res" =>$this->response]);
    }

    static public function respond(Status $status, mixed $response) {
      $res = new self($status, $response);
      $res->send();
    }
}

