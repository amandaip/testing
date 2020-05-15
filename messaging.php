<?php 
//messaging landing page listing list of chats
$page_title = 'Inbox';

include('includes/header.php');
include ('messaging.css'); 
require('mysqli_connect.php'); 
// show message from send/view message process
if (isset($_GET['msg'])) {
	if ($_GET['msg'] == "ok") {
		$msg_feedback = "Your message has been sent.";
	}
}
else {
	$msg_feedback = "";
}
// FROM DENA - check if outbox is selected	
if (isset($_GET['box'])) {
	$box = $_GET['box'];
}
else {
	$box = 'i';
}
//if the message is read, change thread to 1; if the message is unread, change thread to 0 


//view a specific chat between 2 users


//$query = "SELECT * FROM MESSAGE WHERE receiver_id = $user_id";
//show the results stored in database

if ($box == "i") {
	$query = "SELECT U2.first_name, U2.last_name, U2.profile_image, MESSAGE.* FROM MESSAGE, USER as U1, USER as U2 WHERE MESSAGE.receiver_id = U1.user_id AND MESSAGE.sender_id = U2.user_id AND MESSAGE.receiver_id = " . $_SESSION['user_id'];
}
else {
	$query = "SELECT U1.first_name, U1.last_name, U2.profile_image, MESSAGE.* FROM MESSAGE, USER as U1, USER as U2 WHERE MESSAGE.receiver_id = U1.user_id AND MESSAGE.sender_id = U2.user_id AND MESSAGE.sender_id = " . $_SESSION['user_id'];
}

$result = mysqli_query($connection, $query);


echo "<div class='container'>";
if ($msg_feedback != "") {
	echo "<p>Your message has been sent</p>";
}

//INBOX VIEW
if ($box == "i") { // for INBOX VIEW
	echo "<h5><a href='user_home.php'>HOME</a> > MESSAGING</h5>";
	echo "<h2>INBOX | <a href='messaging.php?box=o'>OUTBOX</a> | <a href='send_message.php'>NEW MESSAGE</a></h2>";
	//READ MESSAGE table headings	
echo "
<table class='inbox'>
<thead>
	<td></td>
	<td>SENT BY</td>
	<td>SUBJECT</td>
	<td>DATE</td>";
	//<td>TRASH</td>
echo "</thead>"; 

//READ 
while ($row = mysqli_fetch_assoc($result)) {
	
	$formattedDate = date('M j, Y g:i A', strtotime($row['create_date']));

	echo "
	<tr>
		<td>";
		//<img id='messaging_pic' src='https://www.sackettwaconia.com/wp-content/uploads/default-profile.png' alt='Profile Photo'>
	echo" <img id='messaging_pic' src='" . $row['profile_image'] . "' alt='Profile Photo'>
		</td>
		<td><a href='profile.php?uid=" .$row['sender_id'] . "'>". $row['first_name'] . ' ' . $row['last_name'] ."</a></td>
		<td><a href='message_view.php?id=" . $row['message_id'] . "&box=i'>" . $row['subject'] . "</a></td>
		<td>". $formattedDate . "</td>";
		// <td><a href='message_edit.php?id=" . $row['message_id'] . "' class='link'>delete</a></td>
	echo "</tr>";
	}
echo "</table>"; // close table
echo "</div>";
}
else { // for OUTBOX VIEW
	echo "<h5><a href='user_home.php'>HOME</a> > MESSAGING</h5>";	
	echo "<h2><a href='messaging.php?box=i'>INBOX</a> | OUTBOX | <a href='send_message.php'>NEW MESSAGE</a></h2>";
	//READ MESSAGE table headings
	echo "
	<table class='inbox'>
	<thead>
		<td></td>
		<td>SENT TO</td>
		<td>SUBJECT</td>
		<td>DATE</td>		
	</thead>"; 

	//READ 
	while ($row = mysqli_fetch_assoc($result)) {
		
		$formattedDate = date('M j, Y g:i A', strtotime($row['create_date']));
		
			//<td><a href='profile.php?uid=" .$row['profile_image'] . "</a></td> 
		echo "
		<tr>
		<td>";
		//<img id='messaging_pic' src='https://www.sackettwaconia.com/wp-content/uploads/default-profile.png' alt='Profile Photo'>
	echo" <img id='messaging_pic' src='" . $row['profile_image'] . "' alt='Profile Photo'>
		</td>
			<td><a href='profile.php?uid=" .$row['receiver_id'] . "'>". $row['first_name'] . ' ' . $row['last_name'] ."</a></td>
			<td><a href='message_view.php?id=" . $row['message_id'] . "&box=o'>" . $row['subject'] . "</a></td>
			<td>". $formattedDate . "</td>";
			// <td><a href='message_edit.php?id=" . $row['message_id'] . "' class='link'>delete</a></td>
		echo "</tr>";
		}
	echo "</table>"; // close table
	echo "</div>";
	}


?>

<?php include('includes/footer.php');?>
