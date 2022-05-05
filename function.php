<?php
$server = '127.0.0.1'; // адрес сервера
$user = 'root'; // Логин 
$password = ''; // Пароль 
$db = 'testdb'; // Название БД

$connection = mysqli_connect($server, $user, $password, $db); // Подключение
// Проверка на подключение
if (!$connection) {
    // Если проверку не прошло, то выводится надпись ошибки и заканчивается работа скрипта
    echo "Не удалось подключиться к БД<br>";
	echo mysqli_connect_error();
	exit();
}

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$size_page = 5;
$offset = ($pageno-1) * $size_page;

// Запрос 1. Все сотрудники в алфавитном порядке у которых не пройден испытательный срок (3 месяца с даты устройства) [сделал 15 месяцев для вывода]
$pages_sql = "SELECT COUNT(*) 
FROM `user` 
WHERE DATE(`created_at`)>= DATE_SUB(NOW(), INTERVAL 15 MONTH) 
ORDER BY `last_name` ASC, `first_name` ASC, `middle_name` ASC";
$result = mysqli_query($connection, $pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $size_page);

$sql = "SELECT * FROM `user` WHERE DATE(`created_at`)>= DATE_SUB(NOW(), INTERVAL 15 MONTH) ORDER BY `last_name` ASC, `first_name` ASC, `middle_name` ASC LIMIT $offset, $size_page";
$myresult = mysqli_query ($connection, $sql);
	/*while ($newb=mysqli_fetch_assoc($myresult))	:?>
		<li><?= $newb['last_name'].' | '. $newb['first_name'].' | '. $newb['middle_name'].' | '. $newb['created_at']?> </li>
	<?php endwhile*/?>
<?php
//Конец запроса 1

// Запрос 2. На текущую дату все уволенные сотрудники с причинами.
$pages_sql = "SELECT COUNT(u.`first_name`)
FROM `user` as u, `user_dismission` as ud, `dismission_reason` as dr
WHERE ud.`user_id`=u.`id` and ud.`reason_id`=dr.`id`";
$result = mysqli_query($connection, $pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $size_page);

$sql = "SELECT u.`first_name` as first_name, u.`last_name` as last_name, u.`middle_name` as middle_name, dr.`description` as descript
FROM `user` as u, `user_dismission` as ud, `dismission_reason` as dr
WHERE ud.`user_id`=u.`id` and ud.`reason_id`=dr.`id` LIMIT $offset, $size_page";

$res_data = mysqli_query($connection, $sql);
// Конец запроса 2

// Запрос 3. Последний нанятый сотрудник у каждого начальника. 
$pages_sql = "SELECT COUNT(`description`) FROM `department`";
$result = mysqli_query($connection, $pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $size_page);

$sql_1 = "SELECT d.description as name, d.id as id, u.`first_name` as first_name, u.`last_name` as last_name, u.`middle_name` as middle_name
FROM department as d
JOIN user as u
ON d.leader_id = u.id
LIMIT $offset, $size_page";
$myresult_1 = mysqli_query ($connection, $sql_1);


/*while ($rw = mysqli_fetch_array($myresult_1)){
$sql_2 = "SELECT  `last_name`
FROM `user`
WHERE `update_at` = (
	SELECT MAX(`update_at`)
	FROM user_position up
	WHERE up.`department_id` = $rw['id'])";
$mypreresult = mysqli_query ($connection, $sql_2);
}*/
// Конец запроса 3
mysqli_close($connection);
