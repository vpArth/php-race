<?php

namespace Arth\Utils\Race;

class SemPreventer implements IPreventer
{
  private $sem;

  public function lock($id): bool
  {
    $this->sem = sem_get(crc32($id));
    if (!$this->sem || !sem_acquire($this->sem)) {
      return false;
    }
    return true;
  }
  public function release()
  {
    if ($this->sem) {
      sem_release($this->sem);
      $this->sem = null;
    }
  }
  public static function supported(): bool
  {
    return function_exists('sem_get');
  }
}
