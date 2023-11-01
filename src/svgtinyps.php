<?php

use SVGTinyPS\SVGTinyPS;

if ( ! class_exists('\Composer\InstalledVersions')) {
    require __DIR__.'/../vendor/autoload.php';
}

// Argument parsing
$options = getopt('v', ['verbose']);
$isVerbose = isset($options['v']) || isset($options['verbose']);

$argv = array_slice($argv, 1); // Remove script name

// Remove any verbose options to leave just the command and file arguments
foreach (['-v', '--verbose'] as $verboseOption) {
    if (($key = array_search($verboseOption, $argv)) !== false) {
        unset($argv[$key]);
    }
}

$argv = array_values($argv); // Re-index array

$command = $argv[0] ?? null;

function verboseLog($message, $isVerbose)
{
    if ($isVerbose) {
        echo "[VERBOSE] $message".PHP_EOL;
    }
}

function getComposerVersion($package = 'composer/composer'): ?string
{
    if (class_exists('\Composer\InstalledVersions')) {
        return \Composer\InstalledVersions::getPrettyVersion($package) ?? null;
    }


    return null;
}

// Function to display help information
function showHelp()
{
    $version = '@git_tag@';
    echo 'Usage: svgtinyps [options] [command] [input-file] [output-file]'.PHP_EOL;
    echo PHP_EOL;
    echo 'Options:'.PHP_EOL;
    echo '  -v, --verbose  Enable verbose mode'.PHP_EOL;
    echo PHP_EOL;
    echo 'Commands:'.PHP_EOL;
    echo '  convert [input] [output]  - Convert SVG file'.PHP_EOL;
    echo '  issues  [input]           - Check for issues in SVG file'.PHP_EOL;
    // echo '  minify  [input]           - Minify SVG file'.PHP_EOL;
    echo '  help                      - Show this help information'.PHP_EOL;
    echo PHP_EOL;
    echo 'Informations:'.PHP_EOL;
    echo ! str_starts_with($version, '@git_tag') ? '  Version: '.$version.PHP_EOL : '';
    // echo 'PHP sapi name: '.php_sapi_name().PHP_EOL;
    echo '  Based on https://github.com/srwiez/php-svg-ps-converter version: '.getComposerVersion('srwiez/php-svg-ps-converter').PHP_EOL;
    echo '  Built with https://github.com/box-project/box'.PHP_EOL;
    echo php_sapi_name() == 'micro' ? '  Compiled with https://github.com/crazywhalecc/static-php-cli'.PHP_EOL : '';
}

if ( ! $command || $command === 'help') {
    showHelp();
    exit;
}

$inputFile = $argv[1] ?? null;

if ( ! $inputFile || ! file_exists($inputFile)) {
    echo "Error: Input file not provided or doesn't exist.".PHP_EOL;
    exit(1);
}

$outputFile = $argv[2] ?? null;
switch ($command) {
    case 'convert':

        // Checking output directory
        $outputDir = $outputFile ? dirname($outputFile) : null;

        if (empty($outputFile)) {
            echo 'Error: Output file not provided for conversion.'.PHP_EOL;
            exit(1);
        }

        if ($outputDir && ( ! is_dir($outputDir) || ! is_writable($outputDir))) {
            echo "Error: The output directory either does not exist or is not writeable.\n";
            exit(1);
        }

        verboseLog('Starting SVG conversion', $isVerbose);
        convertSvg($inputFile, $outputFile, $isVerbose);
        break;
    case 'issues':
        verboseLog('Checking for SVG issues', $isVerbose);
        checkIssues($inputFile, $isVerbose);
        break;
    // case 'minify':
    //     verboseLog('Starting SVG minification', $isVerbose);
    //     minifySvg($inputFile, $isVerbose);
    //     break;
    default:
        echo 'Invalid command.'.PHP_EOL;
        showHelp();
        break;
}

function convertSvg($input, $output, $isVerbose)
{
    verboseLog("Converting $input to $output", $isVerbose);

    $svgps = new SVGTinyPS(file_get_contents($input));
    $new_svg = $svgps->convert();
    file_put_contents($output, $new_svg);
}

function checkIssues($input, $isVerbose)
{
    verboseLog("Checking $input for issues", $isVerbose);

    $svgps = new SVGTinyPS(file_get_contents($input));
    $issues = $svgps->identifyIssues();
    foreach ($issues as $issue) {
        echo "$issue".PHP_EOL;
    }
}

// function minifySvg($input, $isVerbose)
// {
//     verboseLog("Minifying $input", $isVerbose);
//     // Your implementation
// }
