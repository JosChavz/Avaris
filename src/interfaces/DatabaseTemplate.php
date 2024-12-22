<?php

namespace interfaces;

interface DatabaseTemplate {
  public function save(array $requires) : bool;
  public function remove() : bool;
}

?>
