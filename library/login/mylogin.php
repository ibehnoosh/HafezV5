<?php
class login
{
    public $pepper = "65MEf61MZ7Trb889dX50sH";

    public function isLoggedInPerson()
    {
        if ($_SESSION[PREFIXOFSESS . 'idp']) {
            return true;
        } else {
            return false;
        }

    }
    public function logout()
    {
        mysql_query("UPDATE `person_info` SET `last_Login` =NOW() WHERE `id_per`=" . $_SESSION[PREFIXOFSESS . 'idp']);
        unset($_SESSION[PREFIXOFSESS . 'idp']);
        unset($_SESSION[PREFIXOFSESS . 'userNamePerson']);
        session_destroy();
    }
    public function count_login($user)
    {

    }
    public function dologin($user, $password_per)
    {
        $sql = "SELECT `passw0rd`,`password_per` ,`hint`, `last_Login` , HOUR(TIMEDIFF(NOW(), `last_unlogin`)) AS `hour`  FROM `person_info` WHERE `username_per`='" . $user . "'";
        $res = mysql_query($sql);

        $row = mysql_fetch_object($res);
        $_SESSION[PREFIXOFSESS . 'hint'] = $row->hint;
        $_SESSION[PREFIXOFSESS . 'hour'] = $row->hour;
        $old_pass = $row->password_per;
        $new_pass = $row->passw0rd;

        if (($_SESSION[PREFIXOFSESS . 'hint'] > 5) && ($_SESSION[PREFIXOFSESS . 'hour'] < 12)) {
            mysql_query("INSERT INTO `p_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'" . $_SERVER['REMOTE_ADDR'] . "' , 'no')");
            return false;
        } else {
            if ($new_pass != '') {
                $result = $this->check_secure_hash($row->passw0rd, $password_per);
            } else {
                if ($old_pass == md5($password_per)) {
                    $result = true;
                    $new_generate_password_per = $this->create_secure_hash($password_per, 7000);
                    mysql_query("UPDATE `person_info` SET `password_per`='',`passw0rd` = '" . $new_generate_password_per . "' WHERE `username_per`='" . $user . "'");
                } else {
                    $result = false;
                }
            }
            if ($result) {
                mysql_query("INSERT INTO `p_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
				(NULL , '$user' , NOW() , NOW() ,'" . $_SERVER['REMOTE_ADDR'] . "' , 'yes')");
                mysql_query("UPDATE `person_info` SET `last_Login` = NOW(),`last_unlogin`=NOW(), `hint`=0 WHERE `username_per`='" . $user . "'");
                $_SESSION[PREFIXOFSESS . 'idp'] = true;
                $_SESSION[PREFIXOFSESS . 'userNamePerson'] = $user;
                $_SESSION[PREFIXOFSESS . 'hint'] = 0;
                $_SESSION[PREFIXOFSESS . 'hour'] = 0;
                return true;
            } else {
                if ($_SESSION[PREFIXOFSESS . 'hour'] < 6) {
                    mysql_query("INSERT INTO `p_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'" . $_SERVER['REMOTE_ADDR'] . "' , 'no')");
                    mysql_query("UPDATE `person_info` SET `last_unlogin` = NOW(),`hint`=`hint`+1 WHERE `username_per`='" . $user . "'");
                    return false;
                } else {
                    mysql_query("INSERT INTO `p_login`(`id`, `person`, `date`, `time`, `ip`, `succ`) VALUES
					(NULL , '$user' , NOW() , NOW() ,'" . $_SERVER['REMOTE_ADDR'] . "' , 'no')");
                    mysql_query("UPDATE `person_info` SET `last_unlogin` = NOW() WHERE `username_per`='" . $user . "'");
                    return false;

                }
            }
        }
    }
    //==================================

    public function random_bytes($length)
    {
        $ranges = array('0-9', 'a-z', 'A-Z');
        foreach ($ranges as $r) {
            $r = explode('-', $r);
            $s .= implode(range(array_shift($r), $r[1]));
        }
        while (strlen($s) < $length) {
            $s .= $s;
        }

        return substr(str_shuffle($s), 0, $length);
    }
    //==================================

    public function create_secure_hash($password_per, $rounds = 7000)
    {
        $salt = $this->random_bytes(16);
        $hash = hash('sha256', $this->pepper . $salt . $password_per, true);
        $tmp = $rounds;
        do {
            $hash = hash('sha256', $hash . $password_per, true);
        } while (--$tmp);
        return base64_encode($rounds . '*' . $salt . $hash);
    }

    //==================================
    public function check_secure_hash($hash, $password_per)
    {
        $hash = base64_decode($hash);
        $rounds = substr($hash, 0, strpos($hash, '*'));
        $salt = substr($hash, strpos($hash, '*') + 1, strlen($hash) - strlen($rounds) - 32 - 1);
        $hash = substr($hash, strlen($hash) - 32);
        $tmp = $hash;
        $hash = hash('sha256', $this->pepper . $salt . $password_per, true);
        do {
            $hash = hash('sha256', $hash . $password_per, true);
        } while (--$rounds);
        return $tmp === $hash;
    }
    //==================================

    public function chang_user_pass($id, $user, $pass)
    {
        $password_per = $pass;
        $username = $user;

        $check_usernaame = "SELECT `username_per` FROM `person_info`
						  WHERE `username_per` ='" . $username . "' AND `id_per` <> " . $id;
        $res_check_usernaame = mysql_query($check_usernaame);
        if (mysql_num_rows($res_check_usernaame) == 0) {
            if ($password_per == '') {
                $sql_pass = "UPDATE `person_info`
					   SET  `username_per` ='" . $username . "'
					   WHERE `id_per`=" . $id;
                if (mysql_query($sql_pass)) {
                    return '<div class="ok" width="60%"> نام کاربری با موفقیت تغییر پیدا کرد.</div>';
                }
            } else {
                $new_pass = $this->create_secure_hash($password_per, 7000);
                $sql_pass = "UPDATE `person_info`
					   SET `passw0rd` = '" . $new_pass . "' , `username_per` ='" . $username . "',`password_per`=''
					   WHERE `id_per`=" . $id;
                if (mysql_query($sql_pass)) {
                    return '<div class="ok" width="60%"> نام کاربری و کلمه عبور با موفقیت تغییر پیدا کرد.</div>';
                }

            }

        } else {
            return '<div class="error" width="60%">این نام کاربری قبلا مورد استفاده قرار گرفته است.</div>';
        }

    }

    public function chang_pass($id, $password_per, $current_password_per)
    {
        $sql = "SELECT `passw0rd` , `username_per` FROM `person_info` WHERE `id_per`=" . $id;
        $res = mysql_query($sql);
        $row = mysql_fetch_object($res);
        $current = $row->passw0rd;
        $md5pass = $this->create_secure_hash($current_password_per, 7000);
        $new_pass = $this->create_secure_hash($password_per, 7000);
        $user = $row->User;
        if (($current == $md5pass) && ($password_per != $user)) {
            $sql_pass = "UPDATE `person_info`
						   SET `passw0rd` = '" . $new_pass . "' ,`password_per`=''
						   WHERE `id_per`=" . $id;
            if (mysql_query($sql_pass)) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

    }
}
