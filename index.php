<?php
	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

	$app->get('/users/:id', 'getUser'); 

	$app->run();

	function getUser($id) {
	    $sql = "SELECT * FROM user WHERE id=:id";
	    try {
		        $dbCon = getConnection();
		        $stmt = $dbCon->prepare($sql);
		        $stmt->bindParam("id", $id);
		        $stmt->execute();
		        $user = $stmt->fetchObject();  
		        $dbCon = null;
		        echo json_encode($user); 
	    } catch(PDOException $e) {
	        echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	    }
	}

	function getConnection() {
	    try {
	        $db_username = "root";
	        $db_password = "123456";
	        $conn = new PDO('mysql:host=localhost;dbname=unity', $db_username, $db_password);
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    } catch(PDOException $e) {
	        echo 'ERROR: ' . $e->getMessage();
	    }
	    return $conn;
	}
?>