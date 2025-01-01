<?php

namespace partials;

/**
 * Created for credits.php
 **/
class CreditListPartial {
  /**
   * Renders a linkable list item
   * Schema:
   *  {
   *    "url"       => string
   *    "imageURL"  => string
   *    "text"      => string
   *  }
   **/
  static function render_item(array $item) : string {
    $url = $item["url"] ?? "";
    $imageURL = $item["imageURL"] ?? "";
    $text = $item["text"] ?? "";
    ob_start();
    ?>
    <li>
      <a href="<?php echo $url; ?>" class="flex flex-row gap-2 items-center w-fit">
      <img src="<?php echo $imageURL ?>" class="w-[50px]" />
        <span class="text-xl font-bold"><?php echo $text; ?></span>
      </a>
    </li>
    <?php
    return ob_get_clean();
  }
}

?>
