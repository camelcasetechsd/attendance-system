Attendance System
=================

Installation
------------

### Clone repo and provision with vagrant:

    git clone git@github.com:camelcasetechsd/attendance-system.git
    cd attendance-system
    vagrant up
    vagrant provision ## run this if the initial "vagrant up" had any fatal error preventing it completing


### Add the IP to your hosts file:

    10.1.1.33     attendance.localhost


### Access the box:

To access the vagrant environment from the terminal, change to the vagrant directory and type 

    vagrant ssh


### Run deployment script:

    cd /vagrant
    . deploy.sh

### run acceptance tests
    cd /vagrant
    ./bin/behat

### View the site:

Visit [http://attendance.local/](http://attendance.local/) to view the site.
