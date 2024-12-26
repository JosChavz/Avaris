<?php

namespace classes;

class Changelog extends Database {
  protected static string $table_name = 'changelog';
  protected array $columns = ['title', 'description'];

  // Columns
  public string $title;
  public string $description;

  function __construct(array $args=[]) {
    parent::__construct($args);

    self::$columns = array_merge(parent::$columns, $self::$columns);
  }

}

?>
