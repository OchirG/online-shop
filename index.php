<?php
$conn = pg_connect("host=postgres dbname=mydb user=user password=pass");
if ($conn) {
    echo "Connected to PostgreSQL successfully!";
} else {
    echo "Connection failed.";
}
?>

