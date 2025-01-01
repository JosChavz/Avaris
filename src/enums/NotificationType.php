<?php 

namespace enums;

enum NotificationType : string {
  case MESSAGE = 'message';
  case FOLLOWER = 'follower';
  case LIKE = 'like';
  case MENTION = 'mention';
}

?>
