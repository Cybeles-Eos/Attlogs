# Database Name: 'attlogs'
<hr>


## Create User Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

## Create Another Column In User Table
```sql
ALTER TABLE users
ADD role VARCHAR(50) DEFAULT 'user';
```