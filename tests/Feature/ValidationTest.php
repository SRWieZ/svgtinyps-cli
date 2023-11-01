<?php

test('it output an error if input file does not exist', function () {
    exec('php src/svgtinyps.php convert assets/does-not-exist.svg tmp/does-not-exist.svg', $output, $exitCode);
    $output = implode("\n", $output); // Combine array elements into a single string
    expect($output)->toContain("Error: Input file not provided or doesn't exist")
        ->and($exitCode)->toBe(1);
});

test('it output an error if output directory does not exist', function () {
    exec('php src/svgtinyps.php convert assets/twitter.svg tmp/output/does-not-exist.svg', $output, $exitCode);
    $output = implode("\n", $output); // Combine array elements into a single string
    expect($output)->toContain('Error: The output directory either does not exist or is not writeable')
        ->and($exitCode)->toBe(1);
});

test('it output an error if output directory is not provided', function () {
    exec('php src/svgtinyps.php convert assets/twitter.svg', $output, $exitCode);
    $output = implode("\n", $output); // Combine array elements into a single string
    expect($output)->toContain('Error: Output file not provided for conversion')
        ->and($exitCode)->toBe(1);
});

test('it output an error if command is not provided or invalid', function () {
    exec('php src/svgtinyps.php assets/twitter.svg', $output, $exitCode);
    $output = implode("\n", $output); // Combine array elements into a single string
    expect($output)->toContain('Invalid command')
        ->and($exitCode)->toBe(1);
});
