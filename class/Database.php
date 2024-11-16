<?php

class Database
{
    CONST DB_HOST = "localhost";
    CONST DB_DBNAME = "sehs4517_102";
    CONST DB_USERNAME = "root";
    CONST DB_PASSWORD = "";

    protected $_connection;

    public function __construct()
    {   
        // auto connect db
        if(!$this->_connection)
        {
            $this->_connection = $this->_connectDb(self::DB_HOST, self::DB_DBNAME, self::DB_USERNAME, self::DB_PASSWORD);
        }
    }

    /**
     * @param  string  $host      db host
     * @param  string  $db        db name
     * @param  string  $username  db login username
     * @param  string  $password  db login password
     * @return object  $pdo       pdo
     */
    protected function _connectDb($host, $db, $username, $password)
    {
        return new PDO("mysql:host={$host};dbname={$db};charset=utf8", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * @param  object $pdo      php pdo db connection
     * @param  string $sql      mysql query
     * @param  array  $bindData list of bind data with values
     * @return array  $data     assoc array of one row data
     */
    public function fetchOne($sql, $bindData = array()) {

        // get db connection
        $pdo = $this->getConnection();

        // bind data to avoid sql injection
        $data = array();
        foreach ($bindData as $key => $value) {
            $data[$key] = $this->removeXSS($value);
        }

        // execute query
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // retund db data
        return $result;
    }

    /**
     * @param  object $pdo      php pdo db connection
     * @param  string $sql      mysql query
     * @param  array  $bindData list of bind data with values
     * @return array  $result   assoc array of all row data
    */
    public function fetchAll($sql, $bindData = array()) 
    {
        // get db connection
        $pdo = $this->getConnection();

        // bind data to avoid sql injection
        $data = array();
        foreach ($bindData as $key => $value) {
            $data[$key] = $this->removeXSS($value);
        }

        // execute query
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // retund db data
        return $result;
    }

    /**
     * @param  object $pdo          php pdo db connection
     * @param  string $sql          mysql query
     * @param  array  $bindData     list of bind data with values
     * @return int    $lastInsertId auto increment id of row
     */
    public function insertQuery($sql, $bindData = array()) 
    {
        // get db connection
        $pdo = $this->getConnection();

        // bind data to avoid sql injection
        $data = array();
        foreach ($bindData as $key => $value) {
            $data[$key] = $this->removeXSS($value);
        }

        // execute query
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $lastInsertId = $pdo->lastInsertId();

        // retund last insert id
        return $lastInsertId;
    }

    /**
     * @param  object $pdo      php pdo db connection
     * @param  string $sql      mysql query
     * @param  array  $bindData list of bind data with values
     * @return int    $rowCount affeced amount of row
     */
    public function updateQuery($sql, $bindData = array()) 
    {
        // get db connection
        $pdo = $this->getConnection();

        // bind data to avoid sql injection
        $data = array();
        foreach ($bindData as $key => $value) {
            $data[$key] = $this->removeXSS($value);
        }

        // execute query
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data); 
        $rowCount = $stmt->rowCount();

        // retund updated row count
        return $rowCount;
    }

    /**
     * @author ozkanozcan
     * @link   https://gist.github.com/ozkanozcan/3378054
     * @param  string $val string need to remove XXS
     * @return string $val string of after remove xss
    */
    public function removeXSS($val) 
    {
        $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';

        for ($i = 0; $i < strlen($search); $i++) {
            $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);
            $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
        }
        $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
        $ra = array_merge($ra1, $ra2);
        $found = true;

        while ($found == true) {

            $val_before = $val;

            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(&#0{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }

                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);
                $val = preg_replace($pattern, $replacement, $val);

                if ($val_before == $val) {
                    $found = false;
                }
            }
        }
        return $val;
    }
}