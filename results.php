<?php
include('header.php');
$allowedExts = array("txt", "log");
@$extension = end(explode(".", $_FILES["fileinput"]["name"]));
if ((($_FILES["fileinput"]["type"] == "text/plain") || ($_FILES["fileinput"]["type"] == "text/html")) && ($_FILES["fileinput"]["size"] < 20000) && in_array($extension, $allowedExts)){
	if($_FILES["fileinput"]["error"]>0){
		echo "Type: " . $_FILES["file"]["type"] . "<br />";
		echo "File Upload Error: ".$_FILES['fileinput']['error']."<br>";
	}
	else{
		//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		//echo "Type: " . $_FILES["file"]["type"] . "<br />";
		//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		//echo "Stored in: " . $_FILES["file"]["tmp_name"];
		$tempfile = $_FILES["fileinput"]["tmp_name"];
		echo "<div class='container'>";
		echo "<br><h2>/etc/passwd File Analysis</h2><br>";
		$file=fopen($tempfile,"r") or exit("Unable to open file!");
?>

<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>Username</th>
			<th>Password</th>
			<th>User ID</th>
			<th>Group ID</th>
			<th>Description</th>
			<th>Home Folder</th>
			<th>Default Shell</th>
		</tr>
	</thead>
<?php
//root:x:0:0:root:/root:/bin/bash
		$uid0=array();
		$gid0=array(); 
		while(!feof($file)){
			//echo fgets($file). "<br />";
			$line = fgets($file);
			$passwd = explode(":", $line);
			$shell = strpos($passwd[6],'sh');
			
			if($shell == 0){
				echo '<tr><td>'.$passwd[0].'</td><td>'.$passwd[1].'</td><td>'.$passwd[2].'</td><td>'.$passwd[3].'</td><td>'.$passwd[4].'</td><td>'.$passwd[5].'</td><td>'.$passwd[6].'</td></tr>';
			}
			else{
				echo '<tr class="danger"><td>'.$passwd[0].'</td><td>'.$passwd[1].'</td><td>'.$passwd[2].'</td><td>'.$passwd[3].'</td><td>'.$passwd[4].'</td><td>'.$passwd[5].'</td><td>'.$passwd[6].'</td></tr>';
			}
			if($passwd[2]=='0'){
				array_push($uid0, $passwd[0]);
			}
			if($passwd[3]=='0'){
				array_push($gid0, $passwd[0]);
			}		
		}
		echo '</table>';
		fclose($file);
	}
	
	//Users with UID = 0
	$arr_length = count($uid0,0);
	echo "<br><br>";
	echo "<div class='row'>";
	echo "<div class='col-md-3'>";
	echo "<table class='table table-bordered table-hover table-striped'><thead><tr><th>Users with UID=0</th></tr></thead>";
	for($index=0;$index<$arr_length;$index++){
		echo "<tr><td align='center'>".$uid0[$index]."</td></tr>";
	}
	echo "</table>";
	echo "</div>";
	//Users with GID = 0
	echo "<div class='col-md-3'>";
	$arr_length = count($gid0,0);
	#echo "<br><br>";
	echo "<table class='table table-bordered table-hover table-striped'><thead><tr><th>Users with GID=0</th></tr></thead>";
	for($index=0;$index<$arr_length;$index++){
		echo "<tr><td align='center'>".$gid0[$index]."</td></tr>";
	}
	echo "</table>";
	echo "</div>";
	echo "</div>";
	
}
else {
		echo "File Upload Error: Improper File Type";
}
include('footer.php')
?>

