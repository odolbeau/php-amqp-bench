extension:
	./prepare_rabbit.sh
	php ./send_messages.php $(filter-out $@,$(MAKECMDGOALS))
	php ./bench_consume.php pecl $(filter-out $@,$(MAKECMDGOALS))

lib:
	./prepare_rabbit.sh
	php ./send_messages.php $(filter-out $@,$(MAKECMDGOALS))
	php ./bench_consume.php amqplib $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
