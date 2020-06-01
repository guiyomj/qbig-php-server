<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $title=$_POST['title'];
        $content=$_POST['content'];
        $b_name=$_POST['b_name'];
        $email=$_POST['email'];
        $user_name=$_POST['user_name'];


        if((!isset($errMSG))&($email!="")&($user_name!=""))
        {
            try{
                $stmt = $con->prepare('INSERT INTO board(b_name,title,content,email,user_name) VALUES(:b_name, :title, :content, :email, :user_name)');
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':b_name', $b_name);
                $stmt->bindParam(':content', $content);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':user_name', $user_name);


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
                title: <input type = "text" name = "title" />
                content: <input type = "text" name = "content" />
                id: <input type = "text" name = "email" />
                board: <input type = "text" name = "b_name" />
                name: <input type = "text" name = "user_name" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>

