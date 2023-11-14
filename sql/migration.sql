-- migration.sql
-- 创建用户表
CREATE TABLE IF NOT EXISTS `users` (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '用户ID',
    username VARCHAR(255) NOT NULL COMMENT '用户名',
    password VARCHAR(255) NOT NULL COMMENT '密码',
    role ENUM('student', 'teacher', 'admin') NOT NULL DEFAULT 'student' COMMENT '用户角色'
) COMMENT '登录用户表';

-- 创建教师表
CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '教师ID',
    user_id INT COMMENT '关联用户ID',
    name VARCHAR(255) NOT NULL COMMENT '教师姓名',
    FOREIGN KEY (user_id) REFERENCES users(id)
) COMMENT '教师表';

-- 创建班级表
CREATE TABLE IF NOT EXISTS classes (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '班级ID',
    class_name VARCHAR(255) NOT NULL COMMENT '班级名称',
    teacher_id INT NOT NULL COMMENT '辅导员ID',
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
) COMMENT '班级表';

-- 创建学生表
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '学生ID',
    user_id INT COMMENT '关联用户ID',
    name VARCHAR(255) NOT NULL COMMENT '学生姓名',
    dob DATE COMMENT '出生日期',
    gender VARCHAR(10) COMMENT '性别',
    address VARCHAR(255) COMMENT '地址',
    class_id INT NOT NULL COMMENT '班级ID',
    total_score int COMMENT '成绩总分',
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (class_id) REFERENCES classes(id)
) COMMENT '学生表';


-- 创建课程表
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '课程ID',
    course_name VARCHAR(255) NOT NULL COMMENT '课程名称',
    teacher_id INT NOT NULL DEFAULT 0 COMMENT '授课老师ID',
    FOREIGN KEY (teacher_id) REFERENCES teachers(id)
) COMMENT '课程表';

-- 创建成绩表
CREATE TABLE IF NOT EXISTS grades (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '成绩ID',
    student_id INT COMMENT '学生ID',
    course_id INT COMMENT '课程ID',
    score INT COMMENT '分数',
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
) COMMENT '成绩表';

-- 修改
ALTER TABLE users
    ADD COLUMN session_id VARCHAR(255) COMMENT '登录凭证';
