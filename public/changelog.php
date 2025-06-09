<?php

use classes\Changelog;
use League\CommonMark\CommonMarkConverter;

$title = "Changelog";
$bg_color = "bg-gray-50 dark:bg-gray-700";

$changelogs = Changelog::find_all();
$converter = new CommonMarkConverter();
ob_start();

?>

<header class="mb-10">
    <h1 class="text-3xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">Changelog</h1>
</header>

<section id="changelog" class="flex flex-col gap-10">
    <?php foreach ($changelogs as $changelog): ?>
        <article>
            <h1 class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white">
                <?php echo $changelog->title ?>
            </h1>
            <div class="text-sm font-light text-gray-500 dark:text-gray-400">
                <?php echo $changelog->created_at ?>
            </div>
            <div class="description text-black dark:text-white">
                <?php try {
                    echo $converter->convert($changelog->description);
                } catch (\League\CommonMark\Exception\CommonMarkException $e) {
                    echo "Something went wrong here! Somebody contact Jose!";
                } ?>
            </div>
        </article>
    <?php endforeach; ?>
</section>


<?php

$content = ob_get_clean();
require_once TEMPLATE_OUTER;
