<?php
class Crypt_Blowfish
{
    var $_P = array();
    var $_S = array();
    var $_td = null;
    var $_iv = null;

    function Crypt_Blowfish($key)
    {
        if (extension_loaded('mcrypt')) {
            $this->_td = mcrypt_module_open(MCRYPT_BLOWFISH, '', 'ecb', '');
            $this->_iv = mcrypt_create_iv(8, MCRYPT_RAND);
        }
        $this->setKey($key);
    }
    function isReady()
    {
        return true;
    }
    function init()
    {
        $this->_init();
    }
    function _init()
    {
        $defaults = new Crypt_Blowfish_DefaultKey();
        $this->_P = $defaults->P;
        $this->_S = $defaults->S;
    }
    function _encipher(&$Xl, &$Xr)
    {
        for ($i = 0; $i < 16; $i++) {
            $temp = $Xl ^ $this->_P[$i];
            $Xl = ((($this->_S[0][($temp>>24) & 255] +
                            $this->_S[1][($temp>>16) & 255]) ^
                            $this->_S[2][($temp>>8) & 255]) +
                            $this->_S[3][$temp & 255]) ^ $Xr;
            $Xr = $temp;
        }
        $Xr = $Xl ^ $this->_P[16];
        $Xl = $temp ^ $this->_P[17];
    }
    
    function _decipher(&$Xl, &$Xr)
    {
        for ($i = 17; $i > 1; $i--) {
            $temp = $Xl ^ $this->_P[$i];
            $Xl = ((($this->_S[0][($temp>>24) & 255] +
                            $this->_S[1][($temp>>16) & 255]) ^
                            $this->_S[2][($temp>>8) & 255]) +
                            $this->_S[3][$temp & 255]) ^ $Xr;
            $Xr = $temp;
        }
        $Xr = $Xl ^ $this->_P[1];
        $Xl = $temp ^ $this->_P[0];
    }
    function encrypt($plainText)
    {
		/*
        if (!is_string($plainText)) {
            PEAR::raiseError('Plain text must be a string', 0, PEAR_ERROR_DIE);
        }

        if (extension_loaded('mcrypt')) {
            return mcrypt_generic($this->_td, $plainText);
        }
*/
        $cipherText = '';
        $len = strlen($plainText);
        $plainText .= str_repeat(chr(0),(8 - ($len%8))%8);
        for ($i = 0; $i < $len; $i += 8) {
            list(,$Xl,$Xr) = unpack("N2",substr($plainText,$i,8));
            $this->_encipher($Xl, $Xr);
            $cipherText .= pack("N2", $Xl, $Xr);
        }
        return $cipherText;
    }
    
    function decrypt($cipherText)
    {
		/*
        if (!is_string($cipherText)) {
            PEAR::raiseError('Chiper text must be a string', 1, PEAR_ERROR_DIE);
        }

        if (extension_loaded('mcrypt')) {
            return mdecrypt_generic($this->_td, $cipherText);
        }
*/
        $plainText = '';
        $len = strlen($cipherText);
        $cipherText .= str_repeat(chr(0),(8 - ($len%8))%8);
        for ($i = 0; $i < $len; $i += 8) {
            list(,$Xl,$Xr) = unpack("N2",substr($cipherText,$i,8));
            $this->_decipher($Xl, $Xr);
            $plainText .= pack("N2", $Xl, $Xr);
        }
        return $plainText;
    }
    
    function setKey($key)
    {
      /*  if (!is_string($key)) {
            PEAR::raiseError('Key must be a string', 2, PEAR_ERROR_DIE);
        }

        

        if ($len > 56 || $len == 0) {
            PEAR::raiseError('Key must be less than 56 characters and non-zero. Supplied key length: ' . $len, 3, PEAR_ERROR_DIE);
        }

        if (extension_loaded('mcrypt')) {
            mcrypt_generic_init($this->_td, $key, $this->_iv);
            return true;
        }
*/$len =55;
        require_once 'DefaultKey.php';
        $this->_init();
        
        $k = 0;
        $data = 0;
        $datal = 0;
        $datar = 0;
        
        for ($i = 0; $i < 18; $i++) {
            $data = 0;
            for ($j = 4; $j > 0; $j--) {
                    $data = $data << 8 | ord($key{$k});
                    $k = ($k+1) % $len;
            }
            $this->_P[$i] ^= $data;
        }
        
        for ($i = 0; $i <= 16; $i += 2) {
            $this->_encipher($datal, $datar);
            $this->_P[$i] = $datal;
            $this->_P[$i+1] = $datar;
        }
        for ($i = 0; $i < 256; $i += 2) {
            $this->_encipher($datal, $datar);
            $this->_S[0][$i] = $datal;
            $this->_S[0][$i+1] = $datar;
        }
        for ($i = 0; $i < 256; $i += 2) {
            $this->_encipher($datal, $datar);
            $this->_S[1][$i] = $datal;
            $this->_S[1][$i+1] = $datar;
        }
        for ($i = 0; $i < 256; $i += 2) {
            $this->_encipher($datal, $datar);
            $this->_S[2][$i] = $datal;
            $this->_S[2][$i+1] = $datar;
        }
        for ($i = 0; $i < 256; $i += 2) {
            $this->_encipher($datal, $datar);
            $this->_S[3][$i] = $datal;
            $this->_S[3][$i+1] = $datar;
        }
        
        return true;
    }
    
}

?>
