<?php

function getDirColorHexString($cnt, $i)
{
    $mode = $_COOKIE['gradient'];
    if ($mode == '') $mode = 's';
    $ing = 256;
    $step = floor($ing / $cnt);

    switch ($mode) {
        case "blue":
            return '#0000FF';
            break;
        case "green":
            return '#00FF00';
            break;
        case "red":
            return '#FF0000';
            break;
        default:
        case "black":
            return '#000000';
            break;
        case "grey":
            return '#a0a0a0';
            break;
        case "white":
            return '#FFFFFF';
            break;
        case "greenred":
            if ($i < $cnt / 2) {
                (string)$val = dechex(($cnt - $i) * $step);
                if ($i === 0) $val = 'FF';
                if (strlen($val) === 1) $val = '0' . $val;
                return '#00' . $val . '00';
            } else {
                (string)$val = dechex($i * $step);
                if ($i === ($cnt - 1)) $val = 'FF';
                if (strlen($val) === 1) $val = '0' . $val;
                return '#' . $val . '0000';
            }
            break;
        case "greenblack":
            (string)$val = dechex(($cnt - $i) * $step);
            if ($i === 0) $val = 'FF';
            if ($i === ($cnt - 1)) $val = '00';
            if (strlen($val) === 1) $val = '0' . $val;
            return '#00' . $val . '00';
            break;
        case "whiteblack":
            (string)$val = dechex(($cnt - $i) * $step);
            if ($i === 0) $val = 'FF';
            if ($i === ($cnt - 1)) $val = '00';
            if (strlen($val) === 1) $val = '0' . $val;
            return '#' . $val . $val . $val;
            break;
        case "blackwhite":
            (string)$val = dechex(($i) * $step);
            if ($i === 0) $val = '00';
            if ($i === ($cnt - 1)) $val = 'FF';
            if (strlen($val) === 1) $val = '0' . $val;
            return '#' . $val . $val . $val;
            break;
    }

    $step = floor($ing / $cnt);
    if ($onlyGreen == false) {
    } else {
        (string)$val = dechex(($cnt - $i) * $step);
        if ($i === 0) $val = 'FF';
        if ($i === ($cnt - 1)) $val = '00';
        if (strlen($val) === 1) $val = '0' . $val;
        return '#00' . $val . '00';
    }
}

clearstatcache();
$dirs = array();
foreach( glob( getcwd().'/*' ) AS $i => $dir )
{
    if (is_dir($dir) && substr($dir, 0, 1) != '.') {
            $pos = fileatime($dir);
            do {
                $pos--;
            } while (array_key_exists($pos, $dirs));
            $dirs[$pos . '-'. $i] = substr( $dir, strlen( getcwd() ) + 1 );
    }
}
krsort($dirs);
?>
<html>
<head>
    <title>Auswahl</title>
</head>

<body>
<noscript>
    <link rel="stylesheet" href="./index.light.css" type="text/css">
</noscript>
<script type="text/javascript">
    function set_cookie(key, value) {
        document.cookie = key + "=" + value + ";";
    }

    function read_cookie(key) {
        var key_eq = key + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(key_eq) == 0) {
                return c.substring(key_eq.length, c.length);
            }
        }
        return null;
    }

    function delete_cookie(key) {
        set_cookie(key, "", -1);
    }

    if (read_cookie('style') == '') {
        set_cookie('style', 'light');
    }
    if (read_cookie('gradient') == '') {
        set_cookie('gradient', 'gb');
    }

    document.write('<link rel="stylesheet" href="./index.' + read_cookie('style') + '.css" type="text/css">');

</script>
<div class="utility box" style="border-color: <?php echo getDirColorHexString(count($dirs), 1); ?>">
    <h2>Helferlein</h2>
    <ul>
        <li><a href="http://localhost/MAMP/phpinfo.php">phpInfo</a></li>
        <li><a href="http://localhost/MAMP/xcache-admin/?language=English">xCache</a></li>
        <li><a href="http://localhost/MAMP/phpmyadmin.php?lang=en-iso-8859-1&language=English">phpMyAdmin</a></li>
        <li><a href="http://localhost/MAMP/English/faq.php?language=English">FAQ</a></li>
    </ul>
    <h2>Gestaltung</h2>
    <ul>
        <li>
            <select name="" onchange="if(this.value!=''){set_cookie('style', this.value);window.location.reload();}">
                <option value="">Bitte w&auml;hlen</option>
                <option value="light">Hell</option>
                <option value="dark">Dunkel</option>
                <option value="fancy">Modern</option>
            </select>
        </li>
    </ul>
    <h2>Projekte</h2>
    <ul>
        <li>
            <select name="" onchange="if(this.value!=''){set_cookie('gradient', this.value);window.location.reload();}">
                <option value="">Bitte w&auml;hlen</option>
                <option value="blue">Blau</option>
                <option value="grey">Grau</option>
                <option value="green">Gr&uuml;n</option>
                <option value="red">Rot</option>
                <option value="black">Schwarz</option>
                <option value="white">Wei&szlig;</option>
                <option value="greenred">Gr&uuml;n > Rot</option>
                <option value="greenblack">Gr&uuml;n > Schwarz</option>
                <option value="blackwhite">Schwarz > Wei&szlig;</option>
                <option value="whiteblack">Wei&szlig; > Schwarz</option>
            </select>
        </li>
    </ul>
</div>
<?php
$i = 0;
foreach ($dirs AS $dir) {
    $url = $dir;
    if (is_dir($dir . '/htdocs')) {
        $url = $dir . '/htdocs';
    }
    $wp_admin = is_dir($url . '/wp-admin') ? (' [<a class="wp" href="' . $url . '/wp-admin">WP</a>]') : '';
    echo '<div class="box" style="border-color: ' . getDirColorHexString(count($dirs), $i) . '"><h2><a href="/' . $url . '">' . $dir . '</a>' . $wp_admin . '</h2></div>' . "\n";
    $i++;
}
?>
</body>
</html>
