<?php
require_once("models/config.php");
$id = $loggedInUser->user_id;
$api_select = mysql_query("SELECT * FROM userCake_Users WHERE `User_Id`='$id'");
while($row = mysql_fetch_assoc($api_select)) {
	if($row["api_key"] !== null) {
		echo '<h3>Your Api Key is:</h3><br/>';
		echo $row["api_key"];
	}else{
		$user = $row["Username"];
		$pass = $row["Password"];
		$length = 128;
		$time = date("F j, Y, g:i a");
		$salt1 = $time . hash('sha512', (sha1 .$time));
		$salt2 = substr(md5(uniqid(rand(), true)), 0, 25);
		$salt3 = substr(md5(uniqid(rand(), true)), 0, 25);
		$salt4 = hash('sha256', (md5 .$time));
		$user_hash = hash('sha512', ($salt2 . $user . $salt1));
		$pass_hash = hash('sha512', ($salt1 . $pass . $salt2));
		$keyhash_a = hash('sha512', ($user_hash . $salt3));
		$keyhash_b = hash('sha512', ($pass_hash . $salt4));
		$hash_a = str_split($keyhash_a);
		$hash_b = str_split($keyhash_b);
		foreach($hash_a as $key => $value) {
			$hashed_a[] = $salt2 . hash('sha512', ($salt3 . $value)) . $salt1 . hash('sha256', ($salt4 . $key));
		}
		foreach($hash_a as $key => $value) {
			$hashed_b[] = $salt2 . hash('sha512', ($salt3 . $value)) . $salt1 . hash('sha256', ($salt4 . $key));
		}
		$hash_merge = array_merge($hashed_b, $hashed_a);
		$from_merge = implode($hash_merge);
		$exploded_2 = str_split($from_merge);
		$key_hash_last = implode($exploded_2);
		$key0 = str_shuffle($key_hash_last);
		$key1 = str_split($key0);
		$key2 = array_unique($key1);
		$key3 = implode($key2);
		$key4 = str_shuffle($key3);
		$key5 = str_shuffle($key4);
		$api_key0 = str_shuffle($key3.$key4.$key5.$key2);
		$api_key_prepped = mysql_real_escape_string($api_key0);
		$api_check_no_collision = mysql_query("SELECT * FROM userCake_Users WHERE `api_key` = '$api_key_prepped'"); //check to see if an identical key exists
		if(mysql_num_rows($api_check_no_collision) > 0) {
			echo '<meta http-equiv="refresh" content="0; URL=index.php?page=api">';//an identical key exists in the database, refresh the page and generate a new key.
		}else{
		$api_insert = mysql_query("UPDATE  `testing`.`userCake_Users` SET  `api_key` =  '$api_key_prepped' WHERE  `userCake_Users`.`User_ID` ='$id';"); //the key is unique, submit it to the database.
		echo '<meta http-equiv="refresh" content="0; URL=index.php?page=api">';
		}
	}
}
?>