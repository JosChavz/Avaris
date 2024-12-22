<?php

declare(strict_types=1);

use PHPIcons\Config\PHPIconsConfig;

return PHPIconsConfig::configure()
    ->withPaths([__DIR__ . '/src/templates', __DIR__ . '/public'])
    ->withDefaultPrefix('')
    ->withPlaceholder('�');
