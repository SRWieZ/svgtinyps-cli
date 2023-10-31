<?php

test('it returns issues', function ($svg, $issues_excepted) {
    exec('php src/svgtinyps.php issues assets/'.$svg, $output, $exit_code);
    $issues = array_filter(array_map('trim', $output));

    $diff = array_diff(array_unique($issues), array_unique($issues_excepted));

    expect($diff)->toBeEmpty()
        ->and($exit_code)->toBe(0);
})->with('logos');
