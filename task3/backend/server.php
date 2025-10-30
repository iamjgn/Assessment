<?php
$fname = $mname = $lname = $email = $pass = $phone = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (empty($_POST["fname"])) 
	{
		echo "First name is required.<br>";
    } 
	else 
	{
		$fname = test_input($_POST["fname"]);
		if (!preg_match("/^[a-zA-Z]+$/",$fname)) 
		{
			echo "Only alphabets allowed in first name.<br>";
			$fname = "";
		}
    }
	if (!empty($_POST["mname"]))
	{
		 $mname = test_input($_POST["mname"]);
	}
	if (empty($_POST["lname"])) 
	{
		echo "Last name is required.<br>";
    } 
	else 
	{
		$lname = test_input($_POST["lname"]);
		if (!preg_match("/^[a-zA-Z]+$/",$lname)) 
		{
			echo "Only alphabets allowed in last name.<br>";
			$lname = "";
		}
    }
	if (empty($_POST["email"])) 
	{
		echo "Email is required.<br>";
    } 
	else 
	{
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
		{
			echo "Invalid email format.<br>";
			$email = "";
		}
    }
	if (empty($_POST["password"])) 
	{
		echo "Password is required.<br>";
    } 
	else 
	{
		$pass = trim($_POST["password"]);
    }
	if (empty($_POST["phone"])) 
	{
		echo "Phone no. is required.<br>";
    } 
	else 
	{
		$phone = test_input($_POST["phone"]);
		if (!preg_match("/^\d{10}$/",$phone)) 
		{
			echo "Only numbers allowed as phone number.<br>";
			$phone = "";
		}
    }
}
function test_input($data) 
{
	$data = str_replace(" ", "", $data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($fname && $lname && $email && $pass && $phone)
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$hash = password_hash($pass,PASSWORD_DEFAULT);
	$conn = new mysqli($servername,$username,$password);
	if ($conn->connect_error) 
	{
		die("Connection failed: ".$conn->connect_error);
	}
	else
	{
		echo "Connection successful<br>";
	}
	$dbName = "Mydatabase";
	$sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
	if ($conn->query($sql) === TRUE) 
	{
		echo "Database created or already exists<br>";
		$conn->select_db($dbName);
	} 
	else 
	{
		echo "Error creating database: ".$conn->error;
	}
	$tableName = "mytable";
	$sql = "CREATE TABLE IF NOT EXISTS `$tableName`
	(
		id INT AUTO_INCREMENT PRIMARY KEY,
		firstname VARCHAR(50) NOT NULL,
		middlename VARCHAR(50),
		lastname VARCHAR(50) NOT NULL,
		email VARCHAR(100) NOT NULL,
		hashpass VARCHAR(255) NOT NULL,
		phone VARCHAR(10) NOT NULL
	)";
	if (mysqli_query($conn,$sql)) 
	{
		echo "Table created or already exists<br>";
	} 
	else 
	{
		echo "Error creating table: ".mysqli_error($conn);
	}
	$stmt = $conn->prepare("INSERT INTO $tableName (firstname, middlename, lastname, email, hashpass, phone) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", $fname, $mname, $lname, $email, $hash, $phone);
	if ($stmt->execute()) 
	{
		echo "New record created successfully";
	} 
	else 
	{
		echo "Error creating new record: " . $stmt->error;
	}
	$stmt->close();
}
$conn->close();
?>