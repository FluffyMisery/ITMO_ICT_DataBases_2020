<?php

$dbuser = 'postgres';
$dbpass = 'Apple2001';
$host = 'localhost';
$dbname='advertising_agency';
$pdo = new PDO("pgsql:host=$host; dbname=$dbname", $dbuser, $dbpass);

?>

<!DOCTYPE html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<style type="text/css">
		html,
		body,
		header,
		.intro-2 {
		    background-size: cover;
		    background-color: white;
		}
		.navbar {
		    z-index: 1;
		    background-color: rgba(0,0,0,0.92);
		}
		.container-fluid{
			padding-right: 0;
			padding-left: 0;
			margin-bottom: 1em;
		}
		html,
		body,
		header,
		.view {
		  height: 100%;
		}
		</style>
	</head>
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="container-fluid">
					<nav class="navbar navbar-expand-lg navbar-dark black rgba-black-strong">
						<div class="container">
						  <a class="navbar-brand" href="main.php"><strong>Ермакова Анна</strong></a>
						  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
						    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						    <span class="navbar-toggler-icon"></span>
						  </button>
						  <div class="collapse navbar-collapse" id="navbarSupportedContent">
						    <ul class="navbar-nav mr-auto">
						      <li class="nav-item">
						        <a class="nav-link" href="advertiser.php">Рекламодатель</a>
						      </li>
						      <li class="nav-item active">
						        <a class="nav-link" href="advertising_agency.php">Рекламное агенство</a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="payment_order.php">Платежное поручение</a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="request.php">Заявка</a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="service.php">Рекламная услуга</a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="work.php">Работа</a>
						      </li>
						      <li class="nav-item">
						        <a class="nav-link" href="worker.php">Сотрудник агенства</a>
						      </li>
						    </ul>
						  </div>
						</div>
					</nav>
	   			</div>
			</div>
			      	<h2>Рекламное агенство</h2>
<form method="post" action="advertising_agency.php">
    <input type="submit" name="button4"
           class="button" value="Показать рекламное агенство"/>
</form>
<form method="post" action="advertising_agency.php">
    <input type="text" name="id"/>
    <input type="submit" name="button1"
           class="button" value="Найти"/>
    <input type="submit" name="button2"
           class="button" value="Удалить"/>
</form>
<form method="post" action="advertising_agency.php">
    <span>Name</span>
    <input type="text" name="name"/>
    <span>Address</span>
    <input type="text" name="address"/>
    <input type="submit" name="button3"
           class="button" value="Добавить"/>
</form>
			      
		</div>
	</body>
</html>

<?php
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
if (array_key_exists('button1', $_POST)) {
    find($pdo, $_POST['id']);
} else if (array_key_exists('button2', $_POST)) {
    delete($pdo, $_POST['id']);
} else if (array_key_exists('button3', $_POST)) {
    add($pdo, $_POST['name'], $_POST['address']);
} else if (array_key_exists('button4', $_POST)) {
    show($pdo);
}

function find($pdo, $id)
{
    $stmt = $pdo->query("select * FROM advertising_agency");
    $found = false;
    while ($row = $stmt->fetch()) {
        if ($row['id'] == $id) {
            echo "<table>";
            echo "<tr><th>id</th><th>name</th><th>address</th><tr>";
            $id = $row['id'];
            $name = $row['name'];
            $address = $row['address'];
            echo "<tr><th>$id</th><th>$name</th><th>$address</th><tr>";
            $found = true;
        }
    }
    if ($found != true) {
        echo "advertising_agency not found";
    }
}


function delete($pdo, $id)
{
    try {
        $stmt = $pdo->query("delete from advertising_agency where id=$id");
        $stmt->execute();
        echo "advertising_agency with id $id deleted";
    } catch (PDOException $e) {
        echo "DataBase Error: advertising_agency cannot be deleted<br>" . $e->getMessage();
    }
}


function add($pdo, $name, $address)
{
    $newid = ($pdo->query("select MAX(id) from advertising_agency")->fetch()[0])+1;
    try {
        $stmt=$pdo->prepare("INSERT INTO advertising_agency (id, name, address) VALUES ($newid, $name, $address)");
        $stmt->Execute();
        echo "advertising_agency added";
    } catch (PDOException $e) {
        echo "DataBase Error: advertising_agency cannot be added<br>" . $e->getMessage();
    }
}

function show($pdo)
{
    $stmt = $pdo->query("SELECT * FROM advertising_agency");
    echo "<table>";
    echo "<tr><th>id</th><th>name</th><th>address</th><tr>";
    while ($row = $stmt->fetch()) {
        $id = $row['id'];
        $name = $row['name'];
        $address = $row['address'];

        echo "<tr><th>$id</th><th>$name</th><th>$address</th><tr>";
    }
}

?>
