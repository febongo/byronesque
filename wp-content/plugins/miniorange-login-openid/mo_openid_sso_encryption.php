<?php


class MOAESEncryption
{
    public static function encrypt_data($lR, $Pq)
    {
        $Pq = openssl_digest($Pq, "\x73\x68\141\x32\65\66");
        $Kw = "\x41\105\x53\55\61\62\x38\55\x43\102\x43";
        $AP = openssl_cipher_iv_length($Kw);
        $hq = openssl_random_pseudo_bytes($AP);
        $FX = openssl_encrypt($lR, $Kw, $Pq, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $hq);
        return base64_encode($hq . $FX);
    }
    public static function decrypt_data($lR, $Pq)
    {
        $gI = base64_decode($lR);
        $Pq = openssl_digest($Pq, "\163\x68\141\62\65\66");
        $Kw = "\101\x45\123\55\61\x32\x38\x2d\x43\102\103";
        $AP = openssl_cipher_iv_length($Kw);
        $hq = substr($gI, 0, $AP);
        $lR = substr($gI, $AP);
        $A3 = openssl_decrypt($lR, $Kw, $Pq, OPENSSL_RAW_DATA || OPENSSL_ZERO_PADDING, $hq);
        return $A3;
    }
    private static function pkcs5_pad($qc)
    {
        $Hz = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $lY = $Hz - strlen($qc) % $Hz;
        return $qc . str_repeat(chr($lY), $lY);
    }
    private static function pkcs5_unpad($qc)
    {
        $lY = ord($qc[strlen($qc) - 1]);
        if (!($lY > strlen($qc))) {
            goto eAx;
        }
        return false;
        eAx:
        if (!(strspn($qc, $qc[strlen($qc) - 1], strlen($qc) - $lY) != $lY)) {
            goto hU3;
        }
        return false;
        hU3:
        return substr($qc, 0, -1 * $lY);
    }
}
