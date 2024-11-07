# TechartPetProj
Для корректной развертки сайта необходимы следующие файлы: .htaccess ,.env.
.env поместить в корень сайта. Файл внешней среды имеет следующий код:
DB_DRIVER=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=GalacticVestnic
DB_USERNAME=root
DB_PASSWORD=5565
DB_CHARSET=utf8

.htaccess имеется в наличии в двух экземплярах. Первый необходимо поместить в дирректорию public. Файл включает в себя следующее содержимое:
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^.*$ index.php [QSA,L]

Второй файл .htaccess неодходимо поместить в дирректорию uploads:
<FilesMatch "\.(php|pl|py|cgi|sh|bash|js)$">
    Order Allow,Deny
    Deny from all
</FilesMatch>
<FilesMatch "\.(jpg|jpeg|png|gif)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>
