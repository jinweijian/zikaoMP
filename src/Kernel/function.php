<?php

function getNavbar($user): string
{
    $sidebarItems = [
        ['name' => '教师管理', 'url' => '/teacher/list'],
        ['name' => '班级管理', 'url' => '/class/list'],
        ['name' => '学生列表', 'url' => '/student/list'],
        ['name' => '用户列表', 'url' => '/user/list'],
        ['name' => '查询用户', 'url' => '/admin/search-user'],
        ['name' => '统计学生成绩', 'url' => '/admin/statistics'],
    ];
    $html = '<div class="col-md-3"><h3>导航</h3><ul class="list-group">';
    foreach ($sidebarItems as $item) {
        $html .= '<li class="list-group-item"><a href="' . $item['url'] . '"/>' . $item['name'] . '</a></li>';
    }
    $html .= ' </ul></div>';

    return $html;
}

function getHeard($user): string
{
    $user['username'] = $user['username'] ?? 'Guide';
    return "<div class='d-flex justify-content-between align-items-center'>
        <h2>欢迎您, {$user['username']}!</h2>

        <div>
            <a href='/user/logout' class='btn btn-danger'>Logout</a>
        </div>
    </div>";
}

function getGreeting($time)
{
    if ($time >= '05:00' && $time < '12:00') {
        return '早上好';
    } elseif ($time >= '12:00' && $time < '18:00') {
        return '中午好';
    } elseif ($time >= '18:00' && $time < '24:00') {
        return '晚上好';
    } else {
        return '凌晨好';
    }
}

function generatePagination($currentPage, $totalPages): string
{
    $html = '<nav aria-label="Page navigation">';
    $html .= '<ul class="pagination justify-content-center">';

    // 上一页按钮
    $html .= '<li class="page-item ' . ($currentPage == 1 ? 'disabled' : '') . '">';
    $html .= '<a class="page-link" href="?page=' . ($currentPage - 1) . '" aria-label="Previous">';
    $html .= '<span aria-hidden="true">&laquo;</span>';
    $html .= '</a>';
    $html .= '</li>';

    // 生成页码按钮
    for ($i = 1; $i <= $totalPages; $i++) {
        $html .= '<li class="page-item ' . ($currentPage == $i ? 'active' : '') . '">';
        $html .= '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
        $html .= '</li>';
    }

    // 下一页按钮
    $html .= '<li class="page-item ' . ($currentPage == $totalPages ? 'disabled' : '') . '">';
    $html .= '<a class="page-link" href="?page=' . ($currentPage + 1) . '" aria-label="Next">';
    $html .= '<span aria-hidden="true">&raquo;</span>';
    $html .= '</a>';
    $html .= '</li>';

    $html .= '</ul>';
    $html .= '</nav>';
    return $html;
}

function perPage($page, $size)
{
    return [($page - 1) * $size, $size];
}

function systemLog(string $level, string $message, array $data = [])
{
    $content = date('Y-m-d H:i:s');
    $content .= " [$level] ";
    $content .= " [$message] ";
    if (!empty($data)){
        $content .= json_encode($data);
    }
    $content .= PHP_EOL;
    $filename = FILE_PATH . '/logs/system.log';

    file_put_contents($filename, $content, FILE_APPEND);
}

function parts(array $array, array $keys)
{
    foreach (array_keys($array) as $key) {
        if (!in_array($key, $keys)) {
            unset($array[$key]);
        }
    }

    return $array;
}
