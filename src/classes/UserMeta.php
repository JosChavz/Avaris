<?php

namespace classes;

class UserMeta extends Database {
  protected static string $table_name = "user_meta";
  protected array $columns = ['uid', 'monthly_budget_id', 'timezone', 'last_login', 'monthly_budget_amount'];
  public int $uid;
  public int|null $monthly_budget_id;
  public int $monthly_budget_amount = 300;
  public string $timezone;
  public $last_login;

  public function __construct(array $args = []) {
    parent::__construct($args);

    if (isset($args['uid'])) {
      $this->uid = $args['uid'];
    }
    if (isset($args['monthly_budget_id'])) {
      $this->monthly_budget_id = $args['monthly_budget_id'];
    }
    if (isset($args['timezone'])) {
      $this->timezone = $args['timezone'];
    }
    if (isset($args['monthly_budget_amount']) && is_int($args['monthly_budget_amount'])) {
      $this->set_monthly_budget($args['monthly_budget_amount']); 
    }
  }


  /***
   * Sets a monhtly budget but MUST be greater than 0
   * @param float $monthly_budget_amount 
   * @return bool 
   ***/
  public function set_monthly_budget(int $monthly_budget_amount) : bool {
    $temp_errors = array();

    if ($monthly_budget_amount <= 0 ) {
      $temp_errors[] = "Please have an amount greater than or equal to 0.";
    } else {
      $this->monthly_budget_amount = $monthly_budget_amount;
    }

    $this->add_errors($temp_errors);

    return empty($temp_errors);
  }

  /***
   * Verifies to check if the current monthly_budget is expired
   * If so, create a new one and set it
   * Otherwise, leave it alone
   * @return bool - True if the budget does not go out of bounds;
   *                Otherwise False if a new budget was made
   ***/
  public function verify_monthly_budget() : bool {
    $budget = Budget::find_by_id_auth($this->monthly_budget_id, $this->uid);

    # If budget is outdated, create a new one and return false
    $budget_month = (!is_null($budget)) ? date('m', strtotime($budget->from_date)) : '';
    if (is_null($budget) || $budget_month != date('m')) {
      $new_budget = new Budget([
        "name" => date("F Y"),
        "uid" => $this->uid,
        "max_amount" => $this->monthly_budget_amount,
        "from_date" => date('m/01/Y'),
        "to_date" => date('m/t/Y')
      ]);


      if (!$new_budget->save()) {
        self::add_errors(['Could not create Budget for UserMeta. Please contact support.']);
      } else {
        $this->monthly_budget_id = $new_budget->id;
      }

      return false;
    }

    return true; 
  }

  public function save(array $requires=["uid", "monthly_budget_id", 'monthly_budget_amount']) : bool {
    return parent::save($requires);
  }

}


?>

