<?php

namespace Arth\Utils\Race;

class Preventer
{
  protected static $known = [
    SemPreventer::class,
    FilePreventer::class,
  ];
  private static $availableClass;
  public static function get(): IPreventer {
    if (self::$availableClass) {
      return new self::$availableClass();
    }
    /** @var IPreventer $class */
    foreach (self::$known as $class) {
      if ($class::supported()) {
        self::$availableClass = $class;
        return new $class();
      }
    }
    throw new FailException("No available race prevention methods");
  }
}
