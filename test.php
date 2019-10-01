<?php

function e($e) {
    if (!$e) {
        $e = oci_error();
        var_dump($e);
        exit;
    }
}

$conn = oci_connect('othergkn', 'othergkn', '192.168.0.103:1521/orcl');
e($conn);

// drop table
$stid = oci_parse($conn, 'DROP TABLE TEST');
e($stid);
$r = oci_execute($stid);
e($r);

// create
$stid = oci_parse($conn, 'CREATE TABLE TEST(A VARCHAR2(4000) NOT NULL, B VARCHAR2(4000) NOT NULL, C VARCHAR2(4000) NOT NULL)');
e($stid);
$r = oci_execute($stid);
e($r);

// insert
$stid = oci_parse($conn, 'INSERT INTO TEST (A, B, C) VALUES(:a, :b, :c)');
e($stid);
$a = 1;
$b = 2;
$c = 3;
oci_bind_by_name($stid, ':a', $a);
oci_bind_by_name($stid, ':b', $b);
oci_bind_by_name($stid, ':c', $c);
$r = oci_execute($stid);  // executes and commits
e($r);

// select
$stid = oci_parse($conn, 'SELECT * FROM TEST');
e($stid);
$r = oci_execute($stid);  // executes and commits
e($r);
$data = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS);
var_dump($data);