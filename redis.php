<?php

declare(strict_types=1);

// Redis PHP extension: php_redis-6.0.2-8.2-nts-vs16-x64
function redis_test()
{
	// создание соединения с Redis
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);

	// сохранение данных в Redis
	echo "\nCохранение данных в Redis:\n";
	echo "==========================\n";
	echo "numeric_value = 100\n";
	$redis->set('numeric_value', 100);

	echo "string_value = 'This is a string'\n";
	$redis->set('string_value', 'This is a string');

	echo "list_value = [1, 2, 3]\n";
	$redis->set('list_value', json_encode([1, 2, 3]));

	// извлечение данных из Redis
	echo "\nЗначения, полученные из Redis:\n";
	echo "==============================\n";
	echo "numeric_value = " . $redis->get('numeric_value') . "\n";
	echo "string_value = " . $redis->get('string_value') . "\n";
	echo "list_value = " . $redis->get('list_value') . "\n";

	// закрытие соединения c Redis
	$redis->close();
}

redis_test();
