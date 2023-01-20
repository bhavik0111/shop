<?php
include('header.php');
$require="";
if(isset($_POST['submit'])){
    $usr_email=$_POST['usr_email'];
    $usr_pass=$_POST['usr_pass'];
   if ($_POST['usr_email']!='' && $_POST['usr_pass']!=''){
    if(isset($_POST['usr_email']))
    {
    $qry = "SELECT * FROM user_master WHERE usr_email='".$usr_email."' AND usr_pass='".$usr_pass."' AND usr_status=1 "; 
    $reslogin=mysqli_query($conn,$qry);
    $row=mysqli_fetch_array($reslogin);
    if(is_array($row)) 
    {
        $_SESSION["usr_email"] =$row['usr_email'];
        $_SESSION["usr_id"] = $row['usr_id'];
        $_SESSION["usr_name"] = $row['usr_name'];
        $_SESSION["usr_role"] = $row['usr_role'];
        if(isset($_SESSION["usr_role"]) && isset($_SESSION["usr_email"])){
            if($_SESSION["usr_role"]==1){
                header("Location:".SITE_URL."admin");
                exit; 
             }
            else {
             header("Location:".SITE_URL."index.php");
             exit;
            }
          } else{
                header("Location:".SITE_URL."index.php");
                exit;
          } 
    }
    else{
        $require="Please Enter Valid email and password ";
    }
    }
    }
    else{
        $require= "Please enter data";
    }
}
?>
<div class="form">
<center><h1>Login</h1></center>
<form method="post" action=""  ><center>
        <table>
            <tr><td colspan="2" style="color: red;"><?php echo $require ;?></td></tr>
            <tr>
                <td><label>Email</label></td>
                <td><input type="text" name="usr_email" id="usr_email"></td>
            </tr>
            <tr>
                <td><label>Password</label></td>
                <td><input name="usr_pass" type="password" id="usr_pass"></input></td>
            </tr>
            <tr>
               <td colspan="2"> <center><input type="submit" name="submit" value="submit"/>
               <input type="reset" value="Reset"/></center></td>
            </tr>
        </table>
</center>
</form>
</div><br/><br/>
<?php include('footer.php');?>
