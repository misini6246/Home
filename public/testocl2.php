<?php
header("content-type:text/html;charset=gbk");
$tns = "  
(DESCRIPTION =
    (ADDRESS_LIST =
      (ADDRESS = (PROTOCOL = TCP)(HOST = 183.230.3.128)(PORT = 9001))
    )
    (CONNECT_DATA =
      (SERVICE_NAME = jy12g)
    )
  )
       ";
	
$db_username = "HZJK";
$db_password = "hzjk";
try{
    //$conn = new PDO("oci:dbname=".$tns,$db_username,$db_password);
	$conn = new PDO('oci:dbname=//183.230.3.128:9001/jy12g;charset=gbk',$db_username,$db_password);

    $sth = $conn->prepare('SELECT * FROM (SELECT "NAVICAT_TABLE".*, ROWNUM "NAVICAT_ROWNUM" FROM (SELECT "HZJK"."SPZL".*, ROWID "NAVICAT_ROWID" FROM "HZJK"."SPZL") "NAVICAT_TABLE" WHERE ROWNUM <= 1000) WHERE "NAVICAT_ROWNUM" > 0');
    $sth->execute();

    $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
	foreach($result as $key => $value) {
		
		$goodsname = $value['GOODSNAME'] ;
		echo $goodsname ;
	}
    var_dump($result);
}catch(PDOException $e){

    echo ($e->getMessage());
}
