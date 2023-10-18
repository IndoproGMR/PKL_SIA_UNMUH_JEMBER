taro file di root lalu copy file public ke dalam html

set perm folder
```bash
sudo chmod -R writable/
sudo chmod -R html/

sudo chown -R www-data:www-data writable/
sudo chown -R www-data:www-data html/
```


ubah baseurl di **.env** menjadi url (\www.exemple.com)
ubah baseurl di **App/Config/App.php** menjadi url (\www.exemple.com)

ubah **App/Config/helpers/rendergambar_helper.php**
``` php
$mpdf = new \Mpdf\Mpdf();
// manjadi =>
$mpdf = new \Mpdf\Mpdf(['tempDir' => $setting['tempDir']]);
```


# new
#### set .env
```env
#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

app.baseURL = 'http://192.168.43.138/'
# If you have trouble with `.`, you could also use `_`.
app_baseURL = 'http://192.168.43.138/'
# app.forceGlobalSecureRequests = false
# app.CSPEnabled = false
```

#### set conf apache
```conf
<VirtualHost *:80>
	ServerAdmin webmaster@localhost
	ServerName 192.168.43.138/
    ServerAlias http://192.168.43.138/
	DocumentRoot /var/www/testserversia/public/index.php/
	
	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

#### set .htaccess
```htaccess
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^([\s\S]*)$ index.php?/$1 [L,NC,QSA]
	........
```

```htaccess
# Disable directory browsing
Options -Indexes

# ----------------------------------------------------------------------
# Rewrite engine
# ----------------------------------------------------------------------

# Turning on the rewrite engine is necessary for the following rules and features.
# FollowSymLinks must be enabled for this to work.
<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php/$1 [L]

	Options +FollowSymlinks
	RewriteEngine On

	# If you installed CodeIgniter in a subfolder, you will need to
	# change the following line to match the subfolder you need.
	# http://httpd.apache.org/docs/current/mod/mod_rewrite.html#rewritebase
	 RewriteBase /public

	# Redirect Trailing Slashes...
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_URI} (.+)/$
	RewriteRule ^ %1 [L,R=301]

	# Rewrite "www.example.com -> example.com"
	RewriteCond %{HTTPS} !=on
	RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
	RewriteRule ^ http://%1%{REQUEST_URI} [R=301,L]

	# Checks to see if the user is attempting to access a valid file,
	# such as an image or css document, if this isn't true it sends the
	# request to the front controller, index.php
	# RewriteEngine On
	#RewriteCond %{REQUEST_FILENAME} !-f
	#RewriteCond %{REQUEST_FILENAME} !-d
	#RewriteRule ^(.*)$ /index.php/$1 [L]
	
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^([\s\S]*)$ index.php/$1 [L,NC,QSA]

	# Ensure Authorization header is passed along
	RewriteCond %{HTTP:Authorization} .
	RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>

<IfModule !mod_rewrite.c>
	# If we don't have mod_rewrite installed, all 404's
	# can be sent to index.php, and everything works as normal.
	ErrorDocument 404 index.php
</IfModule>

# Disable server signature start
	ServerSignature Off
# Disable server signature end
```

#### set app/config/App.php
```php
    public string $indexPage = '';
```
TODO:
- [ ] set lokasi simpan qr
- [x] set lokasi simpan PDF


http://localhost:8080/js/sidebarjs.js
http://192.168.43.138/js/sidebarjs.js

http://localhost:8080/js/instascan.min.js
http://192.168.43.138/js/instascan.min.js