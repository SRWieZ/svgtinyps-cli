<?php

error_reporting(0);

use Composer\InstalledVersions;
use SVGTinyPS\SVGTinyPS;

if (! class_exists('\Composer\InstalledVersions')) {
    require __DIR__.'/../vendor/autoload.php';
}

// Argument parsing
$argv = array_slice($argv, 1); // Remove script name
$options['is_verbose'] = false;
$options['title'] = null;

foreach ($argv as $key => $arg) {
    if (str_starts_with($arg, '--title=')) {
        $options['title'] = substr($arg, strlen('--title='));
        unset($argv[$key]);
    } elseif (in_array($arg, ['-v', '--verbose'])) {
        $options['is_verbose'] = true;
        unset($argv[$key]);
    }
}

// Re-index array after removing options
$argv = array_values($argv);
$command = $argv[0] ?? null;

function verboseLog($message, $isVerbose): void
{
    if ($isVerbose) {
        echo "[VERBOSE] $message".PHP_EOL;
    }
}

function getComposerVersion($package = 'composer/composer'): ?string
{
    if (class_exists('\Composer\InstalledVersions')) {
        return InstalledVersions::getPrettyVersion($package) ?? null;
    }

    return null;
}

// Function to display help information
function showHelp(): void
{
    $version = '@git_tag@';
    echo 'Usage: svgtinyps [options] [command] [input-file] [output-file]'.PHP_EOL;
    echo PHP_EOL;
    echo 'Options:'.PHP_EOL;
    echo '  -v, --verbose  Enable verbose mode'.PHP_EOL;
    echo '      --title=   Set company name (<title> tag)'.PHP_EOL;
    echo PHP_EOL;
    echo 'Commands:'.PHP_EOL;
    echo '  convert [input] [output]  - Convert SVG file'.PHP_EOL;
    echo '  issues  [input]           - Check for issues in SVG file'.PHP_EOL;
    echo '  minify  [input] [output]  - Minify SVG file'.PHP_EOL;
    echo '  help                      - Show this help information'.PHP_EOL;
    echo PHP_EOL;
    echo 'Informations:'.PHP_EOL;
    echo ! str_starts_with($version, '@git_tag') ? '  Version: '.$version.PHP_EOL : '';
    echo '  PHP version: '.phpversion().PHP_EOL;
    // echo 'PHP sapi name: '.php_sapi_name().PHP_EOL;
    echo '  Based on https://github.com/srwiez/php-svg-ps-converter ('.getComposerVersion('srwiez/php-svg-ps-converter').')'.PHP_EOL;
    echo '  Built with https://github.com/box-project/box'.PHP_EOL;
    echo php_sapi_name() == 'micro' ? '  Compiled with https://github.com/crazywhalecc/static-php-cli'.PHP_EOL : '';
}

if (! $command || $command === 'help') {
    showHelp();
    exit;
}

function checkInputFile($inputFile): void
{
    if (! $inputFile || ! file_exists($inputFile)) {
        echo "Error: Input file not provided or doesn't exist.".PHP_EOL;
        exit(1);
    }
}

function checkOutputFile($outputFile): void
{
    $outputDir = $outputFile ? dirname($outputFile) : null;
    if (empty($outputFile)) {
        echo 'Error: Output file not provided for conversion.'.PHP_EOL;
        exit(1);
    }

    if ($outputDir && (! is_dir($outputDir) || ! is_writable($outputDir))) {
        echo "Error: The output directory either does not exist or is not writeable.\n";
        exit(1);
    }
}

switch ($command) {
    case 'convert':
        $inputFile = $argv[1] ?? null;
        $outputFile = $argv[2] ?? null;

        checkInputFile($inputFile);
        checkOutputFile($outputFile);

        verboseLog('Starting SVG conversion', $options['is_verbose']);
        convertSvg($inputFile, $outputFile, $options['title'], $options['is_verbose']); // Pass title to convertSvg
        break;
    case 'issues':

        $inputFile = $argv[1] ?? null;
        $outputFile = $argv[2] ?? null;

        checkInputFile($inputFile);

        verboseLog('Checking for SVG issues', $options['is_verbose']);
        checkIssues($inputFile, $options['is_verbose']);
        break;
    case 'minify':
        $inputFile = $argv[1] ?? null;
        $outputFile = $argv[2] ?? null;

        checkInputFile($inputFile);
        checkOutputFile($outputFile);

        verboseLog('Starting SVG minification', $options['is_verbose']);

        minifySvg($inputFile, $outputFile, $options['is_verbose']);
        break;
    default:
        echo 'Invalid command!'.PHP_EOL;
        echo PHP_EOL;
        showHelp();
        exit(1);
}

function convertSvg($input, $output, $title, $isVerbose): void
{
    verboseLog("Converting $input to $output", $isVerbose);

    try {
        $svgps = new SVGTinyPS(file_get_contents($input));

        if ($title) {
            $svgps->setTitle($title);
        }
        $new_svg = $svgps->convert();
    } catch (Exception $exception) {
        echo 'Error: '.$exception->getMessage().PHP_EOL;
        exit(1);
    }
    file_put_contents($output, $new_svg);
}

function checkIssues($input, $isVerbose): void
{
    verboseLog("Checking $input for issues", $isVerbose);

    try {
        $svgps = new SVGTinyPS(file_get_contents($input));
        $issues = $svgps->identifyIssues();
        foreach ($issues as $issue) {
            echo "$issue".PHP_EOL;
        }
    } catch (Exception $exception) {
        echo 'Error: '.$exception->getMessage().PHP_EOL;
        exit(1);
    }
}

function minifySVG($input, $output, $isVerbose): void
{
    verboseLog("Converting $input to $output", $isVerbose);

    $new_svg = file_get_contents($input);
    $new_svg = preg_replace('/\s+/', ' ', $new_svg);

    //TODO: Maybe just use svggo ?

    file_put_contents($output, $new_svg);
}

