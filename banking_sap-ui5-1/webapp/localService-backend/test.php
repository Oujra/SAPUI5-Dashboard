<?php
// Check if the ODBC extension is loaded
if (! extension_loaded('odbc'))
{
    die('ODBC extension not enabled / loaded');
}

/**
 * 2. HANA ODBC Connection
 */

/*
 * You can download the SAP HANA Client, Developer edition from SAP
 * (which includes the needed driver http://scn.sap.com/docs/DOC-31722)
 *
 * HDBODBC32 -> 32 bit ODBC driver that comes with the SAP HANA Client.
 * HDBODBC -> 64 bit ODBC driver that comes with the SAP HANA Client.
 */
$driver = 'HDBODBC';

// Host
// Note: I am hosting it on the Amazon AWS, so my host looks like this. Put whatever your system administrator gave you
$host = "192.168.102.158:39013";

// Default name of your hana instance
$db_name = "SYSTEMDB";

// Username
$username = 'SYSTEM';

// Password
$password = "Trololo72";

$conn = odbc_connect("Driver=$driver;ServerNode=$host;Database=$db_name;", $username, $password, SQL_CUR_USE_ODBC);

if (!$conn)
{
    // Try to get a meaningful error if the connection fails
    echo "Connection failed.\n";
    echo "ODBC error code: " . odbc_error() . ". Message: " . odbc_errormsg();

    /*
     * Typical errors include
     *
     * Error code: S1000
     * General error;416 user is locked; try again later: lock time is 1440
     * Too many unsuccessful login attempts
     * Solution: wait and try again with other credentials
     *
     * Error code: 08S01
     * Communication link failure;-10709 Connection failed (RTE:[89006] Syste, SQL state 08S01 in SQLConnect
     * Solution: check your connection details, host, port.
     */
}else
{
    // Do a basic select from DUMMY with is basically a synonym for SYS.DUMMY
    $sql = 'SELECT * FROM UI5DB.TEST_TABLE';
    $result = odbc_exec($conn, $sql);
    if (!$result)
    {
        echo "Error while sending SQL statement to the database server.\n";
        echo "ODBC error code: " . odbc_error() . ". Message: " . odbc_errormsg();
    }
    else
    {
        while ($row = odbc_fetch_object($result))
        {
            // Should output one row containing the string 'X'
            echo $row->TEST;
        }
    }
    odbc_close($conn);
}