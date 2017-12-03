<?php

namespace Arth\Utils\Race;

interface IPreventer
{
  public function lock($id): bool;
  public function release();
  public static function supported(): bool;
}
