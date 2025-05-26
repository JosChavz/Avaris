<?php

namespace classes;
use enums\UserRoles;

class Session
{
    private int $user_id;
    private string $user_name;
    private string $user_email;
    private UserRoles $user_role = UserRoles::USER;
    private $last_login;
    const MAX_LOGIN_AGE = 60 * 60 * 4; # 4 Hours
    private array $errors = array();
    private string $message;

    public function __construct() {
        session_start();
        $this->check_stored_login();
        if(!self::last_login_is_recent()) {
          $this->logout();
        }
    }

    public function login($user, bool $verify=true): bool
    {
        if ($user) {
            session_regenerate_id();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_name'] = html($user->name);
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_email'] = html($user->email);
            $_SESSION['last_login'] = time();
            $this->user_id = $user->id;

            $metas = UserMeta::find_by_user_id($user->id);
            $user_meta = array_shift($metas);
            $user_meta->last_login = date('Y-m-d');
            $user_meta->save();
        }

        return true;
    }

    public function is_logged_in(): bool
    {
        return isset($this->user_id) && $this->last_login_is_recent();
    }

    public function logout(): bool
    {
        unset($_SESSION['user_id']);
        unset($this->user_id);
        unset($_SESSION['user_name']);
        unset($this->user_name);
        unset($_SESSION['user_role']);
        unset($this->user_role);
        unset($_SESSION['user_email']);
        unset($this->user_email);
        unset($_SESSION['last_login']);
        unset($this->last_login);
        return true;
    }

    private function last_login_is_recent(): bool
    {
        if(!isset($this->last_login)) {
            return false;
        } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
            return false;
        } else {
            return true;
        }
    }

    private function check_stored_login() : void {
        if (isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
        }
        if (isset($_SESSION['user_name'])) {
            $this->user_name = html($_SESSION['user_name']);
        }
        if (isset($_SESSION['user_email'])) {
            $this->user_email = html($_SESSION['user_email']);
        }
        if (isset($_SESSION['user_role'])) {
          $this->user_role = $_SESSION['user_role'] ?? UserRoles::tryFrom($_SESSION['user_role']);
        }
        if (isset($_SESSION['last_login'])) {
            $this->last_login = $_SESSION['last_login'];
        }
        if (isset($_SESSION['errors'])) {
          $this->errors = $_SESSION['errors'];
        }
        if (isset($_SESSION['message'])) {
          $this->message = $_SESSION['message'];
        }
    }

    /**
     * @return string
     */
    public function get_user_id(): string
    {
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function get_user_name(): string
    {
        return $this->user_name;
    }

    /**
     * @return string
     */
    public function get_user_email(): string
    {
        return $this->user_email;
    }

    /**
     * @return string
     */
    public function get_user_role(): UserRoles 
    {
        return $this->user_role;
    }


    public function add_error(string $err) {
      $this->errors[] = $err;
      $_SESSION['errors'] = $this->errors; 
    }

    public function add_errors(array $errors) {
      $this->errors = array_merge($this->errors, $errors);
      $_SESSION['errors'] = $this->errors;
    }

    public function get_errors() {
      if (!isset($_SESSION['errors'])) {
        return [];
      }

      $this->clear_errors();
      return $this->errors;
    }

    public function clear_errors() {
      unset($_SESSION['errors']); 
    }

    public function add_message($msg="") {
      $this->message = $msg;
      $_SESSION['message'] = $msg;
    }

    public function get_message() : string {
      if (!isset($_SESSION['message'])) {
        return '';
      }

      $this->clear_message();
      return $this->message;
    }

    public function clear_message(): void
    {
        unset($_SESSION['message']);
    }


}
