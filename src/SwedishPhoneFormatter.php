<?php

namespace SwedishPhoneFormatter;

/**
 *
 */
class SwedishPhoneFormatter
{
  public function getAreaCodeDigitCount($number)
  {
    if (preg_match('/^08/', $number)) {
      return 2;
    } elseif (
      preg_match(
        '/^0(
          1[013689]|
          2[0136]|
          3[1356]|
          4[0246]|
          54|
          6[03]|
          7[0235-9]|
          9[09]
        )/x',
        $number
      )
    ) {
      return 3;
    }
    return 4;
  }

  protected function onlyDigits($number)
  {
    return preg_replace('/\D/', '', $number);
  }

  protected function removeExtension($number)
  {
    return preg_replace('/\(.*\)/', '', $number);
  }

  protected function ensurePrefixes($number)
  {
    $number = preg_replace('/^\+46/', '', $number);
    return '0' . preg_replace('/^0/', '', $number);
  }

  protected function formatRest($rest, $number_separator)
  {
    switch (strlen($rest)) {
      case 5:
        return substr($rest, 0, 3) .
          $number_separator .
          substr($rest, 3);
      case 6:
        return substr($rest, 0, 2) .
          $number_separator .
          substr($rest, 2, 2) .
          $number_separator .
          substr($rest, 4);
      case 7:
        return substr($rest, 0, 3) .
          $number_separator .
          substr($rest, 3, 2) .
          $number_separator .
          substr($rest, 5);
      case 8:
        return substr($rest, 0, 3) .
          $number_separator .
          substr($rest, 3, 3) .
          $number_separator .
          substr($rest, 6);
      default:
        return $rest;
    }
  }

  protected function splitNumber($number, $number_separator)
  {
    $areaCodeSeparatorIndex = $this->getAreaCodeDigitCount(
      $number
    );
    $areaCode = substr($number, 0, $areaCodeSeparatorIndex);
    $rest = substr($number, $areaCodeSeparatorIndex);
    return [
      'areaCode' => $areaCode,
      'rest' => $this->formatRest($rest, $number_separator),
    ];
  }

  public function hasAreaCode($number)
  {
    return !!preg_match('/^[\+0]/', $number);
  }

  public function isFormattable($number)
  {
    return !!preg_match(
      '/^(\+46|0?\d)[-\d\s\(\)]+$/',
      $number
    );
  }

  public function format(
    $number,
    $area_code_separator = '-',
    $number_separator = ' '
  ) {
    if (!$this->isFormattable($number)) {
      return $number;
    }
    if (!$this->hasAreaCode($number)) {
      $cleanedUpNumber = $this->onlyDigits(
        $this->removeExtension($number)
      );
      if (strlen($cleanedUpNumber) <= 8) {
        return $this->formatRest(
          $cleanedUpNumber,
          $number_separator
        );
      }
    }
    $split = $this->splitNumber(
      $this->onlyDigits(
        $this->ensurePrefixes(
          $this->removeExtension($number)
        )
      ),
      $number_separator
    );
    return $split['areaCode'] .
      $area_code_separator .
      $split['rest'];
  }
}
