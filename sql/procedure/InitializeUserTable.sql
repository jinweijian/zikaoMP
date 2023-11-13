-- 创建存储过程
CREATE PROCEDURE InitializeUserTable()
BEGIN
    DECLARE userCount INT;
SELECT COUNT(*) INTO userCount FROM `users`;

-- 如果用户表中没有数据，插入默认教师用户
IF userCount = 0 THEN
        INSERT INTO `users` (username, password, role) VALUES ('admin', SHA1('admin123'), 'teacher');
END IF;
END;

-- 调用存储过程
CALL InitializeUserTable();