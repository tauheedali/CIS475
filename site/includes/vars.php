<?php
$title = "Tauheed's Website";
$page = "Tauheed's CIS475 Website";
$today = date("Y-m-d H:i:s a");
$editor = 'PHPStorm';
$author = 'Tauheed Ali';
$server = 'Docker containers';
$meta = [
    'keywords' => "HTML, $server, , $editor",
    'description' => 'CIS 475 Website',
    'author' => $author,
    'viewport' => 'width=device-width, initial-scale=1.0'
];
$baseUrl = $_SERVER['SERVER_NAME'] == 'localhost' ? '/' : '/~alit01/';
$links = [
    [
        'title' => 'Home',
        'url' => $baseUrl
    ],
    [
        'title' => 'Dev Server',
        'url' => $baseUrl . 'devserver.php'
    ],
    [
        'title' => 'Lists, Functions, & Arrays',
        'url' => $baseUrl . 'lfa.php'
    ],
    [
        'title' => 'Database',
        'url' => $baseUrl . 'db.php'
    ],
    [
        'title' => 'MySQL Table',
        'url' => $baseUrl . 'php_mysql_table.php'
    ],
    [
        'title' => 'AJAX Form',
        'url' => $baseUrl . 'ajax_form.php'
    ],
    [
        'title' => 'MySQL Form',
        'url' => $baseUrl . 'php_mysql_form.php'
    ],
    [
        'title' => 'Read File',
        'url' => $baseUrl . 'fileio.php'
    ],
];
$authLinks = [
    [
        'title' => 'Admin',
        'url' => $baseUrl . 'admin.php'
    ],
    [
        'title' => 'Logout',
        'url' => $baseUrl . 'logout.php'
    ],
];
$nonAuthLinks = [
    [
        'title' => 'Register',
        'url' => $baseUrl . 'register.php'
    ],
    [
        'title' => 'Login',
        'url' => $baseUrl . 'login.php'
    ],
];
$assignments = [
    [
        'title' => 'Brief Introduction',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703934_1',
        'due_date' => '2020-09-08',
        'completed' => TRUE
    ],
    [
        'title' => 'Create Your bscacad3.buffalostate.edu Home Page',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703937_1',
        'due_date' => '2020-09-10',
        'completed' => TRUE
    ],
    [
        'title' => 'Setup Your Apache/PHP/MySQL Server',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703940_1',
        'due_date' => '2020-09-15',
        'completed' => TRUE
    ],
    [
        'title' => 'Create Your First PHP Web Page',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703943_1',
        'due_date' => '2020-09-17',
        'completed' => TRUE
    ],
    [
        'title' => 'Create a PHP Page That Uses Loops, Functions and Arrays',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703946_1',
        'due_date' => '2020-10-01',
        'completed' => TRUE
    ],
    [
        'title' => 'Create and Populate a MySQL Table',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703952_1',
        'due_date' => '2020-11-05',
        'completed' => TRUE
    ],
    [
        'title' => 'Create an HTML/PHP Table From a MySQL Table',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703958_1',
        'due_date' => '2020-11-10',
        'completed' => TRUE
    ],
    [
        'title' => 'Create a PHP/JavaScript/MySQL AJAX Page',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703967_1',
        'due_date' => '2020-11-12',
        'completed' => TRUE
    ],
    [
        'title' => 'Create a PHP Form That Populates a MySQL Database',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703958_1',
        'due_date' => '2020-11-17',
        'completed' => TRUE
    ],
    [
        'title' => 'Create a User Registration Site',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703964_1',
        'due_date' => '2020-11-24',
        'completed' => TRUE
    ],
    [
        'title' => 'Create a User Login Site',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703972_1',
        'due_date' => '2020-12-03',
        'completed' => TRUE
    ],
    [
        'title' => 'Create a PHP Page That Reads and Writes a File',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703949_1',
        'due_date' => '2020-12-01',
        'completed' => TRUE
    ],
    [
        'title' => 'Create an Admin Web Site',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703974_1',
        'due_date' => '2020-12-10',
        'completed' => FALSE
    ],
    [
        'title' => 'Create a Web Page to Access OpenData',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703976_1',
        'due_date' => '2020-12-10',
        'completed' => FALSE
    ],
    [
        'title' => 'Create a CIS475Course Web Page That Uses Object-Oriented Programming',
        'url' => 'https://buffalostate.open.suny.edu/webapps/blackboard/content/listContent.jsp?course_id=_75472_1&content_id=_1703984_1',
        'due_date' => '2020-12-10',
        'completed' => FALSE
    ],
];
$monthsArray = [];
