<?php
error_reporting(E_ALL);

if (!isset($argv[1]) || $argv[1] === '') {
    die("USAGE php check.php

ARGUMENTS
    address  Mail address to check.
");
}

$mailArr = explode("@", $argv[1]);

if (!isset($mailArr[1]) || $mailArr[1] === '') {
    die("invalid email address");
} else {
    $email = $argv[1];
    $host = $mailArr[1];
}

$service_port = 25;

getmxrr($host, $mx);
if ($mx === null) {
    echo "fail to get mx server address";
    return;
}

$host = $mx[0];

$address = gethostbyname($host);

$fp = stream_socket_client("tcp://$host:$service_port", $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
    return;
} else {
    echo "Is $email valid?\n";

    fwrite($fp, "HELO idawnlight.github.com\r\n");
    fwrite($fp, "MAIL FROM: <check-if-email-exists@idawnlight.github.com>\r\n");
    fwrite($fp, "RCPT TO: <$email>\r\n");
    fwrite($fp, "QUIT\r\n");
    $temp = "";
    while (!feof($fp)) {
        $temp .= fgets($fp, 1024);
    }
    $flag = "Yes! :)\n";
    foreach (explode("\r\n", $temp) as $line) {
        if (substr($line, 0, 1) === "5") {
            $flag = "No. :(\n";
        }
    }
    fclose($fp);
}

echo $flag;
