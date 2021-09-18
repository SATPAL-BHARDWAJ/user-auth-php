<?php

	if(isset($_POST['email'])){
    	$conn = $pdo->open();

		$email = $_POST['email'];
		$password = $_POST['password'];
		
		if ( '' === trim($email) || '' === trim($password) ) {
			$_SESSION['error'] = 'Credentials missing!';
			redirect('\login');
		}
		
		try{

			$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users WHERE email = :email");
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch();
            
			if($row['numrows'] > 0){
				
				if(password_verify($password, $row['password'])){
					$_SESSION['user'] = $row['id'];
					$now = date('Y-m-d H:i:s');

					$stmt = $conn->prepare("UPDATE users SET updated_at=:updated_at WHERE id=:id");
                	$stmt->execute(['updated_at' => $now, 'id' => $row['id']]);

					redirect('\\');
				}
				else{
					$_SESSION['error'] = 'Incorrect Password';
				}
				
				
			}
			else{
				$_SESSION['error'] = 'Email not found';
			}
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

	}
	else{
		$_SESSION['error'] = 'Input login credentails first';
	}

	$pdo->close();

	redirect('\login');
