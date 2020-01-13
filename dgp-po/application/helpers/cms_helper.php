<?php
function make_label_user_status($status)
{
    $return = "<label class='text-muted'> N/A </label>";
    $labelClassList = [
        '-1' => 'label',
        '1' => 'label label-primary',
    ];
    foreach (_UserStatus as $k => $v) {
        if ($status == $k) {
            $return = "<label class='{$labelClassList[$k]}'> $v </label>";
            break;
        }
    }
    return $return;
}

function custom_ucwords($str)
{
    if (!empty($str)){
        return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
    } else {
        return $str;
    }
}

function curl_grap($url, $post_array = NULL, $cookie_file = NULL, $ref = NULL, $follow_location = FALSE)
{
    $ch = curl_init();
    $head[] = "Connection: keep-alive";
    $head[] = "Keep-Alive: 86400";
    $head[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $head[] = "Accept-Language: en-us,en;q=0.5";

    // general options
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0');
    curl_setopt($ch, CURLOPT_URL, $url.'?'.http_build_query($post_array)); // call url
    curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
    curl_setopt($ch, CURLOPT_TIMEOUT, 86400); // set timeout
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return result string
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // follow redirect location

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // disable ssl
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // disable ssl
//    curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow_location);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);

    if (!empty($ref)) {
        curl_setopt($ch, CURLOPT_REFERER, $ref);
    }

    // in case use post
    if (!empty($post_array)) {
        // prep post fields string
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_array));
    }

    // in case use cookie
    if (!empty($cookie_file)) {
        if (!file_exists($cookie_file)) {
            $handle = fopen($cookie_file, 'a');
            fclose($handle);
        }
        curl_setopt($ch, CURLOPT_COOKIE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    }

    // start exe curl
    $res = curl_exec($ch); // execute the curl command

    // return
    if (!$res) {
//        return false;
        dump_exit(curl_error($ch));
    } else {
        return $res;
    }
    curl_close($ch);

}

function dump($var, $label = 'Dump', $echo = TRUE)
{
    // Store dump in variable
    ob_start();
    var_dump($var);
    $output = ob_get_clean();

    // Add formatting
    $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
    $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';

    // Output
    if ($echo == TRUE) {
        echo $output;
    } else {
        return $output;
    }
}

function make_dropdown_option($array, $selectedID = '')
{
    $return = '';
    foreach ($array as $key => $record) {
        $selected = '';
        if ("$key" == "$selectedID") {
            $selected = 'selected';
        }
        $return .= "<option {$selected} value='{$key}'>{$record}</option>";
    }
    return $return;
}

function make_username($str)
{
    $return_str = '';
    $str = preg_replace('~\(.*\)~', "", $str);
    $str = strip_unicode($str);
    $str = strtolower($str);
    $str = preg_replace("/[^a-zA-Z 0-9]+/", "", $str);
    $str = trim($str);
    $str_arr = explode(' ', $str);
    $c = count($str_arr);
    if ($c > 1) {
        $last_value = array_pop($str_arr);
        $return_str = $last_value . '.' . implode('', $str_arr);
    } else {
        $return_str = $str;
    }
    return $return_str;
}

function strip_unicode($str)
{
    if (!$str) return false;
    $unicode = array('a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
        'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
        'd' => 'đ', 'D' => 'Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ', 'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ');
    foreach ($unicode as $khongdau => $codau) {
        $arr = explode("|", $codau);
        $str = str_replace($arr, $khongdau, $str);
    }
    return $str;
}

function dump_exit($var, $label = 'Dump', $echo = TRUE)
{
    dump($var, $label, $echo);
    exit;
}

function transform_date($date_str, $int_form = 'd/m/Y', $desire_form = 'Y-m-d')
{
    $date_str = DateTime::createFromFormat($int_form, $date_str);
    if (!empty($date_str)){
        $date_str = $date_str->format($desire_form);
    } else {
        $date_str = null;
    }
    return $date_str;
}