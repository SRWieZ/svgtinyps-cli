<?php

test('it returns issues', function ($svg, $issues_excepted) {
    $input_file = fixPathForTest('assets/'.$svg);

    exec('php src/svgtinyps.php issues '.$input_file, $output, $exit_code);
    $issues = array_filter(array_map('trim', $output));

    $diff = array_diff(array_unique($issues), array_unique($issues_excepted));
    $diff2 = array_diff(array_unique($issues_excepted), array_unique($issues));

    expect($diff)->toBeEmpty()
        ->and($diff2)->toBeEmpty()
        ->and($exit_code)->toBe(0);
})->with('logos');
