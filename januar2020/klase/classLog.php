<?php
class Log{
    public static function upisiLog($imeDatoteke, $stringZaUpis){
        $f=fopen($imeDatoteke, "a");
        $stringZaUpis=date("d.m.Y H:i:s", time())." - $stringZaUpis\r\n";
        fwrite($f, $stringZaUpis);
        fclose($f);
    }
}
?>