# Assault-Strategy-v2
Version 2 for the now famous Assault &amp; Strategy

# Setup

## Symfony part
Obviously, you will need Apache, PHP and Mysql. Up to you to choose the way you install it.

First of all, you need to have composer installed. For more information : https://getcomposer.org/download/

Once this is done, and your project is checked out, go to /api folder, and type in
'''
composer update
'''

After a short while, everything should be installed. You just need to give the appropriate rights to caching and logging, which you can fix either by :
'''
sudo chmod -R 777 app/logs/
sudo chmod -R 777 app/cache/
'''

or, more cleanly, to set www-data as the owner:
''' 
sudo chown -R www-data:www-data app/logs
sudo chown -R www-data:www-data app/cache
'''
