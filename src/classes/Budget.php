<?php

namespace classes;

class Budget extends Database {
  protected static string $table_name = "budgets";
  protected array $columns = ['uid', 'name', 'max_amount', 'from_date', 'to_date'];

  public int $uid;
  public string $name;
  public float $max_amount;
  public $from_date;
  public $to_date;

  public function __construct(array $args=[])
  {
    parent::__construct($args);

    if (array_key_exists('uid', $args)) {
        $this->uid = $args['uid'];
    }
    if (array_key_exists('name', $args)) {
        $this->set_name($args['name']);
    }
    if (array_key_exists('max_amount', $args)) {
      $this->max_amount = $args['max_amount'];
    }
    if (array_key_exists('from_date', $args)) {
      $this->max_amount = $args['from_date'];
    }
    if (array_key_exists('to_date', $args)) {
      $this->max_amount = $args['to_date'];
    }
  }

    public function set_name(string $name) {
      $name = trim($name);
      $temp_errors = array();

      $pattern = "#[a-zA-Z \'\"/.]{2,40}#";

      if (empty($name)) {
          $temp_errors[] = "Budget name cannot be empty";
      } else if (!preg_match($pattern, $name)) {
          $temp_errors[] = "Invalid budget name. Please be a non-numerical name with a size of 2-40 characters";
      } else {
          $this->name = $name;
      }

      $this->add_errors($temp_errors);
      return count($temp_errors) == 0;
    }

}

?>
