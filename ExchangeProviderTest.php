<?php
  use PHPUnit\Framework\TestCase;
  require 'ExchangeProvider.php';

  class ExchangeProviderTest extends TestCase{
    public function testGetFullData(){
      $object = new ExchangeProvider();
      $testParam = "USD";
      $this->assertEquals("US DOLLAR", $object->getFullData($testParam)->CurrencyName);
    }

    public function testSpesificTimeRates(){
      $object = new ExchangeProvider();
      $setTime = $object->spesificTimeRates("02","01","2017");
      $originalCopy = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/201702/01022017.xml");
      $this->assertEquals($originalCopy->Currency[0]->Isim, $object->file->Currency[0]->Isim);
    }

    public function testGetCurrencyName(){
      $object = new ExchangeProvider();
      $testParam = "USD";
      $this->assertEquals("US DOLLAR", $object->getCurrencyName($testParam));
    }

    public function testGetBuyingSellingRates(){
      $object = new ExchangeProvider();
      $testParam = "USD";
      $originalCopy = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml");
      $originalBuyingValue = $originalCopy->Currency[0]->BanknoteBuying;
      $originalSellingValue = $originalCopy->Currency[0]->BanknoteSelling;
      $this->assertEquals($originalBuyingValue, $object->getBuyingSellingRates($testParam)['buyingRate']);
      $this->assertEquals($originalSellingValue, $object->getBuyingSellingRates($testParam)['sellingRate']);
    }

    public function testGetForexRates(){
      $object = new ExchangeProvider();
      $testParam = "USD";
      $originalCopy = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml");
      $originalBuyingValue = $originalCopy->Currency[0]->ForexBuying;
      $originalSellingValue = $originalCopy->Currency[0]->ForexSelling;
      $this->assertEquals($originalBuyingValue, $object->getForexRates($testParam)['forexBuyingRate']);
      $this->assertEquals($originalSellingValue, $object->getForexRates($testParam)['forexSellingRate']);
    }
  }
?>
