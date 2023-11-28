<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>选课详情</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <?php echo getHeard($user); ?>

    <div class="row mt-3">
        <?php echo getNavbar($user, $menuSlug); ?>

        <div class="col-md-9">
            <!-- 选课详情 -->
            <div class="card">
                <div class="card-header">
                    选课详情
                </div>
                <div class="card-body">
                    <h5 class="card-title">课程名: <?php echo $course['course_name']; ?></h5>
                    <p class="card-text">教师: <?php echo $teacher['name']; ?></p>
                </div>
            </div>

            <!-- 选课管理的学生列表 -->
            <div class="mt-4">
                <h2>课程学生列表</h2>
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>学生名称</th>
                        <th>报名时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $student['enroll_id']; ?></td>
                            <td><?php echo $student['student_name']; ?></td>
                            <td><?php echo date("Y-m-d H:i", $student['enroll_time']); ?></td>
                            <td>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?php echo $student['enroll_id']; ?>">取消报名</a>

                                <!-- 删除确认弹窗 -->
                                <div class="modal fade" id="deleteModal<?php echo $student['enroll_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel">确认取消学生报名</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                确定要取消学生 "<?php echo $student['student_name']; ?>" 的报名吗？
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                                                <a href="/courseRegistration/delete?id=<?php echo $student['enroll_id']; ?>&timespan=<?php echo time(); ?>" class="btn btn-danger">确认</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- 分页器 -->
                <?php echo generatePagination($page, $studentTotal);?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
