init:
	./prepare_rabbit.sh

extension_publish:
	php ./bench.php publish_extension $(filter-out $@,$(MAKECMDGOALS))

lib_publish:
	php ./bench.php publish_lib $(filter-out $@,$(MAKECMDGOALS))

extension_get:
	php ./bench.php get extension $(filter-out $@,$(MAKECMDGOALS))

lib_get:
	php ./bench.php get lib $(filter-out $@,$(MAKECMDGOALS))

%:
	@:
