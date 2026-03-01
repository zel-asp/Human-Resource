<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>hr · flow · tasks </title>
        <link rel="stylesheet" href="/assets/css/output.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>

    <body class="antialiased text-gray-700 bg-amber-200">
        <?php require base_path('view/partials/message.php'); ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <!-- Header Section -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <div class="flex items-center gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Employee Self Service</h1>
                        <p class="text-sm text-gray-500 mt-0.5">
                            Welcome back, <span class="font-medium text-primary">
                                <?= htmlspecialchars(explode(' ', $employeeInfo['full_name'] ?? 'Employee')[0]) ?>
                            </span> ·
                            ID
                            <?= htmlspecialchars($employeeInfo['employee_number'] ?? 'N/A') ?>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span
                        class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 bg-white rounded-md text-sm shadow-sm border border-gray-200">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        clocked in · 09:14
                    </span>

                    <!-- Logout Form -->
                    <form method="POST" action="/logout">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <button type="submit"
                            class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition shadow-sm">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Personal Details Card -->
                    <div
                        class="bg-white border border-gray-200 rounded-md p-5 flex flex-wrap items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="bg-[#e7edf5] p-3 rounded-md hidden sm:block">
                                <i class="fa-solid fa-id-card text-primary text-2xl"></i>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">personal details</p>
                                <div class="flex flex-wrap gap-x-6 gap-y-1 mt-1">
                                    <span class="text-sm">
                                        <span class="font-medium text-gray-700">Dept:</span>
                                        <?= htmlspecialchars($employeeInfo['department'] ?? 'N/A') ?>
                                    </span>
                                    <span class="text-sm">
                                        <span class="font-medium text-gray-700">Manager:</span>
                                        <?= htmlspecialchars($employeeInfo['manager'] ?? 'Sarah V.') ?>
                                    </span>
                                    <!-- In the personal details section, line ~76 -->
                                    <span class="text-sm">
                                        <span class="font-medium text-gray-700">Start:</span>
                                        <?= isset($employeeInfo['start_date']) && $employeeInfo['start_date'] ? date('d M Y', strtotime($employeeInfo['start_date'])) : 'Not set' ?>
                                    </span>
                                    <span class="text-sm">
                                        <span class="font-medium text-gray-700">ID:</span>
                                        <?= htmlspecialchars($employeeInfo['employee_number'] ?? 'N/A') ?>
                                    </span>
                                </div>

                                <!-- Onboarding status indicator -->
                                <?php if (!empty($employeeInfo['onboarding_status'])): ?>
                                    <div class="mt-2">
                                        <span class="text-xs px-2 py-1 rounded-full 
                                        <?php
                                        switch ($employeeInfo['onboarding_status']) {
                                            case 'Onboarded':
                                                $statusClass = 'bg-green-50 text-green-700';
                                                break;
                                            case 'In Progress':
                                                $statusClass = 'bg-blue-50 text-blue-700';
                                                break;
                                            default:
                                                $statusClass = 'bg-amber-50 text-amber-700';
                                        }
                                        echo $statusClass;
                                        ?>">
                                            <i class="fa-solid fa-circle-check mr-1"></i>
                                            <?= htmlspecialchars($employeeInfo['onboarding_status']) ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button id="openProfileModalBtn" onclick="openModal('profileModal')"
                                class="text-primary text-sm font-medium bg-[#e7edf5] px-4 py-2 rounded-md hover:bg-[#d9e2ed] transition">
                                <i class="fa-solid fa-eye mr-1"></i>view profile
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Requests Stats Card -->
                        <div class="stat-card bg-white border border-gray-200 rounded-md p-5 shadow-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 text-sm">Leave requests</span>
                                <span class="bg-[#f5efe2] text-[#996e2e] p-1.5 rounded-md">
                                    <i class="fa-solid fa-clipboard"></i>
                                </span>
                            </div>

                            <!-- Three Column Stats -->
                            <div class="grid grid-cols-3 gap-2 mt-3 text-center">
                                <!-- Pending -->
                                <div class="bg-amber-50 rounded-lg p-2">
                                    <p class="text-2xl font-bold text-amber-600">
                                        <?= $leaveStats['pending_count'] ?? 0 ?>
                                    </p>
                                    <p class="text-xs text-gray-500">pending</p>
                                </div>

                                <!-- Approved -->
                                <div class="bg-green-50 rounded-lg p-2">
                                    <p class="text-2xl font-bold text-green-600">
                                        <?= $leaveStats['approved_count'] ?? 0 ?>
                                    </p>
                                    <p class="text-xs text-gray-500">approved</p>
                                </div>

                                <!-- Total -->
                                <div class="bg-gray-50 rounded-lg p-2">
                                    <p class="text-2xl font-bold text-gray-700">
                                        <?= $leaveStats['total_requests'] ?? 0 ?>
                                    </p>
                                    <p class="text-xs text-gray-500">total</p>
                                </div>
                            </div>

                            <!-- Request Progress Bar -->
                            <?php if (($leaveStats['total_requests'] ?? 0) > 0): ?>
                                <div class="mt-4">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-500">Approval rate</span>
                                        <span class="text-gray-700 font-medium">
                                            <?php $approvalRate = ($leaveStats['total_requests'] > 0) ? round((($leaveStats['approved_count'] ?? 0) / $leaveStats['total_requests']) * 100) : 0; ?>
                                            <?= $approvalRate ?>%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-green-500 h-2.5 rounded-full" style="width: <?= $approvalRate ?>%">
                                        </div>
                                    </div>
                                    <div class="flex justify-between text-xs mt-1">
                                        <span class="text-amber-600"><?= $leaveStats['pending_count'] ?? 0 ?> pending</span>
                                        <?php if (($leaveStats['rejected_count'] ?? 0) > 0): ?>
                                            <span class="text-red-600"><?= $leaveStats['rejected_count'] ?> rejected</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <p class="text-xs text-gray-400 text-center mt-4">No requests submitted yet</p>
                            <?php endif; ?>
                        </div>

                        <!-- Task Progress Card -->
                        <div class="stat-card bg-white border border-gray-200 rounded-md p-5 shadow-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-500 text-sm">My tasks</span>
                                <span class="bg-[#e0eee5] text-[#2b6b4a] p-1.5 rounded-md">
                                    <i class="fa-solid fa-list-check"></i>
                                </span>
                            </div>

                            <!-- Task Summary -->
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-3xl font-bold text-gray-800">
                                    <?= $taskStats['total_tasks'] ?? 0 ?>
                                    <span class="text-sm font-normal text-gray-400 ml-1">total</span>
                                </p>

                                <!-- Mini Status Circles -->
                                <div class="flex gap-1">
                                    <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                        <span
                                            class="text-sm font-bold text-amber-600"><?= $taskStats['not_started_count'] ?? 0 ?></span>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span
                                            class="text-sm font-bold text-blue-600"><?= $taskStats['ongoing_count'] ?? 0 ?></span>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <span
                                            class="text-sm font-bold text-green-600"><?= $taskStats['completed_count'] ?? 0 ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Overall Progress Bar -->
                            <?php if (($taskStats['total_tasks'] ?? 0) > 0): ?>
                                <div class="mt-4">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-500">Overall progress</span>
                                        <span class="text-gray-700 font-medium">
                                            <?php $taskProgress = round((($taskStats['completed_count'] ?? 0) / $taskStats['total_tasks']) * 100); ?>
                                            <?= $taskProgress ?>%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3">
                                        <?php
                                        $notStartedWidth = ($taskStats['total_tasks'] > 0) ? round((($taskStats['not_started_count'] ?? 0) / $taskStats['total_tasks']) * 100) : 0;
                                        $ongoingWidth = ($taskStats['total_tasks'] > 0) ? round((($taskStats['ongoing_count'] ?? 0) / $taskStats['total_tasks']) * 100) : 0;
                                        $completedWidth = ($taskStats['total_tasks'] > 0) ? round((($taskStats['completed_count'] ?? 0) / $taskStats['total_tasks']) * 100) : 0;
                                        ?>
                                        <div class="flex h-3 rounded-full overflow-hidden">
                                            <?php if ($notStartedWidth > 0): ?>
                                                <div class="bg-amber-400" style="width: <?= $notStartedWidth ?>%"></div>
                                            <?php endif; ?>
                                            <?php if ($ongoingWidth > 0): ?>
                                                <div class="bg-blue-400" style="width: <?= $ongoingWidth ?>%"></div>
                                            <?php endif; ?>
                                            <?php if ($completedWidth > 0): ?>
                                                <div class="bg-green-400" style="width: <?= $completedWidth ?>%"></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Legend -->
                                <div class="flex gap-3 mt-3 text-xs">
                                    <span class="flex items-center gap-1">
                                        <span class="w-2 h-2 bg-amber-400 rounded-full"></span>
                                        <span class="text-gray-500">Not Started
                                            (<?= $taskStats['not_started_count'] ?? 0 ?>)</span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                                        <span class="text-gray-500">Ongoing (<?= $taskStats['ongoing_count'] ?? 0 ?>)</span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                                        <span class="text-gray-500">Done (<?= $taskStats['completed_count'] ?? 0 ?>)</span>
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Urgent Alert -->
                            <?php if (($taskStats['urgent_count'] ?? 0) > 0): ?>
                                <div class="mt-3 bg-red-50 border border-red-100 rounded-md p-2">
                                    <p class="text-xs text-red-600 flex items-center gap-1">
                                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                        <span class="font-medium"><?= $taskStats['urgent_count'] ?></span> urgent
                                        task<?= $taskStats['urgent_count'] > 1 ? 's' : '' ?> need attention
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white border border-gray-200 rounded-md p-5 shadow-sm">
                        <h2 class="text-base font-semibold text-gray-800 mb-3 flex items-center">
                            <span class="title-accent"></span>quick actions
                        </h2>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <button id="openLeaveModalBtn"
                                class="action-tile flex flex-col items-center gap-2 p-4 bg-[#f2f5f9] rounded-md hover:bg-[#e0e9f2] transition group">
                                <span class="bg-white p-2 rounded-md shadow-sm">
                                    <i class="fa-solid fa-calendar-plus fa-lg text-primary"></i>
                                </span>
                                <span class="text-xs font-medium text-gray-700">request leave</span>
                            </button>

                            <button id="openAttendanceModalBtn"
                                class="action-tile flex flex-col items-center gap-2 p-4 bg-[#f2f5f9] rounded-md hover:bg-[#e0e9f2] transition group">
                                <span class="bg-white p-2 rounded-md shadow-sm">
                                    <i class="fa-solid fa-calendar-check fa-lg text-primary"></i>
                                </span>
                                <span class="text-xs font-medium text-gray-700">attendance</span>
                            </button>

                            <button id="openPayslipModalBtn"
                                class="action-tile flex flex-col items-center gap-2 p-4 bg-[#f2f5f9] rounded-md hover:bg-[#e0e9f2] transition group">
                                <span class="bg-white p-2 rounded-md shadow-sm">
                                    <i class="fa-solid fa-file-lines fa-lg text-primary"></i>
                                </span>
                                <span class="text-xs font-medium text-gray-700">payslips</span>
                            </button>

                            <button id="openSettingsModalBtn"
                                class="action-tile flex flex-col items-center gap-2 p-4 bg-[#f2f5f9] rounded-md hover:bg-[#e0e9f2] transition group">
                                <span class="bg-white p-2 rounded-md shadow-sm">
                                    <i class="fa-solid fa-sliders fa-lg text-primary"></i>
                                </span>
                                <span class="text-xs font-medium text-gray-700">settings</span>
                            </button>
                        </div>
                    </div>

                    <!-- Recent Requests / Tasks Tabs -->
                    <div class="bg-white border border-gray-200 rounded-md p-5 shadow-sm">
                        <!-- Tab Headers -->
                        <div class="flex items-center border-b border-gray-200 mb-4">
                            <button id="tabRequestsBtn" class="tab-btn text-sm py-2 px-4 -mb-px transition"
                                data-tab="requests">
                                <i class="fa-solid fa-clipboard mr-1"></i>recent requests
                            </button>
                            <button id="tabTasksBtn" class="tab-btn text-sm py-2 px-4 -mb-px transition"
                                data-tab="tasks">
                                <i class="fas fa-solid fa-list-check mr-1"></i>view tasks
                            </button>
                        </div>

                        <!-- Requests Panel -->
                        <div id="requestsPanel" class="tab-panel">
                            <div class="space-y-3">
                                <?php if (!empty($recentLeaveRequests)): ?>
                                    <?php foreach ($recentLeaveRequests as $request): ?>
                                        <!-- Request Item -->
                                        <div
                                            class="flex items-center justify-between p-3 bg-[#f2f5f9] rounded-md group hover:bg-[#e8eef5] transition">
                                            <div class="flex items-center gap-3 flex-1">
                                                <?php
                                                // Set badge color based on leave type
                                                $badgeClass = 'bg-[#dbeafe] text-primary-hover';
                                                $typeDisplay = strtolower(str_replace(' ', '', $request['leave_type']));

                                                if ($request['leave_type'] == 'Sick Leave') {
                                                    $badgeClass = 'bg-[#f0e7fc] text-[#5940a0]';
                                                } elseif ($request['leave_type'] == 'Personal Day') {
                                                    $badgeClass = 'bg-gray-200 text-gray-800';
                                                } elseif ($request['leave_type'] == 'Remote Work') {
                                                    $badgeClass = 'bg-[#e0eee5] text-[#2b6b4a]';
                                                }

                                                // Status badge color
                                                $statusClass = 'text-amber-700 bg-amber-50'; // Pending
                                                if ($request['status'] == 'Approved') {
                                                    $statusClass = 'text-green-700 bg-green-50';
                                                } elseif ($request['status'] == 'Rejected') {
                                                    $statusClass = 'text-red-700 bg-red-50';
                                                } elseif ($request['status'] == 'Cancelled') {
                                                    $statusClass = 'text-gray-700 bg-gray-100';
                                                }
                                                ?>

                                                <span class="<?= $badgeClass ?> text-xs font-medium px-2.5 py-1 rounded-md">
                                                    <?= $typeDisplay ?>
                                                </span>

                                                <div class="flex-1">
                                                    <p class="text-sm font-medium">
                                                        <?= htmlspecialchars($request['leave_type']) ?> ·
                                                        <?= date('M d', strtotime($request['start_date'])) ?>
                                                        <?php if ($request['start_date'] != $request['end_date']): ?>
                                                            – <?= date('M d', strtotime($request['end_date'])) ?>
                                                        <?php endif; ?>
                                                        (<?= $request['total_days'] ?>
                                                        day<?= $request['total_days'] > 1 ? 's' : '' ?>)
                                                    </p>
                                                    <p class="text-xs text-gray-400">
                                                        submitted <?= date('M d, Y', strtotime($request['created_at'])) ?>
                                                        <?php if (!empty($request['reason'])): ?>
                                                            · <?= htmlspecialchars(substr($request['reason'], 0, 30)) ?>...
                                                        <?php endif; ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <span class="<?= $statusClass ?> px-3 py-1 text-xs font-medium rounded-md">
                                                    <?= $request['status'] ?>
                                                </span>

                                                <?php if ($request['status'] == 'Pending'): ?>
                                                    <button
                                                        class="opacity-0 group-hover:opacity-100 transition bg-red-600 hover:bg-red-700 text-white p-2 rounded-md text-xs"
                                                        onclick="cancelLeaveRequest(<?= $request['id'] ?>)" title="Cancel request">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-8 text-gray-500">
                                        <i class="fa-regular fa-calendar-xmark text-4xl mb-3"></i>
                                        <p>No leave requests found</p>
                                        <p class="text-xs mt-1">Click "request leave" to submit your first request</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <button onclick="openModal('viewAllRequestsModal')" id="viewAllRequestsBtn"
                                class="text-sm text-primary hover:underline hidden sm:block mt-5">
                                view all requests (<?= $leaveStats['total_requests'] ?>)
                            </button>
                        </div>

                        <!-- Tasks Panel -->
                        <div id="tasksPanel" class="tab-panel">
                            <div class="space-y-3">
                                <?php if (!empty($tasks)): ?>
                                    <?php foreach ($tasks as $task): ?>
                                        <!-- Task Item -->
                                        <div class="flex items-center justify-between p-3 bg-[#f2f5f9] rounded-md">
                                            <div class="flex items-center gap-3">
                                                <?php
                                                // Set icon class based on task type
                                                $iconClass = 'fa-solid fa-circle-check';
                                                $bgClass = 'bg-[#e1eaf1] text-primary';

                                                switch ($task['task_type']) {
                                                    case 'training_module':
                                                        $iconClass = 'fa-solid fa-clock';
                                                        $bgClass = 'bg-[#f0e7fc] text-[#5940a0]';
                                                        break;
                                                    case 'paperwork':
                                                        $iconClass = 'fa-solid fa-file-lines';
                                                        $bgClass = 'bg-gray-200 text-gray-800';
                                                        break;
                                                    case 'equipment_setup':
                                                        $iconClass = 'fa-solid fa-circle-check';
                                                        $bgClass = 'bg-[#dbeafe] text-primary-hover';
                                                        break;
                                                }

                                                // Set status badge color
                                                $statusBadgeClass = 'text-amber-700 bg-amber-50';
                                                switch ($task['status']) {
                                                    case 'Ongoing':
                                                        $statusBadgeClass = 'text-blue-700 bg-blue-50';
                                                        break;
                                                    case 'Completed':
                                                        $statusBadgeClass = 'text-green-700 bg-green-50';
                                                        break;
                                                }
                                                ?>

                                                <span class="<?= $bgClass ?> text-xs font-medium px-2.5 py-1 rounded-md">
                                                    <i class="<?= $iconClass ?> mr-1"></i>
                                                    <?= htmlspecialchars($task['task_type']) ?>
                                                </span>

                                                <div>
                                                    <p class="text-sm font-medium">
                                                        <?= htmlspecialchars($task['task_description']) ?>
                                                    </p>
                                                    <p class="text-xs text-gray-400">
                                                        due <?= date('M j', strtotime($task['due_date'])) ?> ·
                                                        <?= htmlspecialchars($task['priority']) ?> ·
                                                        <?= htmlspecialchars($task['assigned_staff']) ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-2">
                                                <span class="<?= $statusBadgeClass ?> px-3 py-1 text-xs font-medium rounded-md">
                                                    <?= htmlspecialchars($task['status']) ?>
                                                </span>

                                                <?php if ($task['status'] == 'Not Started'): ?>
                                                    <!-- Start Button Form - Only for Not Started -->
                                                    <form method="POST" action="/tasks/start">
                                                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                        <input type="hidden" name="csrf_token"
                                                            value="<?= $_SESSION['csrf_token'] ?>">
                                                        <input type="hidden" name="__method" value="PATCH">
                                                        <input type="hidden" name="action" value="start">
                                                        <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                        <button type="submit"
                                                            class="bg-blue-600 text-white px-3 py-1 rounded-md text-xs hover:bg-blue-700 transition">
                                                            Start
                                                        </button>
                                                    </form>
                                                <?php endif; ?>

                                                <?php if ($task['status'] == 'Ongoing'): ?>
                                                    <!-- Done Button Form - Only for Ongoing -->
                                                    <form method="POST" action="/tasks/complete">
                                                        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                                                        <input type="hidden" name="csrf_token"
                                                            value="<?= $_SESSION['csrf_token'] ?>">
                                                        <input type="hidden" name="__method" value="PATCH">
                                                        <input type="hidden" name="action" value="complete">
                                                        <input type="hidden" name="redirect" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                        <button type="submit"
                                                            class="bg-green-600 text-white px-3 py-1 rounded-md text-xs hover:bg-green-700 transition">
                                                            Done
                                                        </button>
                                                    </form>
                                                <?php elseif ($task['status'] == 'Completed'): ?>
                                                    <!-- Disabled Done Button - Only for Completed -->
                                                    <button
                                                        class="bg-gray-400 text-white px-3 py-1 rounded-md text-xs cursor-not-allowed"
                                                        disabled>
                                                        Done
                                                    </button>
                                                <?php endif; ?>
                                                <!-- No button shown for Not Started (only Start button) -->
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-8 text-gray-500">
                                        <i class="fa-solid fa-circle-check text-4xl mb-3"></i>
                                        <p>No tasks assigned yet</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button onclick="openModal('viewAllTasksModal')" id="viewAllTasksBtn"
                                class="inline-block text-sm text-primary hover:underline hidden sm:block mt-5">
                                view all tasks
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Current Shift Card -->
                    <div class="bg-primary rounded-md p-5 text-white shadow-sm" id="attendanceCard">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-blue-100 text-xs font-medium tracking-wider" id="shiftStatus">
                                    <?php if ($attendanceStatus == 'clocked_in'): ?>
                                        CURRENT SHIFT
                                    <?php elseif ($attendanceStatus == 'paused'): ?>
                                        PAUSED
                                    <?php else: ?>
                                        READY TO CLOCK IN
                                    <?php endif; ?>
                                </p>
                                <div class="text-3xl font-semibold mt-1 flex items-end gap-2" id="timerDisplay">
                                    <?php
                                    $hours = floor($elapsedSeconds / 3600);
                                    $minutes = floor(($elapsedSeconds % 3600) / 60);
                                    $seconds = $elapsedSeconds % 60;
                                    ?>
                                    <span id="hours"><?= str_pad($hours, 2, '0', STR_PAD_LEFT) ?></span>
                                    <span class="text-xl">:</span>
                                    <span id="minutes"><?= str_pad($minutes, 2, '0', STR_PAD_LEFT) ?></span>
                                    <span class="text-xl">:</span>
                                    <span id="seconds"><?= str_pad($seconds, 2, '0', STR_PAD_LEFT) ?></span>
                                    <span class="text-sm font-normal text-blue-200 ml-1" id="ampm"></span>
                                </div>
                                <p class="text-blue-200 text-xs mt-1" id="dateDisplay">
                                    <?= date('D d M Y') ?> · week <?= date('W') ?>
                                </p>
                            </div>
                            <span class="bg-white/20 p-3 rounded-md">
                                <i class="fa-solid fa-clock fa-xl"></i>
                            </span>
                        </div>

                        <div class="flex gap-2 mt-4" id="attendanceButtons">
                            <!-- Clock In Button (shown when not clocked in) -->
                            <button id="clockInBtn"
                                class="flex-1 bg-white text-primary hover:bg-blue-50 py-2 rounded-md text-sm font-medium transition <?= $showClockIn ? '' : 'hidden' ?>"
                                onclick="handleAttendance('clock_in')">
                                <i class="fa-solid fa-right-to-bracket mr-1"></i>Clock In
                            </button>

                            <!-- Pause Button (shown when clocked in) -->
                            <button id="pauseBtn"
                                class="flex-1 bg-white/20 hover:bg-white/30 py-2 rounded-md text-sm font-medium transition <?= ($attendanceStatus == 'clocked_in') ? '' : 'hidden' ?>"
                                onclick="handleAttendance('pause')">
                                <i class="fa-solid fa-pause mr-1"></i>Pause
                            </button>

                            <!-- Resume Button (shown when paused) -->
                            <button id="resumeBtn"
                                class="flex-1 bg-white/20 hover:bg-white/30 py-2 rounded-md text-sm font-medium transition <?= ($attendanceStatus == 'paused') ? '' : 'hidden' ?>"
                                onclick="handleAttendance('resume')">
                                <i class="fa-solid fa-play mr-1"></i>Resume
                            </button>

                            <!-- Clock Out Button (shown when clocked in or paused) -->
                            <button id="clockOutBtn"
                                class="flex-1 bg-white text-primary hover:bg-blue-50 py-2 rounded-md text-sm font-medium transition <?= ($attendanceStatus != 'clocked_out') ? '' : 'hidden' ?>"
                                onclick="handleAttendance('clock_out')">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i>Clock Out
                            </button>
                        </div>

                        <!-- Overtime Indicator -->
                        <div id="overtimeIndicator"
                            class="mt-2 text-xs text-yellow-300 <?= ($elapsedSeconds >= 28800) ? '' : 'hidden' ?>">
                            <i class="fa-solid fa-clock mr-1"></i>
                            <span id="overtimeHours"><?= floor(($elapsedSeconds - 28800) / 3600) ?></span>h overtime
                        </div>

                        <!-- Current Shift Info -->
                        <div id="shiftInfo"
                            class="mt-2 text-xs text-blue-200 <?= ($attendanceStatus != 'clocked_out') ? '' : 'hidden' ?>">
                            <i class="fa-regular fa-circle-play mr-1"></i>
                            <span id="shiftStartTime">
                                <?php if ($currentAttendance && isset($currentAttendance['clock_in'])): ?>
                                    Started at <?= date('g:i A', strtotime($currentAttendance['clock_in'])) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <!-- HR Announcements -->
                    <div class="bg-white border border-gray-200 rounded-md p-5 shadow-sm">
                        <div class="flex items-center justify-between mb-3">
                            <h2 class="text-sm font-semibold text-gray-700 flex items-center">
                                <span class="title-accent"></span>HR announcements
                            </h2>
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-md">2 new</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex gap-3">
                                <span class="bg-[#ecf3fa] h-fit p-1.5 rounded-md">
                                    <i class="fa-solid fa-pen-to-square text-primary"></i>
                                </span>
                                <div>
                                    <p class="text-sm font-medium">Open enrollment ends Fri</p>
                                    <p class="text-xs text-gray-400">benefits</p>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <span class="bg-[#fcf0e0] h-fit p-1.5 rounded-md">
                                    <i class="fa-solid fa-newspaper text-[#b26023]"></i>
                                </span>
                                <div>
                                    <p class="text-sm font-medium">Q4 townhall · wed 2pm</p>
                                    <p class="text-xs text-gray-400">mandatory</p>
                                </div>
                            </div>
                        </div>
                        <button
                            class="w-full mt-4 text-xs text-primary bg-[#e7edf5] py-2 rounded-md hover:bg-[#d9e2ed] transition">
                            <i class="fa-solid fa-check-circle mr-1"></i>mark read
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modals -->
        <?php require base_path('view/ess/modals/profile.php'); ?>
        <?php require base_path('view/ess/modals/leave.php'); ?>
        <?php require base_path('view/ess/modals/attendance.php'); ?>
        <?php require base_path('view/ess/modals/payslip.php'); ?>
        <?php require base_path('view/ess/modals/setting.php'); ?>
        <?php require base_path('view/ess/modals/allRequest.php'); ?>
        <?php require base_path('view/ess/modals/allTask.php'); ?>
        <?php require base_path('view/ess/modals/allAttendance.php'); ?>

        <script>
            window.attendanceConfig = {
                currentAttendanceId: <?= json_encode($currentAttendance['id'] ?? null) ?>,
                currentStatus: '<?= $attendanceStatus ?>',
                pauseTotal: <?= $pauseTotal ?>,
                elapsedSeconds: <?= $elapsedSeconds ?>,
                csrfToken: '<?= $_SESSION['csrf_token'] ?>',
                <?php if ($currentAttendance && isset($currentAttendance['clock_in'])): ?>
                            shiftStartTime: '<?= $currentAttendance['clock_in'] ?>'
        <?php endif; ?>
            };
        </script>

        <script src="/assets/js/timeInOut.js"></script>
        <script src="/assets/js/ess.js"></script>

    </body>

</html>