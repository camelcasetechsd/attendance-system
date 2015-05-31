VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty64"
  #config.vm.box_url = "mybox/trusty64.box"
  config.vm.synced_folder "./", "/var/www", id: "web-root"
  config.vm.network "forwarded_port", guest: 22, host: 2251, id: "ssh", auto: true
  config.vm.network "private_network", ip: "10.1.1.33"
  config.omnibus.chef_version = "12.3.0"

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--name", "attendance-system"]
    vb.customize ["modifyvm", :id, "--memory", "1024"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--natdnsproxy1", "on"]
    #vb.gui = true
  end

  config.vm.provision "chef_solo" do |chef|
    chef.cookbooks_path = ["chef/site-cookbooks", "chef/cookbooks"]
    chef.add_recipe "mysql::server"
    chef.json = {
            :mysql => {
                    server_root_password: "ilikerandompasswords",
                    server_repl_password: "ilikerandompasswords",
                    server_debian_password: "ilikerandompasswords",
                    bind_address: "127.0.0.1",
                    allow_remote_root: true,
                    remove_anonymous_Users: true,
                    remove_test_database: true
            }
    }
   chef.roles_path = "chef/roles"
    chef.provisioning_path = "/tmp/vagrant-chef"
    chef.add_role "web"
    chef.log_level = "debug"
    chef.verbose_logging = true
  end

end
