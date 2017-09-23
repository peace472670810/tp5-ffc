<?php
/**
 * Created by PhpStorm.
 * User: Jim FAN
 * Date: 2017/9/13
 * Time: 21:37
 */

namespace vendor;

class ip {
    private $fp;
    private $firstip;
    private $lastip;
    private $totalip;
    private static $_instance = null;

    public function __construct($filename = "qqwry.dat") {
        $this->fp = 0;
        if (($this->fp = @fopen($filename, "rb")) !== false) {
            $this->firstip = $this->getlong();
            $this->lastip = $this->getlong();
            $this->totalip = ($this->lastip - $this->firstip) / 7;
            register_shutdown_function(array(&$this, "__destruct"));
        }
    }

    public function __destruct() {
        if ($this->fp) {
            @fclose($this->fp);
        }
        $this->fp = 0;
    }

    private function getlong() {
        $result = unpack("Vlong", fread($this->fp, 4));
        return $result["long"];
    }

    private function getlong3() {
        $result = unpack("Vlong", fread($this->fp, 3) . chr(0));
        return $result["long"];
    }

    private function packip($ip) {
        return pack("N", intval(ip2long($ip)));
    }

    private function getstring($data = "") {
        $char = fread($this->fp, 1);
        while (ord($char) > 0) {
            $data.=$char;
            $char = fread($this->fp, 1);
        }
        return $data;
    }

    private function getarea() {
        $byte = fread($this->fp, 1);
        switch (ord($byte)) {
            case 0:
                $operators = "";
                break;
            case 1:
            case 2:
                fseek($this->fp, $this->getlong3());
                $operators = $this->getstring();
                break;
            default:
                $operators = $this->getstring($byte);
                break;
        }
        return $operators;
    }

    public function getlocation($ip) {
        if (!$this->fp) {
            return null;
        }
        $location["ip"] = gethostbyname($ip);
        $ip = $this->packip($location["ip"]);
        $l = 0;
        $u = $this->totalip;
        $findip = $this->lastip;
        while ($l <= $u) {
            $i = floor(($l + $u) / 2);
            fseek($this->fp, $this->firstip + $i * 7);
            $startip = strrev(fread($this->fp, 4));
            if ($ip < $startip) {
                $u = $i - 1;
            } else {
                fseek($this->fp, $this->getlong3());
                $endip = strrev(fread($this->fp, 4));
                if ($ip > $endip) {
                    $l = $i + 1;
                } else {
                    $findip = $this->firstip + $i * 7;
                    break;
                }
            }
        }
        fseek($this->fp, $findip);
        $location["startip"] = long2ip($this->getlong());
        $offset = $this->getlong3();
        fseek($this->fp, $offset);
        $location["endip"] = long2ip($this->getlong());
        $byte = fread($this->fp, 1);
        switch (ord($byte)) {
            case 1:
                $countryOffset = $this->getlong3();
                fseek($this->fp, $countryOffset);
                $byte = fread($this->fp, 1);
                switch (ord($byte)) {
                    case 2:
                        fseek($this->fp, $this->getlong3());
                        $location["area"] = $this->getstring();
                        fseek($this->fp, $countryOffset + 4);
                        $location["operators"] = $this->getarea();
                        break;
                    default:
                        $location["area"] = $this->getstring($byte);
                        $location["operators"] = $this->getarea();
                        break;
                }
                break;
            case 2:
                fseek($this->fp, $this->getlong3());
                $location["area"] = $this->getstring();
                fseek($this->fp, $offset + 8);
                $location["operators"] = $this->getarea();
                break;
            default:
                $location["area"] = $this->getstring($byte);
                $location["operators"] = $this->getarea();
                break;
        }
        if ($location["area"] == "CZ88.NET") {
            $location["area"] = "Unknow";
        }
        if ($location["operators"] == "CZ88.NET") {
            $location["operators"] = "Unknow";
        }
        return $location;
    }

    /**
     *
     * @staticvar array $arr
     * @param type $ip
     * @param type $showType 展示形式 1  ip+loc(title) ，2 loc,3 ip+loc (text)
     * @return string|array
     */
    public static function loc($ip, $showType = 1) {
        static $arr = array();
        if (!isset($arr[$ip])) {
            if (!self::$_instance) {
                self::$_instance = new Ip(realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "qqwry.dat");
            }
            $location = self::$_instance->getlocation($ip);
            $arr[$ip] = iconv('gb2312', 'utf-8', $location['area']) . ' - ' . iconv('gb2312', 'utf-8', $location['operators']);
        }
        if ($showType == 1) {
            return '<span title="' . $arr[$ip] . '">' . $ip . '</span>';
        }
        if ($showType == 2) {
            return $arr[$ip];
        }
        if ($showType == 3) {
            return  $ip .'【'. $arr[$ip].'】' ;
        }
    }

}

?>