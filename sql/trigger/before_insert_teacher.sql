-- 创建学生后自动创建登陆账号
CREATE TRIGGER before_insert_teacher
    BEFORE INSERT ON teachers
    FOR EACH ROW
BEGIN
    DECLARE teacher_username VARCHAR(255);
    DECLARE teacher_pwd VARCHAR(255);

    -- 生成教师用户名与密码
    SET teacher_username = NEW.card_id;
    SET teacher_pwd = SHA1(RIGHT(NEW.card_id, 4));

    -- 插入用户表中
    INSERT INTO users (username, password, role)
    VALUES (teacher_username, teacher_pwd, 'teacher');

    -- 更新教师表中的关联用户ID
    set NEW.user_id = LAST_INSERT_ID();
END;