<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('encrypt_text')) {
    function encrypt_text($string)
    {
        $output = false;
        /*

        * read encrypt_key.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code

        */
        $encrypt_key    = parse_ini_file("files/encrypt_key.ini");
        $secret_key     = $encrypt_key["encryption_key"];
        $secret_iv      = $encrypt_key["iv"];
        $encrypt_method = $encrypt_key["encryption_mechanism"];

        // hash
        $key    = hash("sha256", $secret_key);

        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv     = substr(hash("sha256", $secret_iv), 0, 16);

        //do the encryption given text/string/number
        $result = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($result);
        return $output;
    }
}

if (!function_exists('decrypt_text')) {
    function decrypt_text($string)
    {
        $output = false;
        /*
        * read encrypt_key.ini file & get encryption_key | iv | encryption_mechanism value for generating encryption code
        */

        $encrypt_key    = parse_ini_file("files/encrypt_key.ini");
        $secret_key     = $encrypt_key["encryption_key"];
        $secret_iv      = $encrypt_key["iv"];
        $encrypt_method = $encrypt_key["encryption_mechanism"];

        // hash
        $key    = hash("sha256", $secret_key);

        // iv – encrypt method AES-256-CBC expects 16 bytes – else you will get a warning
        $iv = substr(hash("sha256", $secret_iv), 0, 16);

        //do the decryption given text/string/number

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }
}

if (!function_exists('date_indo')) {
    function date_indo($date)
    {
        $month = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $split = explode('-', $date);

        return $split[2] . ' ' . $month[(int)$split[1]] . ' ' . $split[0];
    }
}

if (!function_exists('rupiah')) {
    function rupiah($angka)
    {
        $rupiah = "Rp" . number_format($angka, 0, '', '.');
        return $rupiah;
    }
}

if (!function_exists('shoot_api')) {
    function shoot_api($param)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $param['url']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $param['method']);

        if (array_key_exists('header', $param)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $param['header']);
        }

        if (array_key_exists('data', $param)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $param['data']);
        }

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}

if (!function_exists('seo')) {
    function seo($title)
    {
        return url_title($title, '-', TRUE);
    }
}

if (!function_exists('clean_rupiah')) {
    function clean_rupiah($rupiah)
    {
        return str_replace('.', '', $rupiah);
    }
}

if (!function_exists('limit_text')) {
    function limit_text($param)
    {
        if (strlen($param['text']) >= $param['length']) {
            return substr($param['text'], 0, $param['length']) . '...';
        } else {
            return $param['text'];
        }
    }
}

if (!function_exists('encrypt_password')) {
    function encrypt_password($password)
    {
        return md5(md5($password));
    }
}

if (!function_exists('check_file_exists')) {
    function check_file_exists($url)
    {
        return stripos(get_headers($url)[0], "200 OK") ? true : false;
    }
}

if (!function_exists('send_email')) {
    function send_email($param)
    {
        $ci = get_instance();
        $ci->load->library('email');

        $config = [];
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "tcp://eureka1.eurekabookhouse.co.id";
        $config['smtp_port'] = "587";
        $config['starttls'] = TRUE;
        $config['smtp_user'] = "info@jaja.id";
        $config['smtp_pass'] = "2JB4uztW5k";
        $config["smtp_crypto"] = "tls";
        $config["dsn"] = FALSE;
        $config['newline'] = "\r\n";
        $config['charset'] = 'utf-8';
        $config['mailtype'] = 'html';

        $ci->email->initialize($config);
        $ci->email->from($config['smtp_user'], 'Jaja ID');
        $ci->email->to($param['to']);
        $ci->email->subject($param['subject']);
        $ci->email->message($param['message']);

        if (!empty($param['attach'])) {
            foreach ($param['attach'] as $key_attach) {
                $ci->email->attach($key_attach);
            }
        }

        if ($ci->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('random_number')) {
    function random_number($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
