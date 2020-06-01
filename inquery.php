<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $email=$_POST['email'];
        $content=$_POST['content'];
	$date=$_POST['date'];
        if((!isset($errMSG))&($email!=""))
        {
            try{
                $stmt = $con->prepare('INSERT INTO inquery(email,content,date) VALUES(:email, :content, :date)');
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':content', $content);
		$stmt->bindParam(':date', $date);

                if($stmt->execute())
                {
                    $successMSG = "추가 완료";
                }
                else
                {
                    $errMSG = "추가 에러";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }

?>


<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;

	$android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");
   
    if( !$android )
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                id: <input type = "text" name = "email" />
                내용: <input type = "text" name = "content" />
		날짜: <input type="text" name="date">
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>

