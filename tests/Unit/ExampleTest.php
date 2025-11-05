<?php


namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }
}
=======
test('that true is true', function () {
    expect(true)->toBeTrue();
});
>>>>>>> 5dbb5e9b770a1d1b6c8c08ef2fa4d8432bd2a547
