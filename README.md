Attendance System
=================

Installation
------------

### Clone repo and provision with vagrant:

    git clone --recursive git@github.com:camelcasetechsd/attendance-system.git
    cd attendance-system
    vagrant up
    vagrant provision ## run this if the initial "vagrant up" had any fatal error preventing it completing


### Add the IP to your hosts file:

    10.1.1.33     attendance.localhost


### Access the box:

To access the vagrant environment from the terminal, change to the vagrant directory and type 

    vagrant ssh


### Use composer to install PHP dependencies:

    cd /vagrant
    composer install --prefer-dist


### Install later database schema
    cd /vagrant
    vendor/bin/doctrine orm:schema-tool:update --force


### View the site:

Visit [http://attendance.localhost/](http://attendance.localhost/) to view the site.