<?php

namespace classes;

use http\Exception\RuntimeException;
use enums\ExpenseType;
use enums\TransactionType;

class Transaction extends Database
{
    protected static string $table_name = "transactions";
    protected array $columns = ['uid', 'bid', 'name', 'amount', 'description', 'type', 'category'];
    public int $uid;
    public int|null $bid;
    public string $name;
    public float $amount;
    public string $description;
    public TransactionType $type;
    public ExpenseType|null $category;
    public int|null $budget_id;

    public function __construct(array $args = []) {
      parent::__construct($args);

      if (isset($args['uid'])) {
          $this->uid = $args['uid'];
      }
      if (isset($args['bid']) && !empty($args['bid'])) {
        $this->set_bank_id((int)$args['bid']);
      }
      if (isset($args['name'])) {
          $this->set_name($args['name']);
      }
      if (isset($args['amount'])) {
          $this->set_amount($args['amount']);
      }
      if (isset($args['description'])) {
          $this->description = $args['description'];
      }
      if (isset($args['type'])) {
        try {
          $this->type = TransactionType::from($args['type']);
        } catch(\Error $e) {
          $this->errors[] = "Invalid type";
        }
      }
      if (isset($args['category'])) {
        try {
          $this->category = ExpenseType::from($args['category']);
        } catch(\Error $e) {
          $this->errors[] = "Invalid category";
        }
      }
    }

    static protected function instantiate($row): Transaction
    {
      $object = new static([]);
      foreach ($row as $key => $value) {
        if (property_exists($object, $key)) {
          if ($key == 'type') {
            $object->$key = TransactionType::from(strtolower($value));
          } else if ($key == 'category') {
            $object->$key = ExpenseType::tryFrom(strtolower($value ?? ''));
          } else {
            $object->$key = $value;
          }
        }
      }

      return $object;
    }

    public function save(array $requires=["uid", "name", "amount", "type"]) : bool {
      if ($this->type == TransactionType::EXPENSE) $requires[] = 'category';
      return parent::save($requires);
    }

    public function set_bank_id(int|string $bid) : bool
    {
        if ($bid !== "CASH") {
            $this->bid = $bid;
        }

        return true;
    }

    public function set_name(string $name) {
      $name = trim($name);
      $temp_errors = array();

      $pattern = "#^[a-zA-Z '\"/.]{2,40}$#";

      if (empty($name)) {
          $temp_errors[] = "Expense name cannot be empty";
      } else if (!preg_match($pattern, $name)) {
          $temp_errors[] = "Invalid expense name. Please be a non-numerical name with a size of 2-40 characters";
      } else {
          $this->name = $name;
      }

      $this->add_errors($temp_errors);
      return count($temp_errors) == 0;
    }

    public function set_amount(int|float $amount) {
        $amount = trim($amount);
        $temp_errors = array();

        if (empty($amount)) {
            $temp_errors[] = "The amount cannot be empty.";
        } else if ($amount < 0) {
            $temp_errors[] = "Must be a positive value. Did you mean income if using negative?";
        } else {
            $this->amount = (float) $amount;
        }

        $this->add_errors($temp_errors);
        return count($temp_errors) == 0;
    }

    public static function count_all_from_user_and_bank(int $user_id, int $bank_id) : int {
        $sql = "SELECT COUNT(*) FROM " . static::$table_name . " WHERE uid=" . self::$database->escape_string($user_id) . " AND bid=" . self::$database->escape_string($bank_id);
        $result = self::$database->query($sql);
        $row = $result->fetch_assoc();
        $result->free();
        return array_shift($row);
    }

