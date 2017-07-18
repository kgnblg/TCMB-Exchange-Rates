<?php
  class CoinMarketCapProvider{
    protected $coinName;
    protected $spesificRate;
    protected $endpointUrl;

    public function __construct($coinName = null, $spesificRate){
      $this->coinName = $coinName;
      $this->spesificRate = $spesificRate;
      $this->setEndpoint();
    }

    public function setEndpoint(){
      if ($this->coinName != null) {
        $this->endpointUrl = "https://api.coinmarketcap.com/v1/ticker/".$this->coinName."/?convert=".$this->spesificRate;
      }else{
        $this->endpointUrl = "https://api.coinmarketcap.com/v1/ticker/?convert=".$this->spesificRate;
      }
    }

    public function cURLConnection(){
      $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_VERBOSE, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_USERAGENT, $agent);
      curl_setopt($ch, CURLOPT_URL, $this->endpointUrl);
      return curl_exec($ch);
    }

    public function getAllInfo(){
      return json_decode($this->cURLConnection());
    }

    public function getUsdRate(){
      $jsonData = json_decode($this->cURLConnection());
      $returnArray = array();
      foreach ($jsonData as $jsonD) {
        $returnArray[] = array('coin' => $jsonD->name, 'usd_price' => $jsonD->price_usd);
      }
      return $returnArray;
    }

    public function getTryRate(){
      $jsonData = json_decode($this->cURLConnection());
      $returnArray = array();
      foreach ($jsonData as $jsonD) {
        $returnArray[] = array('coin' => $jsonD->name, 'special_price' => $jsonD->price_try);
      }

      return $returnArray;
    }
  }

  $tester = new CoinMarketCapProvider("","TRY");
  print_r($tester->getTryRate());
 ?>
