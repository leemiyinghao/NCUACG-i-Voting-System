<?php
class DBLIST{
    var $list = Array();
    function contain($str){
        $result = FALSE;
        foreach($this->list as $value){
            if($value == $str){
                $result = TRUE;
                break;
            }
        }
        return $result;
    }
    function push($str){
        array_push($this->list,str_replace("\n","",$str));
    }
}
class DBVALUELIST{
    var $list;
    function pushRaw($str){
        $tmp = split("%",str_replace("\n","",$str));
        if($tmp[0]!=NULL){
            $this->list[$tmp[0]] = array($tmp[1]?$tmp[1]:0,$tmp[2]?$tmp[2]:0);
        }
    }
    function pushValue($key,$type){
        if(!empty($this->list[$key]))
            $this -> list[$key][$type?0:1] = $this -> list[$key][$type?0:1] + 1;
    }
}
$votableListFile = fopen("votable.db","r");
$votedListFile = fopen("voted.db","r");
$countListFile = fopen("count.db","r");
$db_votableList = new DBLIST;
$db_votedList = new DBLIST;
$db_countList = new DBVALUELIST;
while($buffer=fgets($votableListFile)){
    $db_votableList -> push($buffer);
}
fclose($votableListFile);
while($buffer=fgets($votedListFile)){
    $db_votedList -> push($buffer);
}
fclose($votedListFile);
while($buffer=fgets($countListFile)){
    $db_countList -> pushRaw($buffer);
}
fclose($countListFile);
?>