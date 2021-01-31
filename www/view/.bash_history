exit
sudo vim
ls -l /var/www
sudo chown -R apache:apache /var/www/html/
sudo chmod 775 /var/www/html/
sudo usermod -aG apache suzuki
ls -l /var/www
sudo mkdir /var/www/conf
sudo chown -R apache:apache /var/www/conf/
sudo chmod 775 /var/www/conf/
sudo mkdir /var/www/model
sudo chown -R apache:apache /var/www/model/
sudo chmod 775 /var/www/model/
sudo mkdir /var/www/view
sudo chown -R apache:apache /var/www/view/
sudo chmod 775 /var/www/view/
ls -l /var/www
