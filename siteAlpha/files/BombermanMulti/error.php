<?php
if(isset($_GET['error'])) {
    if ($_GET['error'] == "507") {
        echo "error" . $_GET['error'];
    }
    
    if ($_GET['error'] == "550") {
        echo "error" . $_GET['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

</body>
</html>