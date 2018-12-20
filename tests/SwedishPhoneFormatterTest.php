<?php

namespace SwedishPhoneFormatter;

use PHPUnit\Framework\TestCase;

/**
 *
 */
final class SwedishPhoneFormatterTest extends TestCase
{
  public function testFormat(): void
  {
    $formatter = new SwedishPhoneFormatter();

    $this->assertEquals(
      '08-123 45 67',
      $formatter->format('081234567')
    );

    // Changes the area code separator
    $this->assertEquals(
      '08 123 45 67',
      $formatter->format('081234567', ' ')
    );

    // Changes the area code and number separators
    $this->assertEquals(
      '08-1234567',
      $formatter->format('081234567', '-', '')
    );

    // Removes +46 country prefix and extension numbers
    $this->assertEquals(
      '08-123 45 67',
      $formatter->format('+46 (0) 81234567')
    );

    // Don’t add prefix
    $this->assertFalse($formatter->hasAreaCode('81234567'));
    $this->assertEquals(
      '812 345 67',
      $formatter->format('81234567')
    );

    // Don’t format foreign numbers
    $this->assertEquals(
      '+1-202-555-0144',
      $formatter->format('+1-202-555-0144')
    );

    // Don’t try to format non-formattable strings
    $this->assertEquals(
      'foobar',
      $formatter->format('foobar')
    );

    // Supports number grouping for numbers without area codes
    $this->assertEquals('112', $formatter->format('112'));
    $this->assertEquals('1177', $formatter->format('1177'));
    $this->assertEquals(
      '114 14',
      $formatter->format('11414')
    );
    $this->assertEquals(
      '12 34 56',
      $formatter->format('123 456')
    );
    $this->assertEquals(
      '123 45 67',
      $formatter->format('1234567')
    );
    $this->assertEquals(
      '123 456 78',
      $formatter->format('12345678')
    );
  }
}
