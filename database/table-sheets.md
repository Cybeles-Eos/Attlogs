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

## Create Another Column In User Table: role
```sql
ALTER TABLE users
ADD role VARCHAR(50) DEFAULT 'user';
```

## Create Another Column In User Table: is_enrolled
```sql
ALTER TABLE users
ADD is_enrolled TINYINT(1) NOT NULL DEFAULT 0;
```

## Create a enrollment status for LEFT JOIN performing
## Left Join: Get data in enrollment_status
```sql
CREATE TABLE enrollment_status (
    id TINYINT(1) PRIMARY KEY,
    message VARCHAR(100) NOT NULL
);

INSERT INTO enrollment_status (id, message) VALUES
(1, 'Welcome Back'),
(0, 'Not Enrolled');
```

## Created Table: attendance_status
```sql
CREATE TABLE attendance_status (
    id TINYINT(1) PRIMARY KEY,
    message VARCHAR(100) NOT NULL
);

INSERT INTO attendance_status (id, message) VALUES
(1, 'Present'),
(0, 'Absent');

ALTER TABLE users
ADD is_in TINYINT(1) NOT NULL DEFAULT 0;
```