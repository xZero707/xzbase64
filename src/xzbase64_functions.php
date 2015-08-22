<?PHP

// file_put_contents alternative for non PHP5 | Resource file for xzbase64
// Author: External source | Moded by xZero
// https://www.elite7hackers.net
if (!function_exists('file_put_contents')) {

    function file_put_contents($filename, $data, $filename_size, $file_append = false)
    {

        if (file_exists($filename))
            unlink($filename);
        // Main function starts here
        $fp = fopen($filename, (!$file_append ? 'w+' : 'a+'));
        if (!$fp)
            return false;
        fputs($fp, $data);
        fclose($fp);
        // Main function stops here
        // Check if write was successful and return boolean true or false
        $exec = "dir $filename";
        $exec = exec($exec . ' 2>&1', $cmdout, $xzfile_noexist);
        if (file_exists($filename) && !$xzfile_noexist && filesize($filename) == $filename_size)
            return true;
        return false;
    }

}

// output_status - handles output status message by program
// Author: xZero
// https://www.elite7hackers.net
function output_status($status = "None", $endopt = 1, $switch = true)
{
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

// parse_ini_string_m - Alternative to PHP5+ parse_ini_string
// Author: Unknown | http://php.net/manual/en/function.parse-ini-string.php#111845
// https://www.elite7hackers.net
function parse_ini_string_m($str)
{

    if (empty($str))
        return false;

    $lines = explode("\n", $str);
    $ret = Array();
    $inside_section = false;

    foreach ($lines as $line) {

        $line = trim($line);

        if (!$line || $line[0] == "#" || $line[0] == ";")
            continue;

        if ($line[0] == "[" && $endIdx = strpos($line, "]")) {
            $inside_section = substr($line, 1, $endIdx - 1);
            continue;
        }

        if (!strpos($line, '='))
            continue;

        $tmp = explode("=", $line, 2);

        if ($inside_section) {

            $key = rtrim($tmp[0]);
            $value = ltrim($tmp[1]);

            if (preg_match("/^\".*\"$/", $value) || preg_match("/^'.*'$/", $value)) {
                $value = mb_substr($value, 1, mb_strlen($value) - 2);
            }

            $t = preg_match("^\[(.*?)\]^", $key, $matches);
            if (!empty($matches) && isset($matches[0])) {

                $arr_name = preg_replace('#\[(.*?)\]#is', '', $key);

                if (!isset($ret[$inside_section][$arr_name]) || !is_array($ret[$inside_section][$arr_name])) {
                    $ret[$inside_section][$arr_name] = array();
                }

                if (isset($matches[1]) && !empty($matches[1])) {
                    $ret[$inside_section][$arr_name][$matches[1]] = $value;
                } else {
                    $ret[$inside_section][$arr_name][] = $value;
                }
            } else {
                $ret[$inside_section][trim($tmp[0])] = $value;
            }
        } else {

            $ret[trim($tmp[0])] = ltrim($tmp[1]);
        }
    }
    return $ret;
}

// Execute program in background - used for auto update
// Author: Unknown | http://php.net/manual/en/function.exec.php#86329
// https://www.elite7hackers.net
function execInBackground($cmd)
{
    if (substr(php_uname(), 0, 7) == "Windows") {
        pclose(popen("start /B " . $cmd, "r"));
    } else {
        exec($cmd . " > /dev/null &");
    }
}

