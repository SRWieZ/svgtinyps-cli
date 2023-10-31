<?php

test('it fixes all the issues we can fix', function ($svg) {
    $this->input_file = fixPathForTest('assets/'.$svg);
    $this->output_file = fixPathForTest('tmp/').$svg.'.tinyps';
    exec('php src/svgtinyps.php convert '.$this->input_file.' '.$this->output_file, $convert_output, $convert_code);
    exec('php src/svgtinyps.php issues '.$this->output_file, $issues_output, $issues_code);
    $this->issues_after = array_filter(array_map('trim', $issues_output));

    // Ignore issues we can't really fix
    $this->issues_after = array_diff($this->issues_after, [
        'Logo is larger than 32KB',
        'Element <image> is not allowed',
        'SVG is not square',
    ]);

    expect($this->issues_after)->toBeEmpty()
        ->and(file_exists($this->output_file))->toBeTrue()
        ->and(filesize($this->output_file))->toBeGreaterThan(0)
        ->and($convert_code)->toBe(0)
        ->and($issues_code)->toBe(0);
})->with('logos');

afterEach(function () {
    unlink($this->output_file);

    if ($this->status()->isFailure()) {
        dump($this->issues_after, $this->input_file, $this->output_file);
    }
});
