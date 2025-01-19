<?php

namespace partials;

class BankFormPartial {
  public function render_form() {
    ob_start();

    return ob_get_clean();
  }
}

?>
