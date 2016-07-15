<?PHP

if (php_sapi_name() != "cli") {
    die("CLI only!");
}

// CHange values but preserve keys!
$update = array(
    "VERSION" => "1.2.2",
    "DATE" => date("Y-m-d H:i:s"),
    "PASSWORD" => "d348ab4f1f165bdfbbf0b83906b8edd99d44019217d4ab81fb5e015f6692b709",
    "UPA_FILE" => "240fXwO70vrzpEhwY2jpBuYbZolCmCRnVpzDr0ttv6AUIFi22OTd4dUYWL0FgFGn.upa"
);


if (file_put_contents("update.json", json_encode($update, JSON_PRETTY_PRINT))) {
    echo "OK" . PHP_EOL;
} else {
    echo "Cannot generate JSON file!" . PHP_EOL;
}
