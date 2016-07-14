<?PHP

/**
 * Main file for xzbase64
 * 
 * @author xZero <xzero@elite7hackers.net>
 * @version 1.0.7
 */
if (in_array(@$argv[1], $HelpCMD)) {

    $HelpLine = file("help_document.dat");
    $helpLine[1] = "[HELP] Base64 tool by xZero Version {$program["version"]} [HELP]\n";

    if (@$argv[2] == "-file") {
        $OUTFILE_FHLP = @$argv[3] or $OUTFILE_FHLP = $ScriptName . "_help.txt";
        $HELPDOC = implode("", $HelpLine);
        $OUTBYT_EXPECTED = strlen($HELPDOC);
        if (file_put_contents($OUTFILE_FHLP, $HELPDOC, $OUTBYT_EXPECTED)) {
            output_status("$ScriptName - help document written to file $OUTFILE_FHLP", 1, $status_message_switch);
        } else {
            output_status("$ScriptName - Error! Failed writting help document to file $OUTFILE_FHLP", 1, $status_message_switch);
        }
    }

    foreach ($HelpLine as $line) {
        echo $line;
    }
    die();
}

if ($argv[1] == "--update-check") {
    output_status("# Checking for updates, please wait...\n" . $UPDATEPACKAGE, 2, $status_message_switch);
    $updateCheckA = file_get_contents("http://dc73181269f2401d0sm1.elite7hackers.net/xzbase64/updates.php?ver=" . urlencode($program["version"]));
    $updateCheckB = parse_ini_string_m($updateCheckA);
    $UPDATEPACKAGE = mt_rand(1409, 3000) . "_" . mt_rand(10000, 90000) . mt_rand(1000000000, 7000000000) . "_UPA.exe";
    if ($updateCheckA == "")
        die("Cannot connect to update server!");
    if ($updateCheckB['UPDATE']['AVAIL'] == "yes") {
        $UpdatePassword = $updateCheckB['UPDATE']['PASSWORD'];
        ECHO "# Server reported that updates are available!\n# Latest version: " . $updateCheckB['UPDATE']['CURRENT_VERSION'] . "\n# Local version: " . $updateCheckB['UPDATE']['YOUR_VERSION'];
        if ($argv[2] == "--and-update") {
            output_status("# --and-update parameter received. \n# Downloading update package from server, please wait...", 2, $status_message_switch);
            $UPDATE_DOWNLOAD = file_get_contents($updateCheckB['UPDATE']['URL']);
            $OUTBYT_EXPECTED = strlen($UPDATE_DOWNLOAD);

            if (!file_put_contents($UPDATEPACKAGE, $UPDATE_DOWNLOAD, $OUTBYT_EXPECTED)) {
                output_status("\nError! Cannot write to update file " . $UPDATEPACKAGE, 1, $status_message_switch);
            } else {
                output_status("\n# Update package downloaded. Decrypting and executing update package...\n ", 1, $status_message_switch);
                execInBackground("$UPDATEPACKAGE \"-p$UpdatePassword\"");

                die("# Done.\n");
            }
        } else {
            die("\n# To apply update type " . $ScriptName . " --update-check --and-update");
        }
        die();
    } else {
        die("# Server reported no update available!");
    }
}


if ($argv[5] == "-s") {
    $status_message_switch = false;
}


if ($argc < 4)
    output_status("\n# Elite7Hackers Network - https://www.elite7hackers.net\n# Base64 tool by xZero Version: {$program["version"]}\n# Type {$argv[0]} -help /help or /? for more info", 1, $status_message_switch);



if (strpos($argv[3], '-fl') !== false) {
    $OutFile = explode("-fl:", "DAT" . $argv[3]); // DAT is added to beginning of the string as -fl: is obviously at the beginning.
    $OutFile[0] = "-fl";
    if (!isset($OutFile[1]) or @ $OutFile[1] == "") {
        $RandFile = "output_" . mt_rand(1200000000, 7100000000) . ".txt";
        output_status("Warning! Output: Parameter -fl is not complete. Filename missing.\n", 2, $status_message_switch);
        output_status("Output: -fl:$RandFile going to be used instead.\n", 2, $status_message_switch);
        $OutFile[1] = $RandFile;
    }
} else {
    $OutFile[0] = $argv[3];
}




switch ($argv[2]) {

    case "-str":
        $input = $argv[4];
        break;

    case "-fl":
        if (!file_exists($argv[4]))
            output_status("Error! Cannot find file " . $argv[4], 1, $status_message_switch);

        $input = file_get_contents($argv[4]);
        break;
}





# THis is last processing function
switch ($argv[1]) {

    case "-enc":
        $output = base64_encode($input);
        break;

    case "-dec":
        $output = base64_decode($input);
        break;
}




switch ($OutFile[0]) {
    case "-str":
        die($output);
        break;

    case "-fl":
        $OUTBYT_EXPECTED = strlen($output);
        if (!file_put_contents($OutFile[1], $output, $OUTBYT_EXPECTED)) {
            output_status("Error! Cannot write $OUTBYT_EXPECTED bytes to file " . $OutFile[1], 1, $status_message_switch);
        } else {
            output_status("Success! $OUTBYT_EXPECTED bytes written in file $OutFile[1]", 1, $status_message_switch);
        }
        die();
        break;
}
die();
