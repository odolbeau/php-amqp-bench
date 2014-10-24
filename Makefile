pecl:
	php ./send_messages.php $(filter-out $@,$(MAKECMDGOALS))
	php ./bench_consume.php pecl $(filter-out $@,$(MAKECMDGOALS))

php-amqplib:
	php ./send_messages.php $(filter-out $@,$(MAKECMDGOALS))
	php ./bench_consume.php amqplib $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
