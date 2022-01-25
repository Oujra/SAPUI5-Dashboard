<?php

try {
        $connection = new PDO('odbc:Driver=HDBODBC;ServerNode=192.168.102.158:39013;dbname=HXE', 'SYSTEM', 'Trololo72');
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: ".$e->getMessage();
    }

    $query = "SELECT * from UI5DB.Test_Table";

    $stmt = $connection->query($query);

    while($row = $stmt->fetch()) {
        echo $row['TEST'];
    }
   
   