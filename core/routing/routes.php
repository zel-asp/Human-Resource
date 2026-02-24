<?php

$router->get('/', 'controller/ess/test.php');

$router->get('/login', 'controller/auth/login.php');

$router->get('/main', 'controller/main/get/main.php');
$router->post('/postJob', 'controller/main/post/createJob.php');
$router->patch('/update-job', 'controller/main/update/editJob.php');

$router->get('/jobPosting', 'controller/jobs/get/jobPost.php');
$router->post('/submitApplication', 'controller/jobs/post/insertApplication.php');