<?php

namespace classes;

class UserMeta extends Database {
  protected static string $table_name = "user_meta";
  protected array $columns = ['uid', 'monthly_budget_id', 'timezone', 'last_login'];
  public int $uid;
  public int|null $monthly_budget_id;
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
    $budget_month = date('m', strtotime($budget->from_date));
    if ($budget_month != date('m')) {
      $new_budget = new Budget([
        "name" => date("F Y"),
        "uid" => $this->uid,
        "max_amount" => 300,
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

  public function save(array $requires=["uid", "monthly_budget_id"]) : bool {
    return parent::save($requires);
  }

}


?>

