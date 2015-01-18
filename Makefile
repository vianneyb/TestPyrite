BIN = ./node_modules/.bin

install:
	composer install
	npm install
	bower install

clean:
	$(BIN)gulp clean

build:
	$(BIN)/gulp build


watch:
	$(BIN)/gulp watch --dev
