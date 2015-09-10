<?php

$p = new Phar('my.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'my.phar');
$p->startBuffering();
$p->setStub('<?php Phar::mapPhar(); include "phar://my.phar/index.php"; __HALT_COMPILER(); ?>');
$p->buildFromDirectory('wp-ppm/', '$(.*)\.php$');
$p->stopBuffering();

echo 'wp-ppm.phar archive has been saved' . PHP_EOL;
