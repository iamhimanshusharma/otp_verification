<!-- In this source code, the api is used of fast2sms.com -->
<!-- the link is https://www.fast2sms.com/ -->
<!-- To access fast access you can change on comment followed areas -->
<!-- After setup enter your mobile number and submit it
will send otp to your mobile, enter otp in below box and press
verify it will results accordingly -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP</title>
</head>
<body>
<form action="" method="post">
<table>
    <tr><td><input type="tel" pattern=[0-9]{10} name="number"></td></tr>
    <tr><td><input type="submit" name="verify" value="Submit"></td></tr>
</table>
</form>
<form action="" method="post">
<table>
    <tr><td><input type="tel" pattern=[0-9]{5} name="otp"></td></tr>
    <tr><td><input type="submit" name="overify" value="Verify"></td></tr>
</table>
</form>
</body>
</html>
<?php
if(isset($_POST['verify']))
{
    $otp=rand(10000,20000); //otp will be between 10000 to 20000
$field = array(
    "sender_id" => "selected_by_user", //sender id will be selected on providers site
    "language" => "english",
    "route" => "qt",
    "numbers" => $_POST['number'],
    "message" => "message_id", //provided by provider
    "variables" => "selected_after_verification",//variables used in message
    "variables_values" => $otp,
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.fast2sms.com/dev/bulk",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode($field),
  CURLOPT_HTTPHEADER => array(
    "authorization: authorization_key", //authorization key provided by provider
    "cache-control: no-cache",
    "accept: */*",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
//   echo "cURL Error #:" . $err; //to get error
echo "Something is wrong...";
} else {
//   echo $response; //to get server response
setcookie('otp',$otp); //setting cookie of otp
echo "Send";
}
}
if(isset($_POST['overify']))
{
    $otp=$_POST['otp'];
    if($_COOKIE['otp']==$otp) //comparing otp with setcookie
    {
        ?>
        <script>
        alert("Mobile number verified...");
        window.open('verify.php','_self'); //After verification it will redirect to verify.php page...
        </script>
        <?php
    }
    else
    {
        ?>
        <script>
        alert("Wrong OTP entered... Try Again!");
        window.open('otp.php','_self'); //if otp is entered wrong then it redirect to the same page of otp...
        </script>
        <?php  
    }
}
// Quick Transactional Route Success Response:
// {
//     "return": true,
//     "request_id": "drhgp7cjyqxvfe9",
//     "message": [
//         "Message sent successfully"
//     ]
// }
?>