<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class HelpersFunctionsTest extends TestCase
{
    public function test_should_format_correct_name_to_uc_words(): void
    {
        $name         = 'mY tEST NamE';
        $formatted    = format_name($name);
        $expectedName = 'My Test Name';

        $this->assertEquals($expectedName, $formatted);
    }
}