    /***
     * User summation of expenses of type EXPENSE
     * If no $cats is present, will return all categories
     * Will skip any types that does not exist with no warning.
     * @param int   $user_id  User ID
     * @param array $cats     Category from ExpenseType enum
     * @param array $args     Extra arguments with the schema: 
     *                        [
     *                          bank_id : int
     *                          year    : int
     *                          month   : int
     *                        ] 
     ***/
    public static function select_summation(int $user_id, array $cats=[], array $args=[]) : float {
      if (empty($cats)) return self::select_all_summation($user_id, $args);

      $sum = 0;

      $sql = "SELECT SUM(amount) FROM transactions WHERE uid=" . $user_id;

      $sql .= " AND CATEGORY IN (";
      foreach ($cats as $cat) {
        $str_cat = ExpenseType::tryFrom($cat);
        if (is_null($str_cat)) continue;
        $sql .= self::$database->escape_string(strtoupper($str_cat));
      }
      $sql .= ")";

      if (isset($args['bank_id'])) {
          $sql .= " AND bid=" . self::$database->escape_string($args['bank_id']);
      }
      if (isset($args['year'])) {
          $sql .= " AND YEAR(created_at) = " . self::$database->escape_string($args['year']);
      }
      if (isset($args['month'])) {
          $sql .= " AND MONTH(created_at) = " . self::$database->escape_string($args['month']);
      }

      $sql .= ";";
      $result = self::$database->query($sql);
      $row = $result->fetch_assoc();
      $result->free();

      return array_shift($row) ?? 0;
    }
    /***
     * User summation of expenses of type EXPENSE
     * ONLY USED PRIVATELY
     * @param int   $user_id  User ID
     * @param array $args     Extra arguments with the schema: 
     *                        [
     *                          bank_id : int
     *                          year    : int
     *                          month   : int
     *                        ] 
     ***/
    private static function select_all_summation(int $user_id, array $args) : float {
       $sql = "SELECT SUM(amount) FROM transactions WHERE uid=" . $user_id . " AND type='EXPENSE'";
      if (isset($args['bank_id'])) {
          $sql .= " AND bid=" . self::$database->escape_string($args['bank_id']);
      }
      if (isset($args['year'])) {
          $sql .= " AND YEAR(created_at) = " . self::$database->escape_string($args['year']);
      }
      if (isset($args['month'])) {
          $sql .= " AND MONTH(created_at) = " . self::$database->escape_string($args['month']);
      }

      $sql .= ";";
      $result = self::$database->query($sql);
      $row = $result->fetch_assoc();
      $result->free();

      return array_shift($row) ?? 0;

    }


    public static function select_summation2(int $user_id, string $type, array $args=[]) : string {
        $sql = "SELECT SUM(amount) FROM transactions WHERE uid=" . $user_id . " AND type='" . self::$database->escape_string($type) . "'";
        if (isset($args['bank_id'])) {
            $sql .= " AND bid=" . self::$database->escape_string($args['bank_id']);
        }
        if (isset($args['year'])) {
            $sql .= " AND YEAR(created_at) = " . self::$database->escape_string($args['year']);
        }
        if (isset($args['month'])) {
            $sql .= " AND MONTH(created_at) = " . self::$database->escape_string($args['month']);
        }

        $result = self::$database->query($sql);
        $row = $result->fetch_assoc();
        $result->free();
        return array_shift($row) ?? 0;
    }

    public static function select_all_type_summation(int $user_id, array $cats=[], array $args=[]) : array {
        $type_summations = array();

        foreach ($cats as $cat) {
            $sql = "SELECT SUM(amount) FROM transactions WHERE uid=" . $user_id . " AND category='" . self::$database->escape_string($cat) . "'";

            if (isset($args['bank_id'])) {
                $sql .= " AND bid=" . self::$database->escape_string($args['bank_id']);
            }
            if (isset($args['year'])) {
                $sql .= " AND YEAR(created_at) = " . self::$database->escape_string($args['year']);
            }
            if (isset($args['month'])) {
                $sql .= " AND MONTH(created_at) = " . self::$database->escape_string($args['month']);
            }

            $result = self::$database->query($sql);
            $row = $result->fetch_assoc();
            $result->free();
            $curr_sum = array_shift($row);

            // Only add it if exists
            if (isset($curr_sum)) {
                $type_summations[$cat] = $curr_sum;
            }
        }

        return $type_summations;
    }


    /***
     * Selects all transactions from bank with extra arguments
     * @param int   $user_id User's ID
     * @param int   $bank_id Bank ID to select from
     * @param array $args    Extra arguments:
     *                       [
     *                          year   : int
     *                          month  : int
     *                          limit  : int
     *                          offset : int
     *                       ]
     ***/
    public static function select_from_bank(int $user_id, int $bank_id, array $args=[]) {
       $sql = "SELECT * FROM transactions WHERE bid = " . self::$database->escape_string($bank_id) .
            " AND uid=" . $user_id;

        if (isset($args['month'])) {
            $sql .= " AND MONTH(created_at)=" . self::$database->escape_string($args['month']);
        }
        if (isset($args['year'])) {
            $sql .= " AND YEAR(created_at)=" . self::$database->escape_string($args['year']);
        }
        if (isset($args['limit'])) {
            $sql .= " LIMIT " . self::$database->escape_string($args['limit']);
        }
        if (isset($args['offset'])) {
            $sql .= " OFFSET " . self::$database->escape_string($args['offset']);
        }

        $sql .= " ORDER BY created_at DESC";
        return self::find_by_sql($sql);
    }

}
