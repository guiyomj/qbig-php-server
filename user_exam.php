<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $email=$_POST['email'];
        $exam=$_POST['exam'];

        if((!isset($errMSG))&($email!=""))
        {
            try{
                $stmt = $con->prepare('UPDATE user set current_test=:exam WHERE email=:email');
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':exam',$exam);

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
		exam: <input type = "text" name = "exam" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>

