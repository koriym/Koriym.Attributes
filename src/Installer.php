<?php

declare(strict_types=1);

namespace Koriym\Attributes;

use Composer\Script\Event;

final class Installer
{
    public static function postInstall(Event $event): void
    {
        $composer = $event->getComposer();
        $rootPackage = $composer->getPackage();
        $requires = $rootPackage->getRequires();

        // Check if koriym/attributes is explicitly required in root composer.json
        if (isset($requires['koriym/attributes'])) {
            return;
        }

        $io = $event->getIO();
        $io->write('');
        $io->write('<comment>koriym/attributes was installed without explicit version specification.</comment>');
        $io->write('<comment>Please specify the version explicitly in your composer.json:</comment>');
        $io->write('<comment>  composer require koriym/attributes:^2.0  (PHP 8 attributes only)</comment>');
        $io->write('<comment>  composer require koriym/attributes:^1.0  (Annotations + Attributes)</comment>');
        $io->write('<comment>For more details: https://github.com/koriym/Koriym.Attributes#migration-guide</comment>');
        $io->write('');
    }
}
