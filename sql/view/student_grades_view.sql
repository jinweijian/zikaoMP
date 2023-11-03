CREATE VIEW student_grades_view AS
SELECT
    s.name AS student_name,
    c.course_name,
    g.score
FROM
    students s
        JOIN
    grades g ON s.id = g.student_id
        JOIN
    courses c ON g.course_id = c.id;
