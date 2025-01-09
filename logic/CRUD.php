<?php

namespace NSS;

interface CRUD {
  public function create();
  public function update();
  public function delete();
  public function read();
}