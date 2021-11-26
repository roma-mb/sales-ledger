<?php

namespace Tests\Unit;

use App\Enumerations\Commission;
use PHPUnit\Framework\TestCase;

class CommissionTest extends TestCase
{
    public function test_should_apply_commission(): void
    {
        $value            = 2500.00;
        $commission        = Commission::applyPercentage($value);
        $commissionCompare = $value * Commission::PERCENTAGE;

        $this->assertEquals($commissionCompare, $commission);
    }
}
