<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>cems</title>
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
        
    </head>
    <body>
    <?php require 'utils/header.php'; ?>
    <div class ="content"><!--body content holder-->
            <div class = "container">
                <div class ="col-md-6 col-md-offset-3">
    <form method="POST">

   
        <label>Student USN:</label><br>
        <input type="text" name="usn" class="form-control" required><br><br>

        <label>Student Name:</label><br>
        <input type="text" name="name" class="form-control" required><br><br>

        <label>Branch:</label><br>
        <input type="text" name="branch" class="form-control" required><br><br>

        <label>Semester:</label><br>
        <input type="text" name="sem" class="form-control" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email"  class="form-control" required ><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"  class="form-control" required><br><br>

        <label>College:</label><br>
        <input type="text" name="college"  class="form-control" required><br><br>

        <button type="submit" name="update" required>Submit</button><br><br>
        <a href="usn.php" ><u>Already registered ?</u></a>

    </div>
    </div>
    </div>
    </form>
    

    <?php require 'utils/footer.php'; ?>
    </body>
</html>

<?php

    if (isset($_POST["update"]))
    {
        $usn=$_POST["usn"];
        $name=$_POST["name"];
        $branch=$_POST["branch"];
        $sem=$_POST["sem"];
        $email=$_POST["email"];
        $phone=$_POST["phone"];
        $college=$_POST["college"];

        // Regular expressions for validation
        $phone_pattern = "/^\d{10}$/"; // Matches 10 digits
        $email_pattern = "/^\w+([\.-]?\w+)*@gmail\.com$/"; // Matches email with @gmail.com domain

        if(preg_match($phone_pattern, $phone) && preg_match($email_pattern, $email))
        {
            include 'classes/db1.php';     

            // Prepare statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM participent WHERE usn = ?");
            $stmt->bind_param("s", $usn);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows == 0) {
                $stmt = $conn->prepare("INSERT INTO participent (usn,name,branch,sem,email,phone,college) VALUES(?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssss", $usn, $name, $branch, $sem, $email, $phone, $college);

                if($stmt->execute()){
                    echo "<script>
                    alert('Registered Successfully!');
                    window.location.href='usn.php';
                    </script>";
                }
                else {
                    echo"<script>
                    alert('Failed to register!');
                    window.location.href='usn.php';
                    </script>";
                }
            }
            else {
                echo"<script>
                alert('Already registered this USN');
                window.location.href='usn.php';
                </script>";
            }

            $stmt->close();
            $conn->close();
            
        }
        else {
            echo"<script>
            alert('Phone number should be 10 digits and Email should be a valid Gmail address');
            window.location.href='register.php';
            </script>";
        }
    }
    
?>
