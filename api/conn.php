<?php

try
{
    $pdo = new PDO( 'mysql:host=localhost;dbname=vspn', 'h5', '58137161' );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->query( 'set names utf8' );
}
catch(PDOException $ex) 
{
    $res = array ('code'=>9006,'PDOException'=> $ex->getMessage(),'time'=>time() );

    exit( $back . json_encode($res) . ')' );
}


// //返回select记录
// function fnSqlQuery($sql, $parameters = null) 
// {
//     global $pdo;
//     $stmt = $pdo->prepare($sql);
//     $stmt->execute($parameters);
//     $rs = $stmt->fetchAll();
//     $stmt = null;
//     return $rs;
// }

// //执行一条更新语句.insert / upadate / delete
// function fnSqlExec($sql, $parameters = null) 
// {
//     global $pdo;
//     $affectedRows = $pdo->exec($sql);
//     return $affectedRows;
// }