<?php
// AUTHENTICATION ROUTES
$router->get('/login', 'controller/auth/login.php');
$router->post('/employee-login', 'controller/auth/employee.php');
$router->post('/logout', 'controller/auth/logout.php');

// MAIN DASHBOARD & JOB MANAGEMENT
$router->get('/', 'controller/ess/get/ess.php');
$router->get('/main', 'controller/main/get/main.php');


$router->post('/postJob', 'controller/main/post/createJob.php');
$router->patch('/update-job', 'controller/main/update/editJob.php');
$router->delete('/delete-job', 'controller/main/destroy/deleteJob.php');

$router->get('/jobPosting', 'controller/jobs/get/jobPost.php');
$router->post('/submitApplication', 'controller/jobs/post/insertApplication.php');

// APPLICANT MANAGEMENT
$router->delete('/deleteApplicant', 'controller/main/destroy/deleteApplicant.php');
$router->patch('/updateApplicantStatus', 'controller/main/update/updateApplicantStatus.php');

// TASK MANAGEMENT
$router->patch('/tasks/complete', 'controller/ess/update/taskCompleted.php');
$router->patch('/tasks/start', 'controller/ess/update/taskStarted.php');
$router->post('/assignTask', 'controller/main/post/assignTask.php');
$router->delete('/delete-task', 'controller/main/destroy/deleteTask.php');

// EMPLOYEE MANAGEMENT
$router->post('/generate-employee-account', 'controller/main/post/generate_account.php');
$router->post('/make-regular-employee', 'controller/main/post/make-regular-employee.php');

// PERFORMANCE MANAGEMENT
$router->post('/save-performance-evaluation', 'controller/main/post/performanceEvaluation.php');
$router->delete('/delete-evaluation', 'controller/main/destroy/deleteEvaluation.php');
$router->post('/create-performance-improvement-plan', 'controller/main/post/pip.php');
$router->patch('/update-performance-improvement-plan', 'controller/main/update/updatePip.php');

// BENEFITS & LEAVE
$router->post('/benefits/enroll', 'controller/main/post/enrollBenefits.php');
$router->post('/leave_request', 'controller/ess/post/leaveRequest.php');
$router->delete('/remove-request', 'controller/ess/delete/leaveDelete.php');

// ATTENDANCE
$router->post('/attendance/handle', 'controller/ess/post/attendance.php');

//LEAVE
$router->patch('/leave/deny', 'controller/main/update/leave-deny.php');
$router->patch('/leave/approve', 'controller/main/update/leave-approved.php');

//COMPETENCY
$router->post('/competency-assessment', 'controller/main/post/competency.php');

//TRAINING
$router->post('/addTraining', 'controller/main/post/addTraining.php');

//COMPENSATION
$router->post('/add-compensation', 'controller/main/post/addCompensation.php');

//CORE
$router->patch('/update-employee', 'controller/main/update/updateEmployeeInfo.php');

//Claims
$router->post('/submit-claims', 'controller/ess/post/submitClaims.php');

