<?php

namespace classes;

class Logger {
  // TODO : Logger should LOG INTO FILE not prompt messages etc. That's a session
    public function log_error(string $error="") {
      if(!empty($error)) {
          // Then this is a "set" message
          $_SESSION['error'] = $error;
          return true;
      } else {
          // Then this is a "get" message
          return $_SESSION['error'] ?? '';
      }
    }

    public function log_message($msg="") {
        if(!empty($msg)) {
            // Then this is a "set" message
            $_SESSION['message'] = $msg;
            return true;
        } else {
            // Then this is a "get" message
            return $_SESSION['message'] ?? '';
        }
    }

    public function prompt_messages() : string {
        if (!isset($_SESSION['message'])) {
            return '';
        }

        ob_start();
        ?>

        <div id="status-message">
            <?= $_SESSION['message'] ?>
        </div>

        <?php
        $this->clear_message();
        return ob_get_clean();
    }

    public function clear_messages(): void
    {
        unset($_SESSION['message']);
    }

}

?>
