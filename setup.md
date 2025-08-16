### 1. Đăng nhập MySQL

```bash
mysql -u root -p
```

### 2. Tạo database (nếu chưa có)

```sql
CREATE DATABASE IF NOT EXISTS u586524151_0fZmL
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

### 3. Tạo user với host `%`

```sql
CREATE USER 'u586524151_amo'@'%' IDENTIFIED BY 'Chinyeu@1994';
```

### 4. Cấp quyền cho user trên database

```sql
GRANT ALL PRIVILEGES ON u586524151_0fZmL.* TO 'u586524151_amo'@'%';
```

### 5. Áp dụng thay đổi

```sql
FLUSH PRIVILEGES;
```

mysql -u u586524151_amo -p u586524151_0fZmL < ./u586524151_0fZmL.sql

Chinyeu@1994


UPDATE u586524151_0fZmL.bz_options 
SET option_value = 'http://localhost:8441'
WHERE option_name = 'siteurl';

UPDATE u586524151_0fZmL.bz_options 
SET option_value = 'http://localhost:8441'
WHERE option_name = 'home';


sudo nano /etc/nginx/sites-enabled/wp-amo.conf

server {
    listen 8441;
    server_name localhost;

    root /home/theme/dulich;
    index index.php index.html index.htm;

    # Chặn truy cập file ẩn
    location ~ /\. {
        deny all;
    }

    # Xử lý request WordPress
    location / {
        try_files $uri $uri/ /index.php?$args;
    }

    # Xử lý PHP
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.1-fpm.sock;  # Đổi version PHP nếu khác
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}


sudo nginx -t
sudo systemctl reload nginx


sudo apt update
sudo apt install -y software-properties-common ca-certificates lsb-release apt-transport-https
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update


sudo apt install -y php7.4 php7.4-fpm php7.4-mysql \
php7.4-xml php7.4-mbstring php7.4-curl php7.4-gd \
php7.4-zip php7.4-intl php7.4-bcmath

sudo systemctl disable --now php8.1-fpm
sudo systemctl enable --now php7.4-fpm
sudo systemctl start php7.4-fpm
