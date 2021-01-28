ci:
	vendor/bin/phpunit tests
	vendor/bin/phpstan analyze -c phpstan.neon --memory-limit=256M
	vendor/bin/ecs check src tests
fix:
	vendor/bin/ecs check src tests --fix
