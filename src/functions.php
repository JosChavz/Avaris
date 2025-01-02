<?php

function h(string $url): void
{
    header("Location: $url");
}

function is_post_request(): bool
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Use this function to escape characters from DB values
 **/
function html(string $str) {
  return htmlspecialchars($str);
}

?>
