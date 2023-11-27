-- 删除学生后自动删除关联账号
CREATE TRIGGER after_delete_student
    AFTER DELETE ON students
    FOR EACH ROW
BEGIN
    -- 删除关联用户账号
    DELETE FROM users WHERE id = OLD.user_id;
END;
