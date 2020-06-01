<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $bno=$_POST['bno'];
       // $content=$_POST['content'];
       // $b_name=$_POST['b_name'];
        $email=$_POST['email'];
       // $user_name=$_POST['user_name'];


        if((!isset($errMSG))&($email!=""))
        {
            try{
                $stmt = $con->prepare('INSERT INTO board_like(bno,email) VALUES(:bno, :email)');
                $stmt->bindParam(':email', $email);
                //$stmt->bindParam(':b_name', $b_name);
                //$stmt->bindParam(':content', $content);
                $stmt->bindParam(':bno', $bno);
                //$stmt->bindParam(':user_name', $user_name);


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
                bno: <input type = "text" name = "bno" />
                id: <input type = "text" name = "email" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>

