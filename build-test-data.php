<?php

require_once __DIR__ . '/vendor/autoload.php';

use Faker\Factory;

$faker = Factory::create('zh_CN');

$mysqlSingleton = \App\Kernel\MysqlSingleton::getInstance();
$pdo = $mysqlSingleton->getConnection();

// 生成班级
$classNames = [
    '计算机科学与技术', '信息管理与信息系统', '软件工程', '网络工程',
    '电子信息科学与技术', '通信工程', '物联网工程', '数学与应用数学',
    '应用物理学', '应用化学', '生物医学工程', '金融学',
    // ... 添加更多的班级名称
];
// 生成课程
$courseNames = [
    '数据库原理', '数据结构', '算法设计', '操作系统',
    '计算机网络', '软件工程', '编程语言原理', '人工智能',
    '数字逻辑', '计算机组成原理', '机器学习', '数据挖掘',
    '金融经济', '会计', '社会学', '麻醉学',
    // ... 添加更多的课程名称
];

// 生成教师
for ($i = 1; $i <= 20; $i++) {
    createTeacher();
}

// 生成班级
for ($i = 1; $i <= 10; $i++) {
    $className = array_pop($classNames);
    $teacherId = createTeacher();
    createClass($className, $teacherId);
}

$teacherIds = $pdo->query("SELECT id FROM teachers")->fetchAll(PDO::FETCH_COLUMN);
foreach ($courseNames as $courseName) {
    $teacherId = array_pop($teacherIds);
    createCourse($teacherId, $courseName);
}

function createCourse($teacherId, $courseName)
{
    global $pdo;

    // 生成课程
    $sql = "INSERT INTO courses (course_name, teacher_id) VALUES ('$courseName', $teacherId)";
    $id = $pdo->exec($sql);
}
// 生成教师
function createTeacher()
{
    global $faker, $pdo;
    $name = $faker->lastName . $faker->firstName;
    $phoneNumber = $faker->randomElement(['188', '182', '189', '136']) . $faker->numberBetween(100000000, 999999999);
    $cardId = generateUniqueCardId();
    $sql = "INSERT INTO teachers (name, phone_number, card_id) VALUES ('$name', '$phoneNumber', '$cardId')";
    $pdo->exec($sql);
    return $pdo->lastInsertId();
}

// 生成班级
function createClass($className, $teacherId)
{
    global $pdo;
    $sql = "INSERT INTO classes (class_name, teacher_id) VALUES ('$className', $teacherId)";
    $pdo->exec($sql);
}

// 生成学生
for ($i = 1; $i <= 200; $i++) {
    $name = $faker->lastName . $faker->firstName;
    $dob = $faker->date;
    $gender = $faker->randomElement(['男', '女']);
    $address = $faker->address;
    $classId = $faker->numberBetween(1, 10);
    $cardId = generateUniqueCardId();
    $totalScore = $faker->numberBetween(0, 100);
    $phoneNumber = $faker->randomElement(['188', '182', '189', '136']) . $faker->numberBetween(100000000, 999999999);
    createStudent($name, $dob, $gender, $address, $classId, $cardId, $totalScore, $phoneNumber);
}

// 生成学生选课关系和成绩
$students = $pdo->query("SELECT id FROM students")->fetchAll(PDO::FETCH_COLUMN);
$courses = $pdo->query("SELECT id FROM courses")->fetchAll(PDO::FETCH_COLUMN);
foreach ($students as $studentId) {
    $selectedCourses = [];
    try {
        $selectedCourses = $faker->randomElements($courses, $faker->numberBetween(2, 3));
    } catch (LengthException $e) {
        // Handle the exception, for now, just continue the loop
        echo $e->getMessage() . PHP_EOL;
    }
    foreach ($selectedCourses as $courseId) {
        enrollStudent($studentId, $courseId);
        generateGrade($studentId, $courseId);
    }
}

echo "数据初始化完成!\n";

function generateUniqueCardId()
{
    global $faker, $pdo;
    $cardId = '340000' . $faker->dateTimeBetween('-40 years', '-18 years')->format('Ymd') . $faker->randomNumber($faker->randomElement([3, 4])) . $faker->randomElement(['', 'X']);
    while (true) {
        $result = $pdo->query("SELECT COUNT(*) FROM students WHERE card_id = '$cardId'")->fetchColumn();
        if ($result == 0) {
            break;
        }
        $cardId = '340000' . $faker->dateTimeBetween('-40 years', '-18 years')->format('Ymd') . $faker->randomNumber($faker->randomElement([3, 4])) . $faker->randomElement(['', 'X']);
    }
    return $cardId;
}

function createStudent($name, $dob, $gender, $address, $classId, $cardId, $totalScore, $phoneNumber)
{
    global $pdo;
    $sql = "INSERT INTO students (name, dob, gender, address, class_id, card_id, total_score, phone_number) 
            VALUES ('$name', '$dob', '$gender', '$address', $classId, '$cardId', $totalScore, '$phoneNumber')";
    $pdo->exec($sql);
}

function enrollStudent($studentId, $courseId)
{
    global $pdo, $faker;
    $createdTime = $faker->unixTime;
    $sql = "INSERT INTO student_course_relation (student_id, course_id, created_time) VALUES ($studentId, $courseId, $createdTime)";
    $pdo->exec($sql);
}

function generateGrade($studentId, $courseId)
{
    global $pdo;
    $score = rand(0, 100);
    $sql = "INSERT INTO grades (student_id, course_id, score) VALUES ($studentId, $courseId, $score)";
    $pdo->exec($sql);
}
