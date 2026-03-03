<?php

test('it fixes all the issues we can fix', function ($logo, $issues_excepted) {
    $input_file = fixPathForTest('assets/'.$logo);
    $output_file = fixPathForTest('tmp/').$logo.'.tinyps';
    exec('php src/svgtinyps.php convert '.$input_file.' '.$output_file, $convert_output, $convert_code);
    exec('php src/svgtinyps.php issues '.$output_file, $issues_output, $issues_code);
    $issues_after = array_filter(array_map('trim', $issues_output));

    // Ignore issues we can't really fix
    $issues_after = array_diff($issues_after, [
        'Logo is larger than 32KB',
        'Element <image> is not allowed',
        'SVG is not square',
    ]);

    expect($issues_after)->toBeEmpty()
        ->and(file_exists($output_file))->toBeTrue()
        ->and(filesize($output_file))->toBeGreaterThan(0)
        ->and($convert_code)->toBe(0)
        ->and($issues_code)->toBe(0);

    unlink($output_file);
})->with('logos');
