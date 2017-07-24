<?php

/*
@ Author: Mevlut Kagan BALGA
@ mail  : kaganbalga@gmail.com
*/

define("USD", 0);
define("AUD", 1);
define("DKK", 2);
define("EUR", 3);
define("GBP", 4);
define("CHF", 5);
define("SEK", 6);
define("CAD", 7);
define("KWD", 8);
define("NOK", 9);
define("SAR", 10);
define("JPY", 11);
define("BGN", 12);
define("RON", 13);
define("RUB", 14);
define("IRR", 15);
define("CNY", 16);
define("PKR", 17);


  class ExchangeProvider {
    public $file;

    public function __construct(){
      $this->file = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/today.xml");
    }

    //Get the spesific time's exchange rates.
    public function spesificTimeRates($month = null, $day = null, $year = null){
      if ($month == null || $day == null || $year == null) {
        throw new \Exception("The parameters can not be a null");
      }

      $this->file = simplexml_load_file("http://www.tcmb.gov.tr/kurlar/".$year.$month."/".$day.$month.$year.".xml");
    }

    private function currencyChecker($currency = null){
      if ($currency == null) {
        throw new \Exception("Undefined Currency Type.");
      }

      $definedCurrency = constant($currency);
      if (!is_numeric($definedCurrency)) {
        throw new \Exception("Unknown Constant");
      }

      return $definedCurrency;
    }

    public function getFullData($currency = null){
      return $this->file->Currency[$this->currencyChecker($currency)];
    }

    public function getCurrencyName($currency = null){
      return $this->file->Currency[$this->currencyChecker($currency)]->CurrencyName;
    }

    //You need to use extract() for this function.
    public function getBuyingSellingRates($currency = null){
      $buyingRate = $this->file->Currency[$this->currencyChecker($currency)]->BanknoteBuying;
      $sellingRate = $this->file->Currency[$this->currencyChecker($currency)]->BanknoteSelling;

      return compact("buyingRate", "sellingRate");
    }

    //You need to use extract() for this function.
    public function getForexRates($currency = null){
      $forexBuyingRate = $this->file->Currency[$this->currencyChecker($currency)]->ForexBuying;
      $forexSellingRate = $this->file->Currency[$this->currencyChecker($currency)]->ForexSelling;

      return compact("forexBuyingRate", "forexSellingRate");
    }
  }
?>
