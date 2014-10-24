init:
	./prepare_rabbit.sh

ext_publish:
	php ./bench.php publish_ext $(filter-out $@,$(MAKECMDGOALS))

lib_publish:
	php ./bench.php publish_lib $(filter-out $@,$(MAKECMDGOALS))

ext_get:
	php ./bench.php get ext $(filter-out $@,$(MAKECMDGOALS))

lib_get:
	php ./bench.php get lib $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
