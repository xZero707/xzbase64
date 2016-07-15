<?PHP

/**
 * Main file for xzbase64
 * 
 * @author xZero <xzero@elite7hackers.net>
 * @version 1.0.7
 */
error_reporting(1);
//file_put_contents("debug.log", print_r(get_defined_functions(), true));

$program = array(
    "VERSION" => "1.0.7",
    "SCRIPT" => $program["SCRIPT"]
);
$status_message_switch = true;

$HelpCMD = array(
    "-help",
    "/?",
    "/help",
    "-?"
);

$helpLine = array(
    "",
    "[HELP] Base64 tool by xZero Version {$program["VERSION"]} [HELP]",
    " [-enc|-dec] - Chose between encode and decode.",
    " [In: -str|-fl] - Define if input is string or file.",
    " [Out: -str|-fl:out.txt] - Define output, chose either direct string or file -fl:whatever.txt ",
    " [data] - Input, it should be plain text or filename if In: -fl is chosen",
    " [opt -s] - Optional. If defined at the end, will suppress status message output from the program.",
    " -------------------------------------------------------------",
    " Usage: {$program["SCRIPT"]} [-enc|-dec] [In: -str|-fl] [Out: -str|-fl:out.txt] [data] [opt]",
    " Eg 1. {$program["SCRIPT"]} -enc -fl -fl:output.txt encryptedBASE64file.txt",
    " Eg 2. {$program["SCRIPT"]} -enc -str -str \"LETS encrypt this text\"",
    " Eg 3. {$program["SCRIPT"]} -enc -str -fl:output.txt \"LETS encrypt this text into output.txt\"",
    " Eg 4. {$program["SCRIPT"]} -enc -fl -str encryptedBASE64file.txt",
    " Eg 5. {$program["SCRIPT"]} -enc -str -str \"LETS encrypt this text, but suppress error/success output\" -s",
    " -------------------------------------------------------------",
    "  If you want to extract this help, type xzbase64 -help -file help.txt",
    "",
    "Check regulary for updates by runing xzbase64.exe --update-check",
    "or xzbase64.exe --update-check --and-update"
);

/**
 * handles output status message by program
 * @author xZero
 * 
 * @param string $status
 * @param int $endopt
 * @param bool $switch
 */
function output_status($status = "None", $endopt = 1, $switch = true) {
    if ($switch) {
        switch ($endopt) {
            case 1:
                die($status);
                break;

            case 2:
                echo $status;
                break;

            case 3:
                echo $status;
                exit;
                break;
        }
    }
}

/**
 * Execute program in background - used for auto update
 * @author Unknown <http://php.net/manual/en/function.exec.php#86329>
 * 
 * @param string $cmd
 */
function execInBackground($cmd) {
    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B " . $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null &");
    }
}

if (in_array(@$argv[1], $HelpCMD)) {

    if (@$argv[2] == "-file") {
        $OUTFILE_FHLP = @$argv[3] or $OUTFILE_FHLP = $program["SCRIPT"] . "_help.txt";
        $HELPDOC = implode(PHP_EOL, $helpLine);
        $OUTBYT_EXPECTED = strlen($HELPDOC);
        if (file_put_contents($OUTFILE_FHLP, $HELPDOC, $OUTBYT_EXPECTED)) {
            output_status("$ScriptName - help document written to file $OUTFILE_FHLP", 1, $status_message_switch);
        } else {
            output_status("$ScriptName - Error! Failed writting help document to file $OUTFILE_FHLP", 1, $status_message_switch);
        }
    }

    echo implode(PHP_EOL, $helpLine);
    exit(0);
}

if ($argv[1] == "--update-check") {
    output_status("# Checking for updates, please wait...\n" . $UPDATEPACKAGE, 2, $status_message_switch);
    $UPDATE_CHECK = file_get_contents("http://dc73181269f2401d0sm1.elite7hackers.net/xzbase64/update.php?ver=" . urlencode($program["VERSION"]));
    if (!base64_decode($UPDATE_CHECK, true)) {
        output_status("Error! Invalid server response.", 1, $status_message_switch);
    }
    $ServerResponse = unserialize(base64_decode($UPDATE_CHECK, true));

    if ($ServerResponse['UPDATE']['AVAILABLE']) {
        ECHO "# Server reported that updates are available!\n# Latest version: " . $ServerResponse['UPDATE']['VERSION'] . "\n# Local version: " . $ServerResponse['LOCAL']['VERSION'];
        if ($argv[2] == "--and-update") {
            output_status("# --and-update parameter received. \n# Downloading update package from server, please wait...", 2, $status_message_switch);
            if (!$UPDATE_DOWNLOAD = file_get_contents($ServerResponse['UPDATE']['URL'])) {
                output_status("\nError! Cannot fetch update file " . $UPDATEPACKAGE, 1, $status_message_switch);
            }
            $OUTBYT_EXPECTED = strlen($UPDATE_DOWNLOAD);
            $UPDATEPACKAGE = mt_rand(1409, 3000) . "_" . mt_rand(10000, 90000) . mt_rand(1000000000, 7000000000) . "_UPA.exe";

            if (!file_put_contents($UPDATEPACKAGE, $UPDATE_DOWNLOAD, $OUTBYT_EXPECTED)) {
                output_status("\nError! Cannot write to update file " . $UPDATEPACKAGE, 1, $status_message_switch);
            } else {
                output_status("\n# Update package downloaded. Decrypting and executing update package...\n ", 1, $status_message_switch);
                execInBackground("$UPDATEPACKAGE \"-p{$ServerResponse['UPDATE']['PASSWORD']}\"");

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
    output_status("\n# Elite7Hackers Network - https://www.elite7hackers.net\n# Base64 tool by xZero Version: {$program["VERSION"]}\n# Type {$program["SCRIPT"]} -help /help or /? for more info", 1, $status_message_switch);



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
