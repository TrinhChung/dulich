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

sudo nginx -t
sudo systemctl reload nginx