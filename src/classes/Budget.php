<?php

namespace classes;

use \DateTime;

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
      $this->set_max_amount($args['max_amount']);
    }
    if (array_key_exists('from_date', $args)) {
      $this->set_from_date($args['from_date']);
    }
    if (array_key_exists('to_date', $args)) {
      $this->set_to_date($args['to_date']);
    }
  }

  public function save(array $requires=[]): bool {
      return parent::save($this->columns);
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

  public function set_max_amount(float|string $max_amount) {
    $temp_errors = array();
    if ($max_amount < 1) {
      $temp_errors[] = "Budget must be 1 or greater.";
    } else {
      $this->max_amount = (float)$max_amount;
    }

    $this->add_errors($temp_errors);
    return count($temp_errors) == 0;
  }

  public function set_from_date(string $from_date) {
    $temp_errors = array();

    if (empty($from_date)) {
      $temp_errors[] = "From date cannot be empty.";
    } else {
      $temp_date = DateTime::createFromFormat('m/d/Y', $from_date);
      $this->from_date = $temp_date->format('Y-m-d H:i:s');
    } 

    $this->add_errors($temp_errors);
    return count($temp_errors) == 0;
  }

  public function set_to_date(string $to_date) {
      $temp_errors = array();

      if (empty($to_date)) {
        $temp_errors[] = "To date cannot be empty.";
      } else if (is_null($this->from_date) || empty($this->from_date)) {
        $temp_errors[] = "Please include a from date."; 
      } else {
        $temp_date = DateTime::createFromFormat('m/d/Y', $to_date);
        $this->to_date = $temp_date->format('Y-m-d H:i:s');
      } 

      $this->add_errors($temp_errors);
      return count($temp_errors) == 0;
    }

}

?>
