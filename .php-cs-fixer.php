<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->name('*.php')
    ->exclude('vendor')
    ->exclude('storage')
    ->exclude('upload')
    ->notPath('class.phpmailer.php')
    ->notPath('class.smtp.php');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setRules([
        '@PSR12' => true,
    ])
    ->setFinder($finder);
