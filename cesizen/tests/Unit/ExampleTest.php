<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test simple : addition de deux nombres.
     */
    public function test_addition(): void
    {
        $a = 2;
        $b = 3;
        $result = $a + $b;

        $this->assertEquals(5, $result, "L'addition devrait donner 5");
    }

    /**
     * Test que du texte contient une sous-chaîne.
     */
    public function test_string_contains(): void
    {
        $message = "Bonjour CESIZen";
        $this->assertStringContainsString("CESIZen", $message);
    }
}