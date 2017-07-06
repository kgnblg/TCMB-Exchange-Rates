<?php
  use PHPUnit\Framework\TestCase;
  require 'ExchangeProvider.php';

  class ExchangeProviderTest extends TestCase{
    public function testGetFullData(){
      $object = new ExchangeProvider();
      $testParam = "USD";
      $this->assertEquals("US DOLLAR", $object->getFullData($testParam)->CurrencyName);
    }
  }
?>
