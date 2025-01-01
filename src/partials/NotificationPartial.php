<?php

namespace partials;

use enums\NotificationType;

class NotificationPartial {
  /**
   * Commonly used notification partial; Only changes the SVG based on the type of notification
   * Schema: {
   *  user: {
   *    avatar: string
   *    name: string
   *  }
   *  subject: string
   *  timestamp: Date
   * }
   **/
  private static function render_notification(array $args, NotificationType $type) : string {
    $user = $args['user'];

    $svg = match($type) {
      NotificationType::MESSAGE   => '<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path><path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path></svg>',
      NotificationType::FOLLOWER  => '<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"></path></svg>',
      NotificationType::LIKE      => '<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>',
      NotificationType::MENTION   => '<svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>',
      default                     => '',
    };
    $svg_color = match($type) {
      NotificationType::MESSAGE   => 'bg-primary-700',
      NotificationType::FOLLOWER  => 'bg-gray-900',
      NotificationType::LIKE      => 'bg-red-600',
      NotificationType::MENTION   => 'bg-green-400',
      default => '' 
    };
    $msg = match($type) {
      NotificationType::MESSAGE  => self::message_template(array(
        "name"    => $user['name'],
        "subject" => $args['subject']
      )),
      NotificationType::FOLLOWER => self::follower_template(
        $user['name']
      ),
      NotificationType::LIKE    => self::like_template(
        $user['name']
      ),
      NotificationType::MENTION => self::mention_template(array(
        "name"    => $user['name'],
        "subject" => $args['subject']
      )),
      default                   => 'Nothing here!'
    };

    ob_start();
    ?>
    <a href="#" class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
      <div class="flex-shrink-0">
      <img 
        class="rounded-full w-11 h-11" 
        src="<?php echo $user['avatar'] ?? "https://ui-avatars.com/api/?name=" . $user['name'][0] ?>" 
        alt="<?php echo $user['name'] ?> profile picture" />
        <div class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 border border-white rounded-full <?php echo $svg_color; ?> dark:border-gray-700">
          <?php echo $svg; ?>
        </div>
      </div>
      <div class="w-full pl-3">
        <?php echo $msg ?>
        <div class="text-xs font-medium text-primary-700 dark:text-primary-400">a few moments ago</div>
      </div>
    </a>
    <?php
    return ob_get_clean();
  }

  /**
   * MESSAGE template
   * schema: {
   *  name: string
   *  subject: string
   * }
   **/
  private static function message_template($args) : string {
    ob_start();
    ?>
    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
      New message from <span class="font-semibold text-gray-900 dark:text-white"><?php echo $args['name'] ;?></span>: <?php echo $args["subject"] ?>
    </div>
    <?php
    return ob_get_clean();
  }

  /***
   * FOLLOWER template
   * schema : 
   *  name : string
   ***/
  private static function follower_template(string $name) : string {
    ob_start();
    ?>
      <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
      <span class="font-semibold text-gray-900 dark:text-white"><?php echo $name; ?></span> started following you.
      </div>
    <?php
    return ob_get_clean();
  }

  /***
   * LIKE template
   * schema :
   *  name : string
   ***/
  private static function like_template(string $name) : string {
    ob_start();
    ?>
    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
      <span class="font-semibold text-gray-900 dark:text-white"><?php echo $name; ?></span> love your story. See it and view more stories.
    </div>
    <?php
    return ob_get_clean();
  }

  /***
   * MENTION template
   * schema : {
   *  name : string
   *  subject : string
   * }
   ***/
  private static function mention_template(array $args) : string {
    ob_start();
    ?>
    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">
      <span class="font-semibold text-gray-900 dark:text-white"><?php echo $args['name']; ?></span> commented on your post: <?php echo $args['subject'] ?>
    </div>
    <?php
    return ob_get_clean();
  }

  /***
   * Renders a MESSAGE notification
   * schema : {
   *  user: {
   *    avatar: string
   *    name: string
   *  }
   *  subject: string
   *  timestamp: Date
   * }
   ***/
  public static function render_message(array $args) : string {
    return self::render_notification($args, NotificationType::MESSAGE);
  }

  /***
   * Renders a FOLLOWER notification
   * schema : {
   *  user : {
   *    avatar: string
   *    name : string
   *  }
   *  timestamp : Date 
   * }
   ***/
  public static function render_follower(array $args) : string {
    return self::render_notification($args, NotificationType::FOLLOWER);
  }

  /***
   * Renders a LIKE notification
   * schema : {
   *  user : {
   *    avatar : string
   *    name : string
   *  }
   *  timestamp: Date
   * }
   ***/
  public static function render_like(array $args) : string {
    return self::render_notification($args, NotificationType::LIKE);
  }

  /***
   * Renders a MENTION notification
   * schema : {
   *  user : {
   *    avatar : string
   *    name : string
   *  }
   *  timestamp: Date
   ***/
  public static function render_mention(array $args) : string {
    return self::render_notification($args, NotificationType::MENTION);
  }
}

?>
