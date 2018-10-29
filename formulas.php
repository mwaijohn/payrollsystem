<?php
/**
 * @class contain formulas to calculate paye for kenyan tax payers 2018
 */
class Calculate
{
  //get tax rates
  static function getRates(){
    $rates_config = file_get_contents('taxbands.json');
    $rates_data = json_decode($rates_config,true);
    // foreach ($rates_data as $key => $value) {
    //   echo $key ."=>". $value ."\n";
    // }
    // print($rates_data["1"]);
    return $rates_data;
  }

  //get nhif rates
  static function getNHIFRates($grosstaxableincome){
    $rates_config = file_get_contents('nhifrates.json');
    $rates_data = json_decode($rates_config,true);
    if(in_array($grosstaxableincome, range(0,5999))){
      echo $rates_data['0-5999'];
      return $rates_data['0-5999'];
    }elseif (in_array($grosstaxableincome, range(6000,7999))) {
      return $rates_data['6000-7999'];
    }elseif (in_array($grosstaxableincome, range(8000,11999))) {
      return $rates_data['8000-11999'];
    }elseif (in_array($grosstaxableincome, range(12000,14999))) {
      return $rates_data['12000-14999'];
    }elseif (in_array($grosstaxableincome, range(15000,19999))) {
      return $rates_data['1500-19999'];
    }elseif (in_array($grosstaxableincome, range(20000,24999))) {
      return $rates_data['20000-24999'];
    }elseif (in_array($grosstaxableincome, range(25000,29999))) {
      return $rates_data['25000-29999'];
    }elseif (in_array($grosstaxableincome, range(30000,34999))) {
      return $rates_data['30000-34999'];
    }elseif (in_array($grosstaxableincome, range(35000,39999))) {
      return $rates_data['35000-39999'];
    }elseif (in_array($grosstaxableincome, range(40000,44999))) {
      return $rates_data['40000-44999'];
    }elseif (in_array($grosstaxableincome, range(45000,49999))) {
      return $rates_data['45000-49999'];
    }elseif (in_array($grosstaxableincome, range(50000,59999))) {
      return $rates_data['50000-59999'];
    }elseif (in_array($grosstaxableincome, range(60000,69999))) {
      return $rates_data['60000-69999'];
    }elseif (in_array($grosstaxableincome, range(70000,79999))) {
      return $rates_data['70000-79999'];
    }elseif (in_array($grosstaxableincome, range(80000,89999))) {
      return $rates_data['80000-89999'];
    }elseif (in_array($grosstaxableincome, range(90000,99999))) {
      return $rates_data['90000-99999'];
    }elseif ($grosstaxableincome>=100000) {
      echo $rates_data['100000'];
      return $rates_data['100000'];
    }
    //print($rates_data["0-5999"]);
    return $rates_data;
  }

  static function explore($interval,$deductions,$grosstaxableincome,$tax_relief=1408,$initialband=12298){
    //get initial tax
    $initial_tax = 1229.8;
    $net_taxable_income = $grosstaxableincome - $deductions;
    $ffffff = $net_taxable_income;
    echo $net_taxable_income ," old taxable income\n";
    if($net_taxable_income<12298){
      echo "no tax";
      return 0;
    }else{
      $net_taxable_income = $net_taxable_income - $initialband;
      echo $net_taxable_income ." net taxable income new\n";
      //get number of bands
      $bands_no = $net_taxable_income/$interval;
      echo $bands_no ."\n";
        //$tax = $initial_tax + $interval/0.15;
        //#############################################
        if($bands_no>3){
          $bands_no = 3;
        }
        //taxed income total
        $taxed_income = $initialband +($interval*(int)$bands_no);
        echo $taxed_income . " taxed income\n";

        //not taxed
        $not_taxed =$ffffff - $taxed_income;
        echo $not_taxed ." not taxed\n";
        if((int)($net_taxable_income/$interval) == 0){
          $tax = $not_taxed * Calculate::getRates()["2"];
          $tax = $tax + $initialband*Calculate::getRates()["1"]-$tax_relief;
          return $tax;
        }elseif ((int)($net_taxable_income/$interval) == 1) {
          $tax = $not_taxed * Calculate::getRates()["3"];
          $tax = $tax + Calculate::getRates()["1"]*$initialband + Calculate::getRates()["2"]*$interval - $tax_relief;
          return $tax;

        }elseif ((int)($net_taxable_income/$interval) == 2) {
          $tax = $not_taxed * Calculate::getRates()["4"];
          $tax = $tax + Calculate::getRates()["1"]*$initialband + Calculate::getRates()["2"]*$interval + Calculate::getRates()["3"]*$interval -$tax_relief;
          return $tax;
        }else {
          $tax = $not_taxed * Calculate::getRates()["5"];
          $tax = $tax + Calculate::getRates()["1"]*$initialband + Calculate::getRates()["2"]*$interval + Calculate::getRates()["3"]*$interval + Calculate::getRates()["4"]*$interval -$tax_relief;
          return $tax;
        }
    }
  }
}
//Calculate::explore(11587,1080,150000);
//Calculate::explore(11587,1080,20000);
//echo Calculate::explore(11587,1080,30000);
//Calculate::explore(11587,1080,40000);
//Calculate::explore(11587,1080,60000);

//Calculate::getRates();
//Calculate::getNHIFRates(100000);

 ?>
