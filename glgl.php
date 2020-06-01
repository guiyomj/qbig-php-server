 <?php  
error_reporting(E_ALL); 
ini_set('display_errors',1); 

include('dbcon.php');



//POST 값을 읽어온다.
$exam=isset($_POST['no']) ? $_POST['no'] : '';
$dust=isset($_POST['dust']) ? $_POST['dust'] :'';
$no2=isset($_POST['no2']) ? $_POST['no2'] :'';
$o3=isset($_POST['o3']) ? $_POST['o3'] :'';
$co=isset($_POST['co']) ? $_POST['co'] :'';
$so2=isset($_POST['so2']) ? $_POST['so2'] :'';
$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


if (1==1){ 

    $sql="select distinct * from receive order by no";
    $stmt = $con->prepare($sql);
    $stmt->execute();
 
    if ($stmt->rowCount() == 0){

        echo "'";
        echo $no,", ";
        echo "'은 찾을 수 없습니다.";
    }
	else{

   		$data = array(); 

        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){

        	extract($row);
		//$row_s["no"]=$row["no"];
		$row_s["dust"]=$row["dust"];
		$row_s["no2"]=$row["no2"];
		$row_s["o3"]=$row["o3"];
		$row_s["co"]=$row["co"];
		$row_s["so2"]=$row["so2"];
		//$row_ss[$row["no"]]=$rows_s
            array_push($data,
               array((int)$row["dust"], (int)$row["no2"], (int)$row["o3"], (int)$row["co"], (int)$row["so2"]));
        }


        if (!$android) {
            //echo "<pre>"; 
            print_r(json_encode($data)); 
            //echo '</pre>';
        }else
        {
            header('Content-Type: application/json; charset=utf8');
            $json = json_encode(array("webnautes"=>$data), JSON_PRETTY_PRINT+JSON_UNESCAPED_UNICODE);
            echo $json;
        }
    }
}
else {
    echo "검색하세요 ";
}

?>



<?php

$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");

if ($android){
?>

<html>
   <body>
   

   
   </body>
</html>
<?php
}

   
?>

