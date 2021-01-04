<?php
session_start();
include ('./includes_css/header.html');
?>
<html>
    <head>
        <title> encrypt file </title>
    </head>
    <body>
    <div id="site_content" align="center">
    <style>
    input[type=submit] {
        width: 30%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    </style>
    
        <form action="main.php" method="post" enctype="multipart/form-data">
            <input type="file" name="fileName"><br><br>
            <input type="submit" name="encrypt" value="encrypt">
	    <input type="submit" name="decrypt" value="decrypt">
        </form>
        
    </body>



<?php
define('FILE_ENCRYPTION_BLOCKS', 10000);
if(isset($_POST['encrypt']))
{
	$source = $_FILES['fileName']['name'];
 	if(isset($source))
	{
        	if(!empty($source))
        	{
		$key = $_SESSION['pass'];
		encryptFile($source, $key, $source.'.enc');
		unlink($source);
		$fn = $source.'.enc';
		chmod($fn,0000);
		echo "<h2>success</h2>";
		}
	}
}
if(isset($_POST['decrypt']))
{
	$source = $_FILES['fileName']['name'];
 	if(isset($source))
	{
        	if(!empty($source))
        	{
		$key = $_SESSION['pass'];
		$new_filename = substr($source, 0, -4);
		decryptFile($source, $key, $new_filename);
		chmod($source,0755);
		unlink($source);
		echo "<h2>success</h2>";		
		}
	}
}
	    
function encryptFile($source, $key, $dest)
{
    $key = substr(sha1($key, true), 0, 16);
    $iv = openssl_random_pseudo_bytes(16);

    $error = false;
    if ($fpOut = fopen($dest, 'w')) {
        // Put the initialzation vector to the beginning of the file
        fwrite($fpOut, $iv);
        if ($fpIn = fopen($source, 'rb')) {
            while (!feof($fpIn)) {
                $plaintext = fread($fpIn, 16 * FILE_ENCRYPTION_BLOCKS);
                $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                // Use the first 16 bytes of the ciphertext as the next initialization vector
                $iv = substr($ciphertext, 0, 16);
                fwrite($fpOut, $ciphertext);
            }
            fclose($fpIn);
        } else {
            $error = true;
        }
        fclose($fpOut);
    } else {
        $error = true;
    }

    return $error ? false : $dest;
}

function decryptFile($source, $key, $dest)
{
    $key = substr(sha1($key, true), 0, 16);

    $error = false;
    if ($fpOut = fopen($dest, 'w')) {
        if ($fpIn = fopen($source, 'rb')) {
            // Get the initialzation vector from the beginning of the file
            $iv = fread($fpIn, 16);
            while (!feof($fpIn)) {
                // we have to read one block more for decrypting than for encrypting
                $ciphertext = fread($fpIn, 16 * (FILE_ENCRYPTION_BLOCKS + 1)); 
                $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
                // Use the first 16 bytes of the ciphertext as the next initialization vector
                $iv = substr($ciphertext, 0, 16);
                fwrite($fpOut, $plaintext);
            }
            fclose($fpIn);
        } else {
            $error = true;
        }
        fclose($fpOut);
    } else {
        $error = true;
    }

    return $error ? false : $dest;
}	    
?>
</div>
</html>
<?php
include ('./includes_css/footer.html');
?> 