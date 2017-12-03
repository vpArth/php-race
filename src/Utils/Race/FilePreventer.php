<?php

namespace Arth\Utils\Race;

class FilePreventer implements IPreventer
{
  private $fp;

  public function lock($id): bool
  {
    $fn = self::fn($id);
    if (!file_exists($fn)) {
      touch($fn);
    }
    $this->fp = fopen($fn, 'r+');

    if (!flock($this->fp, LOCK_EX)) {
      return false;
    }

    return true;
  }
  public function release()
  {
    if ($this->fp) {
      if(!flock($this->fp, LOCK_UN)) {
        throw new FailException('Unsucessful race condition release');
      }

      $this->fp = null;
    }
  }
  public static function supported(): bool
  {
    return is_writable(sys_get_temp_dir());
  }

  private static function fn($id)
  {
    return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'arth-race-' . sha1($id) . '.lock';
  }
}
