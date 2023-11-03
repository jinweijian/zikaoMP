-- 新考试后更新学生表新的分数
CREATE TRIGGER update_student_total_score
    AFTER INSERT ON grades
    FOR EACH ROW
BEGIN
    UPDATE students
    SET total_score = (
        SELECT SUM(score)
        FROM grades
        WHERE student_id = NEW.student_id
    )
    WHERE id = NEW.student_id;
END;