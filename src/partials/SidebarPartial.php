<?php

// ICONS : https://flowbite.com/icons/

namespace partials;

class SidebarPartial {

  /***
   *  schema : {
   *    text : string
   *    link : URL
   *  }
   ***/
  private static function render_sub_items(array $sub_items) {
    ob_start();
  ?>
    <ul id="dropdown-layouts" class="hidden py-2 space-y-2">
    <?php foreach ($sub_items as $sub_item) : ?>
      <li>
        <a href="<?php echo $sub_item['link'] ?>" 
          class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
            <?php echo $sub_item['text']; ?>
        </a>
      </li>
    <?php endforeach; ?>
    </ul>
  <?php
    return ob_get_clean();
  }

  /***
   * Renders SINGLE or DROPDOWN link for the sidebar
   * If `subitems` is defined, then it will be treated as a dropdown
   * Which requires no `link`
   *
   * schema : {
   *  text : string
   *  link? : URL
   *  icon : string
   *  subitems? : [{
   *    text : string
   *    link : URL
   *  }]
   * }
   ***/
  public static function render_item(array $args) {
    ob_start();
  ?>
    <li>
    <?php if (!array_key_exists("subitems", $args)) : ?>
    <a href="<?php echo $args['link']; ?>" class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
        <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <?php echo $args['icon']; ?>
        </svg>
        <span class="ml-3" sidebar-toggle-item><?php echo $args['text']; ?></span>
      </a>
    <?php else : ?>
      <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700" aria-controls="dropdown-layouts" data-collapse-toggle="dropdown-layouts">
        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <?php echo $args['icon'] ?>
        </svg>
        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item><?php $args['text'] ?></span>
        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
      </button>

      <?php self::render_sub_items($args['subitems']); ?>
    <?php endif; ?>
    </li>
  <?php
    return ob_get_clean();
  }

}

?>
