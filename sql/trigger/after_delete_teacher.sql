-- 删除教师后自动删除关联账号
CREATE TRIGGER after_delete_teacher
    AFTER DELETE ON teachers
    FOR EACH ROW
BEGIN
    -- 删除关联用户账号
    DELETE FROM users WHERE id = OLD.user_id;
END;