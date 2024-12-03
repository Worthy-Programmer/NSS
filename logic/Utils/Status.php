<?php

namespace Fahd\NSS\Utils;

enum Status: int {
  case OK = 1;
  case NotOK = 0;
  case Error = -1;
}
