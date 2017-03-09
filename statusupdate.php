 <?php 

include('config.php');
include(shinclude.'html1.php');

global $dba_close;
$query="SELECT * FROM users WHERE level!='disabled' AND location='internal' AND status!= '0'";
echo '<table border="1">'."\n";
$users=$db->get_results($query);
$time = time();
$timestamp = idate("H", $time);
echo $timestamp; //We work with integer hours, without minutes and seconds
foreach ($users as $user)
{
	if (($user->status == "1") || ($user->status == "3") || ($user->status == "4"))
	{
			if (($timestamp >= 0) && ($timestamp <= 6))
			{
			echo "<tr><td>".$user->id."</td><td>".$user->name."</td><td>".$user->surname."</td><td>".$user->status."</td><td>"."Change status\n</td><tr>";
			/*
			$query_update_status = "UPDATE users SET status = 2 WHERE status in (1,3,4)";
			$update_status = $db->get_results($query_update_status);*/
			}
			else
			{
				echo "<tr><td>".$user->id."</td><td>".$user->name."</td><td>".$user->surname."</td><td>".$user->status."</td><td>"."No status change\n</td><tr>";
			}
	}
	else
	{
		echo "<tr><td>".$user->id."</td><td>".$user->name."</td><td>".$user->surname."</td><td>".$user->status."</td><td>"."No status change\n</td><tr>";
	}
}
echo '</table>'."\n";


   
?>