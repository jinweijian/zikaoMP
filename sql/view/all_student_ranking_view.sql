CREATE VIEW all_student_ranking_view AS
SELECT
    c.class_name,
    s.name AS student_name,
    s.total_score
FROM
    classes c
        JOIN
    students s ON c.id = s.class_id
ORDER BY
    c.class_name, s.total_score DESC;