<?php
    include_once 'pdo1.php';
    $pdo = connect();
    // $country1 = 'Brazil';
    // $country2 = 'Belarus';
    // $country3 = 'Canada';
    // $ps1 = $pdo->prepare("insert into countries(country) values('$country1')"); // simple query
    // $ps1->execute();
    // $ps2 = $pdo->prepare('insert into countries(country) values(?)');   // noname query
    // $ps2->bindParam(1, $country2);
    // $ps2->execute();
    // $ps3 = $pdo->prepare('insert into countries(country) values(:country)');  // named query
    // $ps3->execute(['country'=>$country3]);
    $ps4 = $pdo->prepare('select * from countries');
    $ps4->execute();
    $ps4->setFetchMode(PDO::FETCH_OBJ);
    while ($row = $ps4->fetch())
    {
        echo 'id = '.$row->id.' ,country = '.$row->country.'<br>';
    }
?>