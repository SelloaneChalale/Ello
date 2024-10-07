<?php
 require_once 'config.php';
  $id = $_GET['id'];

  $uid = $_SESSION['id'];
  $generate= "012345678910111213141516171819202122232425262728290313233343536373839404142434445464748495051525354555657585960616263646566676869707172737475767778798081828384858687888990919293949596979899";
  $idgen=  substr(str_shuffle($generate),0,3); 

$mk ="SELECT * FROM users WHERE id ='$id'";
$res = mysqli_query($conn, $mk);
$network = mysqli_fetch_all($res, MYSQLI_ASSOC);


$emailQuery = "SELECT * FROM network WHERE receiver_id=? AND sender_id=?  LIMIT 1";
$stmt = $conn->prepare($emailQuery);
$stmt->bind_param('ss', $id,$uid);
$stmt->execute();
$result = $stmt->get_result();
$userCount = $result->num_rows;
$stmt->close();

if($userCount > 0){
// echo 'Connection request already made';
header("refresh:0; url=http://localhost/ello-social/friends");
}
else{
    $sql = "DELETE FROM network WHERE sn ='$id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      header("refresh:0; url=http://localhost/ello-social/friends");
      }
    }


