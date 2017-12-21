<?php 

/**
* 
*/
class mysql{
    private  static $ins = NULL;
    private $conn = NULL;
    private $conf = array();

    protected function __construct(){
        $this->conf = conf::getIns();

        $this->connect($this->conf->hostname,$this->conf->username,$this->conf->password);
        $this->select_db($this->conf->database);
        $this->setChar('utf8');
    }

    public function __destruct(){

    }

    public static function getIns(){
        if(!(self::$ins instanceof self)){ //
            self::$ins = new self();
        }
        return self::$ins;
    }

    public function connect($host, $username, $password){
        $this->conn = mysqli_connect($host,$username,$password);
        if(!$this->conn){
            $err = new Exception('连接数据库失败');
            throw $err;
        }
    }

    protected function select_db($db){
        $sql = 'use '.$db;
        $this->query($sql);
    }

    protected function setChar($char){
        $sql = 'set names '.$char;
        return $this->query($sql);
    }

    public function query($sql){
        //if($this->conf->debug){
        //    $this->log($sql);
        //}
        $rsql = mysqli_query($this->conn,$sql);
        //if(!$rsql){
        //    $this->log($this->error());
        //}
        //log::write($sql);

        return $rsql;
    }

    public function autoExecute($table,$arr,$mode='insert',$where=' where 1 limit 1'){
        /*
        insert into tbname (username,password,email) vallues ('xxxxx','xx')
        //把所有的键名用','连接起来
        //implode(',',array_keys($arr));
        //implode("','",array_values($arr));
        */
        if(!is_array($arr)){
            return false;
        }

        if($mode == 'update'){
            $sql = 'update '.$table.' set ';
            foreach ($arr as $key=>$value) {
                $sql .= $key."='".$value."',";
            }
            $sql = rtrim($sql,',');
            $sql .= $where;
            return $this->query($sql);
        }

        $sql = 'insert into '.$table.'('.implode(',',array_keys($arr)).')';
        $sql .= ' values(\'';
        $sql .= implode("','",array_values($arr));
        $sql .= '\')';

        return $this->query($sql);
    }

    public function getAll($sql){
        $rsql = $this->query($sql);
        $list = array();
        if($rsql){
            while($row=mysqli_fetch_assoc($rsql)){
                $list[] = $row;
            }
        }
        return $list;
    }

    public function getRow($sql){
        $rsql = $this->query($sql);
        return mysqli_fetch_assoc($rsql);
    }

    public function getOne($sql){
        $rsql = $this->query($sql);
        $row = mysqli_fetch_row($rsql);
        return $row[0];
    }

    //返回影响行数的函数
    public function affected_rows(){
        return mysqli_affected_rows($this->conn);
    }

    //返回最新的auto_increment列的自增长的值
    public function insert_id(){
        return mysqli_insert_id($this->conn);
    }

    //******zhl///
    public function getFiled($table)
    {
        $sql="desc ".$table;
        $result = $this->query($sql);
        return $result;
    }
    public function itemRows($res)
    {
        return mysql_num_rows($res);
    }
    

}


 ?>