<?php

namespace partials;

class FooterPartial {
  /**
   * Schema:
   *   [{
   *    header: string
   *    links: array[{
   *      text: string
   *      url: URL
   *    }]
   *   }]
   **/
  static function render_submenus(array $submenus) {
    ob_start();

    var_dump($submenus);
    foreach ($submenu as $k=>$submenus):
    ?>
      <div class="max-lg:min-w-[140px]">
        <h4 class="text-gray-800 font-semibold text-base relative max-sm:cursor-pointer"><?php echo $submenu['header'] ?></h4>
        <ul class="space-y-4 mt-6">

        <?php foreach ($link as $submenu['links']): ?>
          <li>
          <a href='<?php echo $link['url'] ?>' class='hover:text-gray-800 text-gray-600 text-sm'><?php echo $link['text'] ?></a>
          </li>
        <?php endforeach; ?>

        </ul>
      </div>
    <?php
    endforeach;
    return ob_get_clean();   
  }
}

?>
