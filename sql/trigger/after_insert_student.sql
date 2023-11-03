-- 创建学生后自动创建登陆账号

CREATE TRIGGER after_insert_student
    AFTER INSERT ON students
    FOR EACH ROW
BEGIN
    DECLARE student_username VARCHAR(255);
    DECLARE student_pwd VARCHAR(255);

    -- 生成学生用户名，例如：'student123'
    SET student_username = CONCAT('student', NEW.id);
    SET student_pwd = CONCAT('student', NEW.id);

    -- 插入用户表中
    INSERT INTO users (username, password, role)
    VALUES (student_username, student_pwd, 'student');

    -- 更新学生表中的关联用户ID
    UPDATE students
    SET user_id = LAST_INSERT_ID()
    WHERE id = NEW.id;
END;