<?php

//$string = '(015) 234-2634';
$string = '+27 (015) 234-2634';
//  \(\d{3}\)\s* to capture (015)
//  \D to capture all non numeric characters
//  ^\d{2} to capture first two digits
$pattern = array("/\(\d{3}\)\s*/","/\D/","/^\d{2}/");

echo preg_replace_callback($pattern, function($matches){
    $countrycode = 27;

    if(strlen($matches[0])>4){ //(015)
        return substr($matches[0],2,-1); //grab 15 from (015)
    }
    else if(is_numeric($matches[0]) && $matches[0]==$countrycode ){
                //if it has country code just add "+" to the begining
        return "+".$matches[0];
    }
    else if(is_numeric($matches[0]) && $matches[0]!=$countrycode ){
                //if it has not country code add "+" and countrycode to the begining
        return "+".$countrycode.$matches[0];
    }
   else{
       // if its not a digit return null
       return null; 
   }
}, $string);

?>