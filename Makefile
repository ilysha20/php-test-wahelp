MIGRATION_DIR = migration
MYSQL_USER = mysql
MYSQL_DATABASE = test

migrate:
	@for file in $(wildcard $(MIGRATION_DIR)/*.sql); do \
		echo "Processing file: $$file"; \
		lando mysql -u $(MYSQL_USER) -p -e "USE $(MYSQL_DATABASE); source $$file;"; \
	done
	@echo "All migrations completed"



