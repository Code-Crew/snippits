<?php

if($level >= 300)
{
    if($message == "!mumble")
    {
//        Ice_loadProfile();
//        global $ICE;
	require_once('Ice.php');
	require_once('Murmur.php');
	$ICE = Ice_initialize();
//        $base = $ICE->stringToProxy('Meta:tcp -h 127.0.0.1 -p 6502');
        $meta = Murmur_MetaPrxHelper::checkedCast($ICE->stringToProxy('Meta:tcp -h 127.0.0.1 -p 6502'));
        $server = $meta->getServer(1);
        $users = $server->getUsers();

        $userlist = "";

        foreach($users as $user)
        {
            $userlist .= $user->name.", ";
        }

        $userlist = preg_replace('/(,\s)$/', '', $userlist);

        send("PRIVMSG", $chan, "Users on Mumble: $userlist");
    }
}

?>

