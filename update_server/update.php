<?PHP

require "functions.php";
require "config.php";

header("Content-Type: application/json");



if (!$update = json_decode(implode("\n", file($config['UPDATE_JSON'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES)), true)) {
    response(array("ERROR" => "INTERNAL_SERVER_ERROR"));
}



if (!isset($_REQUEST['ver'])) {
    response(array("ERROR" => "MALFORMED_REQUEST"));
}

$remote_ver = preg_replace('/[^\\d]/', '', $_REQUEST['ver']);
$latest_ver = preg_replace('/[^\\d]/', '', $update['VERSION']);


$RESPONSE["UPDATE"]["AVAILABLE"] = false;
$RESPONSE["UPDATE"]["URL"] = NULL;
$RESPONSE["UPDATE"]["PASSWORD"] = NULL;

if ($latest_ver > $remote_ver) {
    if (isset($_GET['update']) && isset($_GET['password'])) {
        if ($_GET['password'] === md5($update["PASSWORD"])) {

            ignore_user_abort(true);
            set_time_limit(0); // disable the time limit for this script
            init_download(__DIR__ . "/{$config['SECRET_DIR']}/" . $update['UPA_FILE']);
            exit;
        }
    }

    $RESPONSE["UPDATE"]["AVAILABLE"] = true;
    $RESPONSE["UPDATE"]["VERSION"] = $update["VERSION"];
    $RESPONSE["UPDATE"]["URL"] = $config['UPDATER_SCRIPT_URL'] . "/update.php?ver={$_REQUEST['ver']}&update&password=" . urlencode(md5($update["PASSWORD"]));
    $RESPONSE["UPDATE"]["PASSWORD"] = $update["PASSWORD"];
    $RESPONSE["LOCAL"]["VERSION"] = $_REQUEST['ver'];
}

response($RESPONSE);



