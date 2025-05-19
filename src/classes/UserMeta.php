<?php

namespace classes;

class UserMeta extends Database {
  protected static string $table_name = "user_meta";
  protected array $columns = ['uid', 'timezone', 'last_login'];
  public int $uid;
  public string $timezone;
  public $last_login;

  public function __construct(array $args = []) {
    parent::__construct($args);

    if (isset($args['uid'])) {
      $this->uid = $args['uid'];
    }
    if (isset($args['timezone'])) {
      $this->timezone = $args['timezone'];
    }
  }

  public function save(array $requires=["uid"]) : bool {
    return parent::save($requires);
  }

}

