#!/bin/bash

composer install --prefer-dist;

## prepare Grunt libraries
npm update npm
npm install grunt-cli
npm install grunt-contrib-cssmin --save-dev
npm install grunt-contrib-uglify --save-dev
npm install grunt-contrib-concat --save-dev

## prepare Database
./bin/cli orm:schema-tool:drop --force;
./bin/cli orm:schema-tool:update --force;
./bin/cli schema:data-generate ;

## prepare public resources
cd public
bower install 
cd ../

## run Grunt tasks
grunt
cp -r public/bower_components/jquery-ui/themes/smoothness/images public/concat/
cp -r public/bower_components/bootstrap/fonts public/
cp -r public/bower_components/font-awesome/fonts public/