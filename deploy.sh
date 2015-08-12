#!/bin/bash

composer install --prefer-dist;

./bin/cli orm:schema-tool:drop --force;
./bin/cli orm:schema-tool:update --force;
./bin/cli schema:data-generate ;