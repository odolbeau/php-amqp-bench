extension:
	./prepare_rabbit.sh
	php ./send_messages.php $(filter-out $@,$(MAKECMDGOALS))
	php ./bench_consume.php extension $(filter-out $@,$(MAKECMDGOALS))

lib:
	./prepare_rabbit.sh
	php ./send_messages.php $(filter-out $@,$(MAKECMDGOALS))
	php ./bench_consume.php lib $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
