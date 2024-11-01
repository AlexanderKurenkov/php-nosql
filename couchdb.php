<?php

declare(strict_types=1);

// NOTES:
// 	- must run couchdb.cmd as administrator
// 	- Fauxton web UI: http://localhost:5984/_utils/#
// curl -X GET http://admin:admin@localhost:5984/_all_dbs
// curl -X PUT http://admin:admin@localhost:5984/lab-1
// curl -X POST http://admin:admin@localhost:5984/lab-1 -H "Content-Type: application/json" -d '{"grade": "5"}'

$url = "http://localhost:5984";
$user = 'admin';
$password = 'admin';
$database = '/lab-1';

// опции контекста HTTP
$options = [
	'http' => [
		'method'  => 'GET',
		'header'  => 'Authorization: Basic ' . base64_encode("$user:$password") . "\n"
	],
];

echo "\nудаление ранее созданной базы данных:\n";
echo "======================================\n";
// отправка DELETE-запроcа и получение ответа
$options['http']['method'] = 'DELETE';
$context = stream_context_create($options);
$response = file_get_contents($url . $database, false, $context);

// обработка ошибок
if ($response === false) {
	echo "Ошибка при удалении базы данных\n";
} else {
	echo "База данных $database успешно удалена\n";
	echo $response;
}

echo "\nсоздание новой базы данных:\n";
echo "============================\n";
// отправка PUT-запроcа и получение ответа
$options['http']['method'] = 'PUT';
$context = stream_context_create($options);
$response = file_get_contents($url . $database, false, $context);

// обработка ошибок
if ($response === false) {
	die("Ошибка при создания базы данных\n");
} else {
	echo "База данных $database успешно создана\n";
	echo $response;
}

echo "\nполучение списка баз данных:\n";
echo "=============================\n";
$listDatabasesEndpoint = "/_all_dbs";

// создайте контекст запроса с указанными заголовками и параметрами
$options['http']['method'] = 'GET';
$context = stream_context_create($options);

// отправка GET-запроса
$response = file_get_contents($url . $listDatabasesEndpoint, false, $context);

// обработка ошибок
if ($response === false) {
	die("Ошибка при получении списка баз данных\n");
} else {
	echo "Список баз данных:\n";
	echo $response;
}

echo "\nсоздание нового документа:\n";
echo "===========================\n";
$data = ["grade" => "5"];

// создайте контекст запроса с указанными заголовками и параметрами
$options['http']['method'] = 'POST';
$options['http']['header'] .= "Content-Type: application/json";
$options['http']['content'] = json_encode($data);
$context = stream_context_create($options);

// создание документа
$response = file_get_contents($url . $database, false, $context);

// очистка контекста запроса
$options['http']['header'] = '';
$options['http']['content'] = '';

// обработка ошибок
if ($response === false) {
	die("Ошибка при создания документа\n");
} else {
	echo "Документ успешно создан\n";
	echo $response;
}

echo "\nполучение списка документов:\n";
echo "=============================\n";
$listDocumentsEndpoint = "/_all_docs";

// создайте контекст запроса с указанными заголовками и параметрами
$options['http']['method'] = 'GET';
$options['http']['header'] = 'Authorization: Basic ' . base64_encode("$user:$password") . "\n";
$context = stream_context_create($options);

// отправка GET-запроса
$response = file_get_contents($url . $database . $listDocumentsEndpoint, false, $context);

// обработка ошибок
if ($response === false) {
	die("Ошибка при получении списка документов\n");
} else {
	echo $response;
}
