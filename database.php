<?php
session_start();
$user = -1;
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}

function isAdaptation($link) {
    $pattern = "Adaptation from ";
    $len = strlen($pattern);
    return (substr($link, 0, $len) === $pattern);
}

function extractLink($string, $star) {
    preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string, $match);
    if (count($match) < 1) return "";
    if (count($match[0]) == 1) {
        return "<a target=\"_blank\" href='" . $match[0][0] . "'>Click here</a>" . $star;
    } elseif (count($match[0]) < 1) return "";
    else {
        $out = "";
        $i = 0;
        foreach ($match[0] as $url) {
            $out .= "<a target=\"_blank\" href='" . $url . "'>[".$i++."]</a>" . $star;
        }
        return $out;
    }
}

$db = connect();

$soft = array();
if (($handle = fopen("data/soft.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, "#")) !== FALSE) {
        $soft[$data[0]] = $data[1];
    }
    fclose($handle);
}

$maps = array();
if (($handle = fopen("data/mapping.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, "#")) !== FALSE) {
        $maps[$data[0]] = ucfirst(strtolower($data[1]));
    }
    fclose($handle);
}

$desc = array();
if (($handle = fopen("data/description.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
        $desc[$data[0]] = $data[1];
    }
    fclose($handle);
}

$messages = array();
$exists = array();
$qq = '';

$log = "";
if (isset($_POST)) {
    foreach ($_POST as $x => $y) {
        $x = str_replace("^", "_", $x);
        $log .= $x . ";";
    }
}

$stmt  = $db->prepare("INSERT into logs_wemss (user, log) values (?, ?)");
$stmt->bind_param("is", $user, $log);
$stmt->execute();
$stmt->close();


if (isset($_POST)) {
    foreach ($_POST as $x => $y) {
        $tmp = str_replace("^", ".", $x);
        $x = str_replace("^", "_", $x);
        if (array_key_exists($tmp, $soft)) {
            $tmpM = $soft[$tmp];
            $x = array_search(ucfirst(strtolower($x)), $maps);
            $messages['r' . $x] = $tmpM;
            $exists['r' . $x] = 0;
            $qq .= ', r' . $x . " ";
        }
    }
}
$q = "SELECT names" . $qq . " FROM methods9";
if (isset($_POST)) {
    $q .= ' where ';
    foreach ($_POST as $x => $y) {
        $x = str_replace("^", "_", $x);
        $x = array_search(ucfirst(strtolower($x)), $maps);
        $x = 'r' . $x;
        if (!array_key_exists($x, $messages)) {
            $q .= $x . " = 1 and ";
        }
    }
    $q = substr($q, 0, -4);
}
$q .= " ORDER BY names;";
$result = $db->query($q);
$i = 0;
$style = "";
$clas = "item";
$adaptations = 0;
if ($result->num_rows > 0) {
    echo "<div><p class='font-weight-bold text-center text'>Number of weighting methods suitable for this decision-making problem = " . $result->num_rows . "</p></div>";
    // output data of each row
    $header = "<table class='table'> <thead>
                    <tr>
                        <th scope=\"col\">Method name</th>
                        <th scope=\"col\">Reference</th>
                    </tr>
                    </thead>
                    <tbody id=\"dbRes\">";
    $softRows = array();
    $softSymbols = array();
    while ($row = $result->fetch_assoc()) {
        if ($i > 5) {
            $style = "display: none";
            $clas = "item-hiden";
        }
        $note = '';
        foreach ($row as $x => $y) {
            if (array_key_exists($x, $messages) && $y < 1) {
                if ($note != '') $note .= '<br>';
                $note .= $messages[$x];
                $exists[$x] = 1;
                if (!array_key_exists($x, $softSymbols)) {
                    $softSymbols[$x] = array_sum($exists);
                }
            }
        }
        if ($note != '') {
            $softRows[] = $row;
            continue;
        }
        if ($i == 0) echo $header;
        echo "        <tr id='$i' class='$clas' style='$style'>
            <td>";
        $star = "";
        if (isAdaptation($desc[$row["names"]])) {
            $adaptations++;
            $star = "*";
        }
        echo str_replace("_", " ", $row["names"]) .
            " <span role='button' onclick='showProperties(\"" . $row["names"] . "\")'> &#9432;</span></td>
<td>" . extractLink($desc[$row["names"]], $star) . "</td>
        </tr>";
        $i++;
    }
    if (sizeof($softRows) > 0) {
        if ($i == 0) echo $header;
        echo "<tr id='$i' class='$clas' style='$style'><td style='text-align: center' colspan='3'><strong>Other methods</strong><br> ";
        $i++;
        foreach ($messages as $x => $y) {
            if ($exists[$x] == 1) {
                echo "<sup>$softSymbols[$x]</sup><i>$y</i><br> ";
                $i++;
            }
        }
        echo '</td></tr>';
        foreach ($softRows as $row) {
            if ($i > 5) {
                $style = "display: none";
                $clas = "item-hiden";
            }
            echo "        <tr id='$i' class='$clas' style='$style'>
            <td>";
            echo str_replace("_", " ", $row["names"]);
            foreach ($softSymbols as $x => $y) {
                if ($row[$x] < 1) {
                    echo " <sup>" . $y . "</sup>";
                }
            }
            $star = "";
            if (isAdaptation($desc[$row["names"]])) {
                $adaptations++;
                $star = "*";
            }
            echo " <span role='button' onclick='showProperties(\"" . $row["names"] . "\")'> &#9432;</span></td>
            <td>" . extractLink($desc[$row["names"]], $star) . "</td>
        </tr>";
            $i++;
        }
    }
    if ($i > 0) echo "</tbody></table>";
    if ($i > 6) {
        echo "<div class=\"row\">
                <div class=\"col-lg-12\">
                    <div class=\"gallery-btn text-center\">
                        <button type=\"button\" onclick='showAll()' id=\"showAll\" class=\"btn btn-primary\">Load More</button>
                    </div>
                </div>
            </div>";
    }
    if ($adaptations > 0) {
        echo "<div style='text-align: right'>* Adaptation from</div>";
    }
} /*elseif (isset($_POST)){
    $ignored = array();
    while (count($ignored) < count($_POST)) {
        $q = "SELECT names FROM methods4 where ";
        $added = 0;
        foreach ($_POST as $x => $y ) {
            if (in_array($x, $ignored) || $added > 0) {
                $x = array_search(ucfirst($x), $maps);
                $q .= 'r' . $x . " = 1 and ";
            } else {
                $ignored[] = $x;
                $added = 1;
            }
        }
        $q = substr($q, 0, -4);
        $q .= " order by names;";
        $result = $db->query($q);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "        <tr id='. $i .' class='item'>
            <td>" . str_replace("_", " ", $row["names"]) . "</td>
            <td><a href='https://www.wp.pl' target=\"_blank\">link</a> </td>
            <td><a href='https://www.wp.pl' target=\"_blank\">link</a> </td>
            <td>520</td>
            <td>B. Roy</td>
            <td style='color: red'>" . end($ignored) . "</td>
        </tr>";
                $i++;
            }
        }
    }*/


$db->close();
