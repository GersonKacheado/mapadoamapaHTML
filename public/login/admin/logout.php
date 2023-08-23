<?php
	if (isset($_SESSION))   	
	   session_destroy();
	if(isset($_GET)) {
       unset($_GET);
       echo "<script>location.href='../../../public/login/index.php'</script>";
    }
    exit;
?>

