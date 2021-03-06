<?php

class Misc {

    protected $_CI;

    function __construct() {
        $this->_CI = &get_instance();
    }

    function get_platorm() {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    function getBrowser() {

        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

    public function platform() {
        return $this->get_platorm();
    }

    public function browser() {
        return $this->getBrowser();
    }

    // check if a server is up by connecting to a port
    function chkServer() {
        $root = "http://" . $_SERVER['HTTP_HOST'];
        $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
        $port = 80;
        $hostip = @gethostbyname($host); // resloves IP from Hostname returns hostname on failure

        if ($hostip == $host) { // if the IP is not resloved
            $serverstat = "Server is down or does not exist";
        } else {
            if (!$x = @fsockopen($hostip, $port, $errno, $errstr, 5)) { // attempt to connect
                $serverstat = "Server is down";
            } else {
                $serverstat = "";
                if ($x) {
                    @fclose($x); //close connection
                }
            }
        }
        return $serverstat;
    }

}
