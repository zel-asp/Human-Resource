<div class="tab-content" id="payroll-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Payroll Management</h2>
            <p class="text-gray-500 text-sm mt-1">Process payroll and manage compensation</p>
        </div>

        <div class="flex items-center gap-1">
            <!-- Status Summary Badges -->
            <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200">
                <span class="inline-flex items-center gap-1.5 text-xs">
                    <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
                    <span class="text-gray-700 font-medium">Approved:</span>
                    <span class="text-gray-900 font-semibold">
                        <?= $payrollApprovedCount ?? 0 ?>
                    </span>
                </span>
                <span class="text-gray-300">|</span>
                <span class="inline-flex items-center gap-1.5 text-xs">
                    <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full"></span>
                    <span class="text-gray-700 font-medium">Pending:</span>
                    <span class="text-gray-900 font-semibold">
                        <?= $payrollPendingCount ?? 0 ?>
                    </span>
                </span>
                <span class="text-gray-300">|</span>
                <span class="inline-flex items-center gap-1.5 text-xs">
                    <span class="w-2.5 h-2.5 bg-blue-500 rounded-full"></span>
                    <span class="text-gray-700 font-medium">Total:</span>
                    <span class="text-gray-900 font-semibold">
                        <?= $payrollTotalEmployees ?? 0 ?>
                    </span>
                </span>
            </div>

            <!-- Process All Button with Status -->
            <form action="/process-all-payroll" method="POST" class="relative group">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                <input type="hidden" name="process_all" value="1">
                <input type="hidden" name="period_start" value="<?= $payrollPeriodStart ?>">
                <input type="hidden" name="period_end" value="<?= $payrollPeriodEnd ?>">

                <?php
                // Calculate employees ready for processing (approved attendance AND not processed)
                $payrollReadyForProcessing = 0;
                $payrollTotalApproved = 0;

                foreach ($payrollEmployees as $emp) {
                    if ($emp['attendance_summary_status'] == 'approved') {
                        $payrollTotalApproved++;
                        if ($emp['status'] != 'Processed' && $emp['status'] != 'Processing') {
                            $payrollReadyForProcessing++;
                        }
                    }
                }

                $hasReadyData = ($payrollReadyForProcessing > 0);
                $buttonDisabled = !$hasReadyData;
                $buttonTitle = $hasReadyData
                    ? 'Process payroll for ' . $payrollReadyForProcessing . ' employees with approved data'
                    : ($payrollTotalApproved > 0 ? 'All approved attendances have been processed' : 'No approved attendance to process');
                ?>

                <button type="submit" <?= $buttonDisabled ? 'disabled' : '' ?> class="
        <?= $buttonDisabled ? 'bg-gray-300 cursor-not-allowed opacity-60' : 'btn-primary hover:bg-blue-700' ?> px-4
        py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 shadow-sm whitespace-nowrap relative"
                    <?= $buttonDisabled ? 'disabled' : '' ?>
                    onclick="return <?= $hasReadyData ? 'confirm(\'Process payroll for ' . $payrollReadyForProcessing . ' employees with approved data? This may take a moment.\')' : 'false' ?>"
                    title="<?= $buttonTitle ?>">

                    <i class="fas fa-play-circle text-sm"></i>
                    Process All

                    <?php if ($payrollReadyForProcessing > 0): ?>
                        <span class="ml-1 px-1.5 py-0.5 bg-white/20 rounded-full text-xs">
                            <?= $payrollReadyForProcessing ?>
                        </span>
                    <?php endif; ?>
                </button>

                <!-- Tooltip on hover (only shows when button is disabled) -->
                <?php if (!$hasReadyData): ?>
                    <div
                        class="absolute top-full mt-1 right-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                        <div class="bg-gray-800 text-white text-xs rounded-lg py-2 px-3 whitespace-nowrap shadow-lg">
                            <div class="flex items-center gap-2">
                                <?php if ($payrollTotalApproved > 0): ?>
                                    <i class="fas fa-check-circle text-green-400 text-xs"></i>
                                    <span>All approved (<?= $payrollTotalApproved ?>) already processed</span>
                                <?php else: ?>
                                    <i class="fas fa-info-circle text-blue-400 text-xs"></i>
                                    <span>No approved attendance to process</span>
                                <?php endif; ?>
                            </div>
                            <!-- Tooltip arrow -->
                            <div class="absolute -top-1 right-4 w-2 h-2 bg-gray-800 transform rotate-45"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <!-- Payroll Period Info -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-gray-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Current Payroll Period</p>
                    <p class="text-lg font-semibold text-gray-800"><?= $payrollPeriodLabel ?>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500">Payroll Date:</span>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                    <?= date('F j, Y', strtotime($payrollPayDate)) ?>
                </span>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-500">Filter by:</span>
                <select name="payroll_status" onchange="applyPayrollFilter()" class=" text-sm bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none
                focus:ring-2 focus:ring-gray-200">
                    <option value="">All Status</option>
                    <option value="Processed" <?= $payrollStatusFilter == 'Processed' ? 'selected' : '' ?>>Processed
                    </option>
                    <option value="Processing" <?= $payrollStatusFilter == 'Processing' ? 'selected' : '' ?>>Processing
                    </option>
                    <option value="Pending" <?= $payrollStatusFilter == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Rejected" <?= $payrollStatusFilter == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>

                <select name="payroll_department" onchange="applyPayrollFilter()"
                    class="text-sm bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option value="">All Departments</option>
                    <?php foreach ($payrollDepartments as $dept): ?>
                        <option value="<?= htmlspecialchars($dept['department']) ?>"
                            <?= $payrollDepartmentFilter == $dept['department'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['department']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if (!empty($payrollStatusFilter) || !empty($payrollDepartmentFilter)): ?>
                <a href="?tab=payroll&payroll_page=1"
                    class="text-sm text-red-600 hover:text-red-800 flex items-center gap-1">
                    <i class="fas fa-times"></i> Clear
                </a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Payroll Summary Stats -->
    <div class="grid grid-cols-4 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Gross Pay</p>
            <p class="text-xl font-bold text-gray-800"><?= formatPayrollCurrency($payrollTotalGross) ?></p>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Net Pay</p>
            <p class="text-xl font-bold text-gray-800"><?= formatPayrollCurrency($payrollTotalNet) ?></p>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Claims</p>
            <p class="text-xl font-bold text-green-600"><?= formatPayrollCurrency($payrollTotalClaims) ?></p>
        </div>

        <div class=" bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Employees</p>
            <p class="text-xl font-bold text-gray-800">
                <?= $payrollTotalEmployees ?>
            </p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-xs text-green-600"><?= $payrollProcessedCount ?> processed</span>
                <span class=" text-xs text-yellow-600">
                    <?= $payrollPendingCount ?> pending
                </span>
            </div>
        </div>
    </div>

    <!-- Payroll List -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div
            class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-gray-800">Payroll Summary</h3>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500">
                    <?= $payrollTotalEmployees ?> employees
                </span>
                <span class="inline-flex items-center gap-1 text-xs">
                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                    <span class="text-gray-500">Processed:
                        <?= $payrollProcessedCount ?>
                    </span>
                </span>
                <span class="inline-flex items-center gap-1 text-xs">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                    <span class="text-gray-500">Pending:
                        <?= $payrollPendingCount ?>
                    </span>
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th
                                class="text-left py-3 pl-4 pr-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Employee
                            </th>
                            <th
                                class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Regular Hours
                            </th>
                            <th
                                class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Overtime
                            </th>
                            <th
                                class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Claims
                            </th>
                            <th
                                class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Gross Pay
                            </th>
                            <th
                                class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Deductions
                            </th>
                            <th
                                class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Net Pay
                            </th>
                            <th
                                class="text-left py-3 px-6 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Status
                            </th>
                            <th
                                class="text-left py-3 pl-6 pr-4 text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($payrollEmployees)): ?>
                            <?php foreach ($payrollEmployees as $emp): ?>
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="py-3 pl-4 pr-6">
                                        <div class="flex items-center gap-3 min-w-45">
                                            <div
                                                class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-xs font-medium shrink-0">
                                                <?= $emp['initials'] ?>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-800 truncate">
                                                    <?= htmlspecialchars($emp['full_name']) ?>
                                                </p>
                                                <p class="text-xs text-gray-400 truncate">
                                                    <?= htmlspecialchars($emp['position']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Regular Hours Column with Indicator -->
                                    <td class="py-3 px-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-gray-600 font-medium whitespace-nowrap">
                                                <?= round($emp['total_regular_hours']) ?> hrs
                                            </span>
                                            <?php if ($emp['total_regular_hours'] == 0 && $emp['attendance_summary_status'] == 'none'): ?>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">No attendance summary</span>
                                            <?php elseif ($emp['attendance_summary_status'] == 'pending'): ?>
                                                <span class="text-xs text-yellow-500 whitespace-nowrap">Pending approval</span>
                                            <?php elseif ($emp['attendance_summary_status'] == 'rejected'): ?>
                                                <span class="text-xs text-red-500 whitespace-nowrap">Rejected</span>
                                            <?php elseif (
                                                $emp['total_regular_hours'] == 0 && $emp['attendance_summary_status'] ==
                                                'approved'
                                            ): ?>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">0 hrs approved</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Overtime Hours Column -->
                                    <td class="py-3 px-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-gray-600 font-medium whitespace-nowrap">
                                                <?= round($emp['total_overtime_hours']) ?> hrs
                                            </span>
                                            <?php if ($emp['total_overtime_hours'] == 0 && $emp['attendance_summary_status'] == 'approved'): ?>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">No overtime</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Claims Column -->
                                    <td class="py-3 px-6">
                                        <?php if ($emp['claims_count'] > 0): ?>
                                            <div class="flex flex-col min-w-25">
                                                <span class="text-sm font-medium text-green-600 whitespace-nowrap">
                                                    <?= formatPayrollCurrency($emp['claims_amount']) ?>
                                                </span>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">
                                                    <?= $emp['claims_count'] ?> claim
                                                    <?= $emp['claims_count'] > 1 ? 's' : '' ?>
                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <div class="flex flex-col">
                                                <span class="text-sm text-gray-400">—</span>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">No claims</span>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Gross Pay Column -->
                                    <td class="py-3 px-6">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-800 whitespace-nowrap">
                                                <?= formatPayrollCurrency($emp['gross_pay']) ?>
                                            </span>
                                            <?php if ($emp['gross_pay'] == 0): ?>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">No earnings</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Deductions Column -->
                                    <td class="py-3 px-6">
                                        <span class="text-sm text-gray-600 whitespace-nowrap">
                                            <?= formatPayrollCurrency($emp['total_deductions']) ?>
                                        </span>
                                    </td>

                                    <!-- Net Pay Column -->
                                    <td class="py-3 px-6">
                                        <div class="flex flex-col min-w-30">
                                            <span class="text-sm font-semibold text-gray-800 whitespace-nowrap">
                                                <?= formatPayrollCurrency($emp['net_pay']) ?>
                                            </span>
                                            <?php if ($emp['claims_amount'] > 0): ?>
                                                <span class="text-xs text-green-600 whitespace-nowrap">
                                                    (inc. <?= formatPayrollCurrency($emp['claims_amount']) ?> claims)
                                                </span>
                                            <?php elseif ($emp['net_pay'] == 0): ?>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">No net pay</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Status Column with Detailed Indicators -->
                                    <td class="py-3 px-6">
                                        <?php
                                        // Determine status badge color
                                        $statusBadgeClass = '';
                                        $statusIcon = '';

                                        if ($emp['status'] == 'Processed') {
                                            $statusBadgeClass = 'bg-green-100 text-green-700 border-green-200';
                                            $statusIcon = 'fa-check-circle';
                                        } elseif ($emp['status'] == 'Processing') {
                                            $statusBadgeClass = 'bg-blue-100 text-blue-700 border-blue-200';
                                            $statusIcon = 'fa-clock';
                                        } elseif ($emp['status'] == 'Pending') {
                                            $statusBadgeClass = 'bg-yellow-100 text-yellow-700 border-yellow-200';
                                            $statusIcon = 'fa-hourglass-half';
                                        } else {
                                            $statusBadgeClass = 'bg-gray-100 text-gray-600 border-gray-200';
                                            $statusIcon = 'fa-circle';
                                        }
                                        ?>
                                        <div class="flex flex-col gap-1">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium border whitespace-nowrap <?= $statusBadgeClass ?>">
                                                <i class="fas <?= $statusIcon ?> mr-1.5"></i>
                                                <?= $emp['status'] ?>
                                            </span>

                                            <!-- Additional Status Indicators -->
                                            <?php if ($emp['status'] == 'No Data'): ?>
                                                <span class="text-xs text-gray-400 whitespace-nowrap">No attendance or claims</span>
                                            <?php elseif ($emp['status'] == 'Pending'): ?>
                                                <?php if ($emp['attendance_summary_status'] == 'pending'): ?>
                                                    <span class="text-xs text-yellow-500 whitespace-nowrap">Awaiting attendance
                                                        approval</span>
                                                <?php elseif ($emp['attendance_summary_status'] == 'none' && $emp['claims_count'] > 0): ?>
                                                    <span class="text-xs text-blue-500 whitespace-nowrap">Claims
                                                        only (no
                                                        attendance)</span>
                                                <?php elseif ($emp['attendance_summary_status'] == 'approved'): ?>
                                                    <span class="text-xs text-green-500 whitespace-nowrap">Attendance approved</span>
                                                <?php endif; ?>
                                            <?php elseif ($emp['status'] == 'Processed'): ?>
                                                <span class="text-xs text-green-500 whitespace-nowrap">Payroll completed</span>
                                            <?php elseif ($emp['status'] == 'Processing'): ?>
                                                <span class="text-xs text-blue-500 whitespace-nowrap">Being processed</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Actions Column -->
                                    <td class="py-3 pl-6 pr-4">
                                        <div class="flex items-center gap-2 min-w-[160px]">
                                            <!-- Review Button - Always enabled to view details -->
                                            <button onclick="openModal('payrollReviewModal<?= $emp['id'] ?>')"
                                                class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center gap-1.5 shadow-sm border border-gray-200 whitespace-nowrap">
                                                <i class="fas fa-eye text-xs"></i>
                                                <span>Review</span>
                                            </button>

                                            <?php
                                            // Check if employee has any data to process
                                            $hasAttendanceData = ($emp['total_regular_hours'] > 0 || $emp['total_overtime_hours'] > 0);
                                            $hasClaims = ($emp['claims_amount'] > 0);
                                            $hasAnyData = $hasAttendanceData || $hasClaims;
                                            $hasAttendanceSummary = ($emp['attendance_summary_status'] != 'none');
                                            ?>

                                            <?php if ($emp['status'] == 'Processing'): ?>
                                                <!-- Update button - Only show for Processing status -->
                                                <form action="/payroll-summary" method="POST" class="inline-block">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                                    <input type="hidden" name="employeeId" value="<?= $emp['id'] ?>">
                                                    <input type="hidden" name="regularHours"
                                                        value="<?= round($emp['total_regular_hours']) ?>">
                                                    <input type="hidden" name="overtime"
                                                        value="<?= round($emp['total_overtime_hours']) ?>">
                                                    <input type="hidden" name="claims" value="<?= $emp['claims_amount'] ?>">
                                                    <input type="hidden" name="grossPay" value="<?= $emp['gross_pay'] ?>">
                                                    <input type="hidden" name="deduction" value="<?= $emp['total_deductions'] ?>">
                                                    <input type="hidden" name="netPay" value="<?= $emp['net_pay'] ?>">

                                                    <?php if (!$hasAttendanceSummary && !$hasClaims): ?>
                                                        <!-- Completely disabled - No data at all -->
                                                        <button type="button" disabled class="text-sm text-gray-300 bg-gray-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border
            border-gray-200 cursor-not-allowed whitespace-nowrap"
                                                            title="Cannot update: No attendance summary or claims data">
                                                            <i class="fas fa-ban text-xs"></i>
                                                            <span>No Data</span>
                                                        </button>
                                                    <?php elseif (!$hasAttendanceSummary && $hasClaims): ?>
                                                        <!-- Claims only - Allow update -->
                                                        <button type="submit"
                                                            class="text-sm text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center gap-1.5 shadow-sm border border-blue-200 whitespace-nowrap"
                                                            title="Update payroll (claims only, no attendance summary)">
                                                            <i class="fas fa-sync-alt text-xs"></i>
                                                            <span>Update</span>
                                                        </button>
                                                    <?php elseif ($emp['attendance_summary_status'] == 'pending'): ?>
                                                        <!-- Disabled - Attendance not approved -->
                                                        <button type="button" disabled
                                                            class="text-sm text-yellow-500 bg-yellow-50 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-yellow-200 cursor-not-allowed whitespace-nowrap"
                                                            title="Cannot process: Attendance still pending approval">
                                                            <i class="fas fa-hourglass-half text-xs"></i>
                                                            <span>Pending</span>
                                                        </button>
                                                    <?php elseif ($emp['attendance_summary_status'] == 'rejected'): ?>
                                                        <!-- Disabled - Attendance rejected -->
                                                        <button type="button" disabled class="text-sm text-red-500 bg-red-50 px-3 py-1.5 rounded-lg flex
                items-center gap-1.5 border border-red-200 cursor-not-allowed whitespace-nowrap"
                                                            title="Cannot process: Attendance was rejected">
                                                            <i class="fas fa-times-circle text-xs"></i>
                                                            <span>Rejected</span>
                                                        </button>
                                                    <?php elseif ($hasAttendanceData || $hasClaims): ?>
                                                        <!-- Has data - Allow update -->
                                                        <button type="submit" class="text-sm text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100
                px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center gap-1.5 shadow-sm border
                border-blue-200 whitespace-nowrap">
                                                            <i class="fas fa-sync-alt text-xs"></i>
                                                            <span>Update</span>
                                                        </button>
                                                    <?php else: ?>
                                                        <!-- No data to update -->
                                                        <button type="button" disabled
                                                            class="text-sm text-gray-400 bg-gray-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-gray-200 cursor-not-allowed whitespace-nowrap"
                                                            title="No data to update">
                                                            <i class="fas fa-ban text-xs"></i>
                                                            <span>No Data</span>
                                                        </button>
                                                    <?php endif; ?>
                                                </form>

                                            <?php elseif ($emp['status'] == 'Pending'): ?>
                                                <!-- Process button for new payroll -->
                                                <form action="/payroll-summary" method="POST" class="inline-block">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                                    <input type="hidden" name="employeeId" value="<?= $emp['id'] ?>">
                                                    <input type="hidden" name="regularHours"
                                                        value="<?= round($emp['total_regular_hours']) ?>">
                                                    <input type="hidden" name="overtime"
                                                        value="<?= round($emp['total_overtime_hours']) ?>">
                                                    <input type="hidden" name="claims" value="<?= $emp['claims_amount'] ?>">
                                                    <input type="hidden" name="grossPay" value="<?= $emp['gross_pay'] ?>">
                                                    <input type="hidden" name="deduction" value="<?= $emp['total_deductions'] ?>">
                                                    <input type="hidden" name="netPay" value="<?= $emp['net_pay'] ?>">

                                                    <?php if (!$hasAttendanceSummary && !$hasClaims): ?>
                                                        <!-- Completely disabled - No data at all -->
                                                        <button type="button" disabled class="text-sm text-gray-300 bg-gray-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border
            border-gray-200 cursor-not-allowed whitespace-nowrap"
                                                            title="Cannot process: No attendance summary or claims data">
                                                            <i class="fas fa-ban text-xs"></i>
                                                            <span>No Data</span>
                                                        </button>
                                                    <?php elseif (!$hasAttendanceSummary && $hasClaims): ?>
                                                        <!-- Claims only - Allow process -->
                                                        <button type="submit"
                                                            class="text-sm text-green-500 hover:text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center gap-1.5 shadow-sm border border-green-200 whitespace-nowrap"
                                                            title="Process payroll (claims only, no attendance summary)">
                                                            <i class="fas fa-check text-xs"></i>
                                                            <span>Process</span>
                                                        </button>
                                                    <?php elseif ($emp['attendance_summary_status'] == 'pending'): ?>
                                                        <!-- Disabled - Attendance not approved -->
                                                        <button type="button" disabled
                                                            class="text-sm text-yellow-500 bg-yellow-50 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-yellow-200 cursor-not-allowed whitespace-nowrap"
                                                            title="Cannot process: Attendance still pending approval">
                                                            <i class="fas fa-hourglass-half text-xs"></i>
                                                            <span>Pending</span>
                                                        </button>
                                                    <?php elseif ($emp['attendance_summary_status'] == 'rejected'): ?>
                                                        <!-- Disabled - Attendance rejected -->
                                                        <button type="button" disabled
                                                            class="text-sm text-red-500 bg-red-50 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-red-200 cursor-not-allowed whitespace-nowrap"
                                                            title="Cannot process: Attendance was rejected">
                                                            <i class="fas fa-times-circle text-xs"></i>
                                                            <span>Rejected</span>
                                                        </button>
                                                    <?php elseif ($hasAttendanceData || $hasClaims): ?>
                                                        <!-- Has data - Allow process -->
                                                        <button type="submit"
                                                            class="text-sm text-green-500 hover:text-green-700 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center gap-1.5 shadow-sm border border-green-200 whitespace-nowrap">
                                                            <i class="fas fa-check text-xs"></i>
                                                            <span>Process</span>
                                                        </button>
                                                    <?php else: ?>
                                                        <!-- No data to process -->
                                                        <button type="button" disabled
                                                            class="text-sm text-gray-400 bg-gray-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-gray-200 cursor-not-allowed whitespace-nowrap"
                                                            title="No data to process">
                                                            <i class="fas fa-ban text-xs"></i>
                                                            <span>No Data</span>
                                                        </button>
                                                    <?php endif; ?>
                                                </form>

                                            <?php elseif ($emp['status'] == 'Processed'): ?>
                                                <!-- Show disabled button for Processed status -->
                                                <button type="button" disabled
                                                    class="text-sm text-gray-400 bg-gray-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-gray-200 cursor-not-allowed whitespace-nowrap"
                                                    title="Payroll already processed - cannot be updated">
                                                    <i class="fas fa-lock text-xs"></i>
                                                    <span>Processed</span>
                                                </button>

                                            <?php else: ?>
                                                <!-- Disabled button for No Data status -->
                                                <button disabled
                                                    class="text-sm text-gray-400 bg-gray-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 border border-gray-200 cursor-not-allowed whitespace-nowrap"
                                                    title="No attendance or claims data available">
                                                    <i class="fas fa-ban text-xs"></i>
                                                    <span>No Data</span>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="py-12 text-center text-gray-500">
                                    <i class="fas fa-calculator text-4xl mb-3 text-gray-300"></i>
                                    <p class="text-lg font-medium">No payroll data found</p>
                                    <p class="text-sm">Click "Process Payroll" to generate payroll for this period</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Payroll Summary Footer -->
            <div class="mt-6 pb-4 border-t border-gray-100">
                <div class="grid grid-cols-4 sm:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Total Regular Hours</p>
                        <p class="text-lg font-semibold text-gray-800">
                            <?= round($payrollPageRegularHours) ?> hrs
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Overtime Hours</p>
                        <p class="text-lg font-semibold text-gray-800"><?= round($payrollPageOvertimeHours) ?> hrs
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Claims</p>
                        <p class="text-lg font-semibold text-green-600">
                            <?= formatPayrollCurrency($payrollPageClaimsTotal) ?>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Average Net Pay</p>
                        <p class="text-lg font-semibold text-gray-800">
                            <?= formatPayrollCurrency($payrollPageAverageNet) ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <?php if ($payrollTotalPages > 1): ?>
                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-500">
                        Showing <span
                            class="font-medium"><?= min(1 + ($payrollPage - 1) * $payrollPerPage, $payrollTotalFiltered) ?>-
                            <?= min($payrollPage * $payrollPerPage, $payrollTotalFiltered) ?>
                        </span>
                        of <span class="font-medium">
                            <?= $payrollTotalFiltered ?></span> employees
                    </p>
                    <div class="flex items-center gap-2">
                        <?php if ($payrollPage > 1): ?>
                            <a href="?tab=payroll&payroll_page=<?= $payrollPage - 1 ?>&payroll_status=<?= urlencode($payrollStatusFilter) ?>&payroll_department=<?= urlencode($payrollDepartmentFilter) ?>"
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </a>
                        <?php else: ?>
                            <button class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-400
        cursor-not-allowed" disabled>
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= min(5, $payrollTotalPages); $i++): ?>
                            <a href=" ?tab=payroll&payroll_page=<?= $i ?>&payroll_status=
            <?= urlencode($payrollStatusFilter) ?>&payroll_department=
            <?= urlencode($payrollDepartmentFilter) ?>" class="w-8 h-8 flex items-center justify-center text-sm rounded-lg
            <?= $i == $payrollPage ? 'bg-gray-800 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>
            transition-colors duration-200">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($payrollPage < $payrollTotalPages): ?>
                            <a href="?tab=payroll&payroll_page=<?= $payrollPage + 1 ?>&payroll_status=<?= urlencode($payrollStatusFilter) ?>&payroll_department=<?= urlencode($payrollDepartmentFilter) ?>"
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200
                text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        <?php else: ?>
                            <button class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200
                text-gray-400 cursor-not-allowed" disabled>
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Payroll History Section -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mt-6">
        <div
            class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class=" w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-blue-600"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Payroll History</h3>
            </div>
            <button onclick="exportCurrentPage()"
                class="text-sm text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 border border-green-200">
                <i class="fas fa-file-excel"></i>
                Export Current Period
            </button>
        </div>

        <div class=" p-6">
            <?php if (!empty($payrollHistory)): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php foreach ($payrollHistory as $history):
                        $periodLabel = date('M j', strtotime($history['period_start'])) . ' - ' . date('M j, Y', strtotime($history['period_end']));
                        $isCurrentPeriod = ($history['period_start'] == $payrollPeriodStart && $history['period_end'] == $payrollPeriodEnd);
                        $statusColor = 'gray';
                        $statusIcon = 'fa-circle';

                        if (strpos($history['statuses'], 'Processed') !== false) {
                            $statusColor = 'green';
                            $statusIcon = 'fa-check-circle';
                        } elseif (strpos($history['statuses'], 'Processing') !== false) {
                            $statusColor = 'blue';
                            $statusIcon = 'fa-clock';
                        }
                        ?>
                        <div
                            class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200 <?= $isCurrentPeriod ? 'bg-blue-50/30 border-blue-200' : '' ?>">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        <?= $periodLabel ?>
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <?= date('M j, Y', strtotime($history['last_generated'])) ?>
                                    </p>
                                </div>
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-<?= $statusColor ?>-100 text-<?= $statusColor ?>-700">
                                    <i class="fas <?= $statusIcon ?> mr-1"></i>

                                    <?= $history['employee_count'] ?> employees
                                </span>
                            </div>

                            <div class="flex items-center justify-around p-3">
                                <div>

                                    <p class="text-xs text-gray-400">Gross Pay</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        <?= formatPayrollCurrency($history['total_gross']) ?>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Net Pay</p>
                                    <p class="text-sm font-semibold text-green-600">
                                        <?= formatPayrollCurrency($history['total_net']) ?>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center justify-around pt-2 border-t border-gray-200">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-file-invoice-dollar text-xs text-gray-300"></i>
                                    <span class="text-xs text-gray-400">Claims:
                                        <?= formatPayrollCurrency($history['total_claims']) ?>
                                    </span>
                                </div>
                                <button
                                    onclick="exportPayrollPeriod('<?= $history['period_start'] ?>', '<?= $history['period_end'] ?>')"
                                    class="text-xs text-white flex items-center gap-1 bg-primary py-2 px-4 rounded-sm">
                                    <i class="fas fa-download"></i>
                                    Export
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- View All History Link -->
                <div class="mt-4 text-center">
                    <a href="#" onclick="alert('View full history coming soon!')"
                        class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
                        View All History
                        <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-history text-3xl mb-2"></i>
                    <p class="text-sm">No payroll history yet</p>
                    <p class="text-xs mt-1">Process payroll to see history here</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- Payroll Review Modals -->
<?php if (!empty($payrollEmployees)): ?>
    <?php foreach ($payrollEmployees as $emp): ?>
        <div id="payrollReviewModal<?= $emp['id'] ?>"
            class="modal fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden z-50">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-file-invoice text-gray-600"></i>
                        <h3 class="text-lg font-semibold text-gray-800">Payroll Review -
                            <?= htmlspecialchars($emp['full_name']) ?>
                        </h3>
                    </div>
                    <button onclick="closeModal('payrollReviewModal<?= $emp['id'] ?>')"
                        class="text-gray-400 hover:text-gray-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Employee Info Card -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-sm font-semibold text-blue-700">
                                    <?= $emp['initials'] ?>
                                </span>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-gray-800">
                                    <?= htmlspecialchars($emp['full_name']) ?>
                                </h4>
                                <p class="text-sm text-gray-500">
                                    <?= htmlspecialchars($emp['position']) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payroll Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class=" bg-blue-50 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase mb-1">Regular Hours</p>
                            <p class="text-2xl font-bold text-blue-700">
                                <?= round($emp['total_regular_hours']) ?>
                            </p>
                        </div>
                        <div class="bg-amber-50 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase mb-1">Overtime Hours</p>
                            <p class="text-2xl font-bold text-amber-700">
                                <?= round($emp['total_overtime_hours']) ?>
                            </p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <p class="text-xs text-gray-500 uppercase mb-1">Net Pay</p>
                            <p class="text-2xl font-bold text-green-700">
                                <?= formatPayrollCurrency($emp['net_pay']) ?>
                            </p>
                        </div>
                    </div>

                    <!-- Payroll Details Table -->
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-calculator text-gray-400"></i>
                            Payroll Breakdown
                        </h4>
                        <div class="bg-gray-50 rounded-lg border border-gray-200 overflow-hidden">
                            <table class="w-full">
                                <tbody>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-3 px-4 text-sm text-gray-600">Gross Pay</td>
                                        <td class="py-3 px-4 text-sm font-medium text-gray-800 text-right">
                                            <?= formatPayrollCurrency($emp['gross_pay']) ?>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-3 px-4 text-sm text-gray-600">Claim/s</td>
                                        <td class="py-3 px-4 text-sm font-medium text-gray-800 text-right">
                                            <?= formatPayrollCurrency($emp['claims_amount']) ?>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200">
                                        <td class="py-3 px-4 text-sm text-gray-600">Deductions</td>
                                        <td class="py-3 px-4 text-sm font-medium text-red-600 text-right">-
                                            <?= formatPayrollCurrency($emp['total_deductions']) ?>
                                        </td>
                                    </tr>
                                    <tr class="bg-gray-100">
                                        <td class="py-3 px-4 text-sm font-semibold text-gray-700">Net Pay</td>
                                        <td class="py-3 px-4 text-sm font-bold text-green-700 text-right">
                                            <?= formatPayrollCurrency($emp['net_pay']) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>

                    <!-- Deductions Breakdown -->
                    <div class="mb-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                            <i class="fas fa-minus-circle text-gray-400"></i>
                            Deductions Breakdown
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500">SSS</p>
                                <p class="text-sm font-medium text-gray-800">
                                    <?= formatPayrollCurrency($emp['sss_deduction'] ?? $emp['total_deductions'] * 0.2) ?>
                                </p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500">PhilHealth</p>
                                <p class="text-sm font-medium text-gray-800">
                                    <?= formatPayrollCurrency($emp['philhealth_deduction'] ?? $emp['total_deductions'] * 0.15) ?>
                                </p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3">
                                <p class="text-xs text-gray-500">Pag-IBIG</p>
                                <p class="text-sm font-medium text-gray-800">
                                    <?= formatPayrollCurrency($emp['pagibig_deduction'] ?? $emp['total_deductions'] * 0.15) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="closeModal('payrollReviewModal<?= $emp['id'] ?>')"
                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            Close
                        </button>
                        <button type="button" onclick="printPayslip(<?= $emp['id'] ?>)" class="btn-primary">
                            <i class="fas fa-print"></i>
                            Print Payslip
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>



<script>
    function printPayslip(employeeId) {
        window.print();
    }
    function exportPayrollPeriod(periodStart, periodEnd) {
        window.location.href = '?tab=payroll&export_payroll=1&period_start=' + periodStart + '&period_end=' + periodEnd;
    }

    function exportCurrentPage() {
        const periodStart = '<?= $payrollPeriodStart ?>';
        const periodEnd = '<?= $payrollPeriodEnd ?>';
        exportPayrollPeriod(periodStart, periodEnd);
    }
    function applyPayrollFilter() {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', 'payroll');
        url.searchParams.set('payroll_page', '1');

        const status = document.querySelector('select[name="payroll_status"]')?.value;
        const dept = document.querySelector('select[name="payroll_department"]')?.value;

        if (status) url.searchParams.set('payroll_status', status);
        else url.searchParams.delete('payroll_status');

        if (dept) url.searchParams.set('payroll_department', dept);
        else url.searchParams.delete('payroll_department');

        window.location.href = url.toString();
    }
</script>