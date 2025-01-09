<?php
namespace NSS\Utils;

class Helper {
  public static function isAllKeysInArray($needle, $haystack) {
    foreach ($needle as $item) {
      if (!isset($haystack[$item])) {
        return false;
      }
    }
    return true;
  }
}