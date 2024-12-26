<?php

namespace classes;

class Bank extends Database
{
    protected static string $table_name = "banks";
    protected array $columns = ['uid', 'name', 'type'];

    public int $uid;
    public string $name;
    public string $type;
    const BANK_TYPE = [
        'DEBIT' => 'DEBIT',
        'CREDIT' => 'CREDIT',
    ];

    public function __construct(array $args=[])
    {
      parent::__construct($args);

      self::$columns = array_merge(parent::$columns, self::$columns);
      if (array_key_exists('id', $args)) {
          $this->id = $args['id'];
      }
      if (array_key_exists('uid', $args)) {
          $this->uid = $args['uid'];
      }
      if (array_key_exists('name', $args)) {
          $this->set_name($args['name']);
      }
      if (array_key_exists('type', $args)) {
          $this->set_type($args['type']);
      }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function set_name(string $name): bool
    {
        $isValid = true;
        $name = trim($name);

        if (empty($name)) {
            $isValid = false;
            $this->errors[] = "Bank name cannot be empty";
        } else if (!preg_match("/^[a-zA-Z ]{4,40}$/", $name)) {
            $isValid = false;
            $this->errors[] = "Invalid bank name. Please be a non-numerical name with a size of 4-40 characters";
        } else {
            $this->name = $name;
        }

        return $isValid;
    }

    /**
     * @param string $type
     * @return bool
     */
    public function set_type(string $type): bool
    {
        $isValid = true;
        $type = trim($type);

        if (empty($type)) {
            $isValid = false;
            $this->errors[] = "Bank type cannot be empty";
        } else if (!array_key_exists($type, self::BANK_TYPE)) {
            $isValid = false;
            $this->errors[] = "Invalid bank type. Please be a valid bank type";
        }
        else {
            $this->type = $type;
        }

        return $isValid;
    }

    public function save(array $requires=[]): bool {
        $requires = ['uid', 'name', 'type'];
        return parent::save($requires);
    }

    public static function select_names(int $user_id): array {
        $results = [];
        $sql = "SELECT id, name FROM banks WHERE uid=" . self::$database->escape_string($user_id) . ';';
        $result = self::$database->query($sql);
        foreach ($result as $row) {
            $results[$row['id']] = $row['name'];
        }

        return $results;
    }
}
