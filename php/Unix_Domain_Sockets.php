<?php
$sock = socket(AF_UNIX, SOCK_STREAM, 0);
if ($sock < 0)
    die(strerror($sock));
unlink("/tmp/sterlingsock");
if (($ret = bind($sock, "/tmp/sterlingsock")) < 0)
    die(strerror($ret));
if (($ret = listen($sock, 5)) < 0)
	die(strerror($ret));
while (($csock = accept_connect($sock)) < 0) {
    // .. Manipulate client socket, $csock here
}
close($sock);

//For clients:

$sock = socket(AF_UNIX, SOCK_STREAM, 0);
if ($sock < 0)
    die(strerror($sock));
if (($ret = connect($sock, "/tmp/sterlingsock")) < 0)
    die(strerror($ret));
if (($ret = write($sock, $data, $data_len)) < 0)
    die(strerror($ret));
while (($ret = read($sock, $buf, $buflen)) < 0) {
    print $buf;
}
close($sock);
?>
