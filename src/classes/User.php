<?php

namespace classes;

use enums\UserRoles;
use \DateTime;

class User extends Database
{
    protected static string $table_name = "users";
    public string $name;
    public string $email;
    public string $password;
    public string $confirm_password;
    protected array $columns = ['name', 'email', 'hashed_password', 'role', 'friend_ids'];

    protected string $hashed_password;
    public UserRoles $role = UserRoles::USER;
    protected bool $password_required = true;

    public function __construct(array $args=[]) {
      parent::__construct($args);

      if (array_key_exists('id', $args)) {
          $this->id = $args['id'];
      }
      if (array_key_exists('name', $args)) {
          $this->set_name($args['name']);
      }
      if (array_key_exists('password', $args)) {
          $this->set_password($args['password']);
      }
      if (array_key_exists('email', $args)) {
          $this->set_email($args['email']);
      }
      if (array_key_exists('role', $args)) {
        try {
          $this->role = UserRoles::from($args['role']);
        } catch(\Error $e) {
          $this->errors[] = "Invalid role"; 
        }
      }
      if (array_key_exists('confirm_password', $args)) {
          $this->set_confirm_password($args['confirm_password']);
      }
    }

    static protected function instantiate($row): User
    {
      $object = new static([]);
      foreach ($row as $key => $value) {
        if (property_exists($object, $key)) {
          if ($key == 'role') {
            $object->$key = UserRoles::from(strtolower($value));
          } else {
            $object->$key = $value;
          }
        }
      }

      return $object;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function set_name(string $name): bool
    {
        $isValid = true;
        $name = trim($name);
        $temp_errors = array();

        if (empty($name)) {
            $isValid = false;
            $temp_errors[] = "User name cannot be empty";
        } else if (!preg_match("/^[a-zA-Z ]{4,40}$/", $name)) {
            $isValid = false;
            $temp_errors[] = "Invalid user name. Please be a non-numerical name with a size of 4-40 characters";
        } else {
            $this->name = $name;
        }

        $this->add_errors($temp_errors);
        return $isValid;
    }

    public function set_password(string $password): bool {
        $password = trim($password);
        $temp_errors = array();

        if($this->password_required) {
            if(empty($password)) {
                $temp_errors[] = "Password cannot be blank.";
            } elseif (!$this->has_length($password, array('min' => 12))) {
                $temp_errors[] = "Password must contain 12 or more characters";
            } elseif (!preg_match('/[A-Z]/', $password)) {
                $temp_errors[] = "Password must contain at least 1 uppercase letter";
            } elseif (!preg_match('/[a-z]/', $password)) {
                $temp_errors[] = "Password must contain at least 1 lowercase letter";
            } elseif (!preg_match('/[0-9]/', $password)) {
                $temp_errors[] = "Password must contain at least 1 number";
            } elseif (!preg_match('/[^A-Za-z0-9\s]/', $password)) {
                $temp_errors[] = "Password must contain at least 1 symbol";
            }
        }

        if (empty($temp_errors)) {
            $this->password = $password;
        }

        $this->add_errors($temp_errors);
        return count($temp_errors) === 0;
    }

    public function set_confirm_password(string $confirm_password): bool
    {
        $confirm_password = $confirm_password;
        $temp_errors = array();

        if (!isset($this->password)) {
            return false;
        }

        if (empty($confirm_password)) {
            $temp_errors[] = "Confirm password cannot be empty";
        } else if (($this->password ?? '') !== $confirm_password) {
            $temp_errors[] = "Passwords do not match";
        } else {
            $this->confirm_password = $confirm_password;
        }

        $this->add_errors($temp_errors);
        return count($temp_errors) === 0;
    }

    public function set_email(string $email): bool {
        $email = trim($email);
        $temp_errors = array();

        if (empty($email)) {
            $temp_errors[] = "Email cannot be empty";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $temp_errors[] = "Invalid email format";
        } else {
            $this->email = $email;
        }

        $this->add_errors($temp_errors);
        return count($temp_errors) === 0;
    }

    protected function set_hashed_password(): void
    {
        $this->hashed_password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function verify_password($password): bool
    {
        return password_verify($password, $this->hashed_password);
    }

    protected function create(array $requires=[]): bool
    {
      $requires = ['name', 'email', 'hashed_password', 'role'];

      $this->set_hashed_password();
      if (!parent::create($requires)) {
        return false;
      }

      # Create a budget for the `monthly_budget_id`
      $budget = new Budget([
        "name" => date("F Y"),
        "uid" => $this->id,
        "max_amount" => 300,
        "from_date" => date('m/01/Y'),
        "to_date" => date('m/t/Y')
      ]);

      if (!$budget->save()) {
        $this->add_errors(['Could not create Budget. Please contact support.']);
        self::remove();
        return false;
      }

      # After creating a user, create its user_meta
      $user_meta = new UserMeta([
        'uid' => $this->id,
        'monthly_budget_id' => $budget->id,
      ]);

      if (!$user_meta->save()) {
        $this->add_errors(['Could not create UserMeta. Please contact support.']);
        $budget->remove();
        self::remove();
        return false;
      }

      return true;
    }

    protected function update(array $requires = []): bool
    {
      $requires = ['name', 'email', 'hashed_password', 'role'];
      if($this->password != '') {
          $this->set_hashed_password();
          // validate password
      } else {
          // password not being updated, skip hashing and validation
          $this->password_required = false;
      }
      return parent::update($requires);
    }

    static public function find_by_username($username): Database | null
    {
        $sql = "SELECT * FROM " . static::$table_name . " ";
        $sql .= "WHERE email='" . self::$database->escape_string($username) . "'";
        $obj_array = static::find_by_sql($sql);
        if(!empty($obj_array)) {
            return array_shift($obj_array);
        } else {
            return null;
        }
    }

}
