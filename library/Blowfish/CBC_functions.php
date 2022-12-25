 <?php
include_once("Blowfish.php");
   function Eencrypt($cipher, $plaintext){
      $ciphertext = "";

      $paddedtext = maxi_pad($plaintext);
      $strlen = strlen($paddedtext);
    
      for($x=0; $x< $strlen; $x+=8){
         $piece = substr($paddedtext,$x,8);
         $cipher_piece = $cipher->encrypt($piece);
         $encoded = base64_encode($cipher_piece); 
         $ciphertext = $ciphertext.$encoded;       
      }

   return $ciphertext;  


   }


   function Edecrypt($cipher,$ciphertext){ 
       $plaintext = "";

      $chunks = explode("=",$ciphertext);
      
      $ending_value = count($chunks) ;

      for($counter=0 ; $counter < ($ending_value-1) ; $counter++)
      {
            $chunk = $chunks[$counter]."=";
            $decoded = base64_decode($chunk);
            
            $piece = $cipher->decrypt($decoded);
            
            $plaintext = $plaintext.$piece;

      }
      return $plaintext;

   }
  
  
  
  
   function maxi_pad($plaintext){

      $str_len = count($plaintext);
      $pad_len = $str_len % 8;
      
      for($x=0; $x<$pad_len; $x++){
         $plaintext = $plaintext." ";
      }
      
      $str_len = count($plaintext);
      if($srt_len % 8){

         print "padding function is not working\n";
      }else{
         return $plaintext;
      }
      return (-1);

   }
?>
