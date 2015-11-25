#!/bin/bash

composer install --prefer-dist;

## prepare Grunt libraries
npm update npm
npm install

## prepare Database
./bin/cli orm:schema-tool:drop --force;
./bin/cli orm:schema-tool:update --force;
./bin/cli schema:data-generate ;

## prepare public resources
cd public
bower install 
cd ../

## run Grunt tasks
./node_modules/.bin/grunt
cp -r public/bower_components/jquery-ui/themes/smoothness/images public/concat/
cp -r public/bower_components/bootstrap/fonts public/
cp -r public/bower_components/font-awesome/fonts public/