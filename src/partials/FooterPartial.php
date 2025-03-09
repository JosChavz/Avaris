<?php

namespace partials;

class FooterPartial {
  /**
   * Schema:
   *   {
   *    header: string
   *    links: array[{
   *      text: string
   *      url: URL
   *    }]
   *   }
   **/
  static function render_submenus(array $submenu) {
    ob_start();
    ?>
      <div class="max-lg:min-w-[140px]">
        <h4 class="text-gray-800 dark:text-white font-semibold text-base relative max-sm:cursor-pointer"><?php echo $submenu['header'] ?></h4>
        <ul class="space-y-4 mt-6">

        <?php foreach ($submenu['links'] as $link): ?>
          <li class="!m-0">
          <a href='<?php echo $link['url'] ?>' class='hover:text-gray-800 text-gray-600 dark:text-gray-300 dark:hover:text-white text-sm'><?php echo $link['text'] ?></a>
          </li>
        <?php endforeach; ?>

        </ul>
      </div>
    <?php
    return ob_get_clean();   
  }

  /**
   * Schema:
   *  [{
   *    text: string
   *    url: URL
   *  }]
   **/
  static function render_lower_menus(array $submenus) {
    ob_start();
    ?>
    <ul class="md:flex md:space-x-6 max-md:space-y-2">

      <?php foreach ($submenus as $submenu): ?>
      <li>
        <a href='<?php echo $submenu['url'] ?>' class='hover:text-gray-800 text-gray-600 dark:text-gray-500 dark:hover:text-gray-400 text-sm'><?php echo $submenu['text'] ?></a>
      </li>
      <?php endforeach; ?>

    </ul>
    <?php
    return ob_get_clean();
  }
}

?>
