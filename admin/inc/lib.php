<?php

class Account {

    var $userid, $username, $userlevel, $needreset;
    private $_dbhandle;

    function __construct(PDO $dbhandle, $userid = -1)
    {
        $this->_dbhandle = $dbhandle;
        if ($userid != -1) {
            $this->load($userid);
        }
    }

    function auth($username, $password) {
        $authq = $this->_dbhandle->prepare("SELECT id,password FROM administrators WHERE administrators.username = :username");
        $authq->bindParam(':username', $username);
        $authq->execute();
        if ($authq->rowcount() != 1) {
            return false;
        }
        $authrow = $authq->fetch();
        if (hash('sha256', $password) == $authrow['password']) {
            if ($this->load($authrow['id'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function load($userid) {
        $userq = $this->_dbhandle->prepare("SELECT id,username,level,resetpw FROM administrators WHERE administrators.id = :userid");
        $userq->bindParam(':userid', $userid);
        $userq->execute();
        if ($userq->rowcount() != 1) {
            return false;
        }
        $userrow = $userq->fetch();
        $this->userid = $userrow['id'];
        $this->username = $userrow['username'];
        $this->userlevel = $userrow['level'];
        $this->needreset = $userrow['resetpw'];
        return true;
    }

    function setpw($newpw) {
        $passq = $this->_dbhandle->prepare("UPDATE administrators SET password=:password, resetpw=0 WHERE administrators.id = :userid");
        $passq->bindParam(':userid', $this->userid);
        $passq->bindValue(':password', hash('sha256', $newpw));
        $passq->execute();
    }
   
}

class Radio {

    private $_dbhandle;

    function __construct(PDO $dbhandle)
    {
        $this->_dbhandle = $dbhandle;
    }

    function getnp()
    {
        $radioq = $this->_dbhandle->prepare("SELECT songid,title,artist,album,length,reqname,time FROM recent ORDER BY id DESC LIMIT 1");
        $radioq->execute();
        if ($radioq->rowCount() != 1) die("broke");
        return $radioq->fetch();
    }

}
