CREATE VIEW all_student_ranking_view AS
SELECT
    c.class_name,
    s.name AS student_name,
    s.total_score
FROM
    classes c
        JOIN
    class_members cm ON c.id = cm.class_id
        JOIN
    students s ON cm.student_id = s.id
ORDER BY
    c.class_name, s.total_score DESC;