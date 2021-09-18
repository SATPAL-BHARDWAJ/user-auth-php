<?php

if( !function_exists('url') ) {
    function url( $url = null, $parameter = [] ) {
        echo BASE_PATH."{$url}";
    }
}

if( !function_exists('layout') ) {
    function layout( $file ) {
        include_once "./resources/layouts/{$file}.php";
    }
}

if( !function_exists('redirect') ) {
    function redirect( $path ) {
        header('location: '.BASE_PATH.$path);
    
        exit();
    }
}

if( !function_exists('session') ) {
    function session( $key, $value = null ) {
        if ( $value ) {
            $_SESSION[$key] = $value;
        }
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
}

if( !function_exists('hasSession') ) {
    function hasSession( $key ) {
        $keys = is_array($key) ? $key : array($key);

        $exist = false;
        foreach($keys as $k) {
            if(isset($_SESSION[$k])) {
                $exist = true;
            }
        }

        return $exist;
    }
}


if( !function_exists('removeSession') ) {
    function removeSession( $key ) {
        $keys = is_array($key) ? $key : array($key);
     
        foreach($keys as $k) {
            if(isset($_SESSION[$k])) {
                try {
                    unset($_SESSION[$k]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                
            }
        }
    }
}

if( !function_exists('dd') ) { 
    function dd( ...$data ) {

        if ( is_array($data) ) {
            echo '<pre>';
            print_r($data);
            echo '</pre>';
        } else {
            var_dump($data);
        }
        
        die;
    }
}

if( !function_exists('formError') ) {
    function formError( $key ) {
        if ( isset($_SESSION['errorsBag']) && isset($_SESSION['errorsBag'][$key]) ) {
            $error = $_SESSION['errorsBag'][$key];
            unset($_SESSION['errorsBag'][$key]);
            return $error;
        }
    }
}

if( !function_exists('hasFormError') ) {
    function hasFormError( $key ) {
        if ( isset($_SESSION['errorsBag']) && isset($_SESSION['errorsBag'][$key]) ) {
            return true;
        }

        return false;
    }
}

if( !function_exists('setErrorsBag') ) {
    function setErrorsBag( $key, $value ) {
        $_SESSION['errorsBag'][$key] = $value;
    }
}

if( !function_exists('hasErrorBag') ) {
    function hasErrorBag() {
        return isset($_SESSION['errorsBag']) && count($_SESSION['errorsBag']) > 0;
    }
}

if( !function_exists('showFormError') ) {
    function showFormError($key) {
        if (hasFormError( $key )) {
            $error = formError( $key );
            echo "<span class='text-white'>*{$error}</span>";
        };
    }
}

if( !function_exists('resetErrorBag') ) {
    function resetErrorBag() {
        if( isset($_SESSION['errorsBag']) ) {
            unset($_SESSION['errorsBag']);
        }
    }
}

if ( !function_exists('setUser') ) {
    function setUser($id) {
        $pdo = new Database();
        $conn = $pdo->open();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        $user = $stmt->fetch();
        return $user;
    }
}


