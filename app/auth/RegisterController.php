<?php

if(isset($_POST['email'])){
    signup_validation();
    
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];

    if($password != $repassword){
        setErrorsBag('repassword', 'Passwords did not match');
        redirect('\signup');
    }
    else{
        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM users WHERE email=:email");
        $stmt->execute(['email'=>$email]);
        $row = $stmt->fetch();
        if($row['numrows'] > 0){
            $_SESSION['error'] = 'Email already taken';
            redirect('\signup');
        }
        else{
            $password = password_hash($password, PASSWORD_DEFAULT);

            try{
                $stmt = $conn->prepare("INSERT INTO users (email, password, firstname, lastname) VALUES (:email, :password, :firstname, :lastname)");
                $stmt->execute(['email'=>$email, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname]);
                $userid = $conn->lastInsertId();

                session('user', $userid);

                redirect('\\');
            }
            catch(PDOException $e){
                $_SESSION['error'] = $e->getMessage();
                redirect('\signup');
            }

            $pdo->close();

        }

    }

}
else{
    $_SESSION['error'] = 'Fill up signup form first';
    redirect('\signup');
}

function signup_validation() {
    resetErrorBag();

    $inputs = [
        'firstname',
        'lastname', 
        'email',
        'password',
        'repassword',
    ];

    $messages = [
        'firstname' => 'First name is required',
        'lastname' => 'Last name is required', 
        'email' => 'Email is required',
        'password' => 'Password is required',
        'repassword' => 'Confirm password is required',
    ];
    
    foreach($_POST as $input => $value) {
        if ( in_array($input, $inputs) && !$value ) {
            setErrorsBag($input, $messages[$input]);
        }
    }
    
    if ( hasErrorBag() ) {
        redirect('\signup');
    }
}