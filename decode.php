<?php

// $str = file_get_contents("t6f19.trc");

// $dec = base64_decode($str);

// print_r($dec);

$handle = @fopen("t6f19.trc", "rb");
if ($handle) {
    while (!feof($handle)) {
        $buffer[] = fgets($handle, 4000);
    }
    fclose($handle);
    $buffer[0][0] = chr(hexdec("FF")); // set the first byte to 0xFF
}
print_r($buffer);
?>