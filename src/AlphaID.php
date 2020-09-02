<?php

namespace homevip;

trait AlphaID
{
    /**
     * 字符文件
     *
     * @var string
     */
    protected $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';


    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $salt = 'homevip@126.com';


    /**
     * 字符初始长度
     *
     * @var string
     */
    protected $length  = '4';


    /**
     * 打乱随机字符
     *
     * @return void
     */
    protected function upset()
    {
        for ($n = 0; $n < strlen($this->alphabet); $n++) {
            $i[] = substr($this->alphabet, $n, 1);
        }

        $passhash = hash('sha256', $this->salt);
        $passhash = (strlen($passhash) < strlen($this->alphabet))
            ? hash('sha512', $this->salt)
            : $passhash;

        for ($n = 0; $n < strlen($this->alphabet); $n++) {
            $p[] =  substr($passhash, $n, 1);
        }
        array_multisort($p,  SORT_DESC, $i);
        $this->alphabet = implode($i);
    }


    /**
     * 加密数字
     *
     * @param [type] $integer
     * @return void
     */
    private function encode(int $integer)
    {
        $this->upset();

        $base  = strlen($this->alphabet);

        if (is_numeric($this->length)) {
            $this->length--;
            if ($this->length > 0) {
                $integer += pow($base, $this->length);
            }
        }

        $out = '';
        for ($t = floor(log($integer, $base)); $t >= 0; $t--) {
            $bcp = bcpow($base, $t);
            $a   = floor($integer / $bcp) % $base;
            $out = $out . substr($this->alphabet, $a, 1);
            $integer  = $integer - ($a * $bcp);
        }

        return strrev($out); // 翻转字符串
    }


    /**
     * 解密字符串
     *
     * @param string $string
     * @return void
     */
    private function decode(string $string)
    {
        $this->upset();

        $base  = strlen($this->alphabet);

        $string  = strrev($string);
        $out = 0;
        $len = strlen($string) - 1;
        for ($t = 0; $t <= $len; $t++) {
            $bcpow = bcpow($base, $len - $t);
            $out   = $out + strpos($this->alphabet, substr($string, $t, 1)) * $bcpow;
        }

        if (is_numeric($this->length)) {
            $this->length--;
            if ($this->length > 0) {
                $out -= pow($base, $this->length);
            }
        }
        $out = sprintf('%F', $out);
        return substr($out, 0, strpos($out, '.'));
    }
}
