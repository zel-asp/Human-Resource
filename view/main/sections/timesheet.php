<div class="tab-content" id="timesheet-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Timesheet Management</h2>
            <p class="text-gray-500 text-sm mt-1">Review and approve employee timesheets</p>
        </div>
        <div class="flex gap-2">
            <button class="btn-primary" onclick="approveAllTimesheets()">
                <i class="fas fa-check-circle"></i>
                Approve All
            </button>
        </div>
    </div>

    <!-- Period Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Period</p>
                    <p class="text-lg font-semibold text-gray-800"><?= $filterLabel ?></p>
                    <?php if ($timesheetFilter !== 'all'): ?>
                        <p class="text-xs text-gray-400 mt-1"><?= date('M j', strtotime($dateRangeStart)) ?> -
                            <?= date('M j, Y', strtotime($dateRangeEnd)) ?>
                        </p>
                    <?php else: ?>
                        <p class="text-xs text-gray-400 mt-1">All historical records</p>
                    <?php endif; ?>
                </div>
                <?php if ($filterApplied): ?>
                    <a href="?timesheet_filter=all&timesheet_page=1&tab=timesheet"
                        class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-600 px-2 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                        <i class="fas fa-times"></i>
                        Clear
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Hours</p>
            <p class="text-2xl font-bold text-gray-800"><?= number_format($totalHoursPeriod, 1) ?></p>
            <div class="flex gap-3 mt-1 text-xs text-gray-500">
                <span>Regular: <?= number_format($totalRegularPeriod, 1) ?></span>
                <span>|</span>
                <span>OT: <?= number_format($totalOvertimePeriod, 1) ?></span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Employees with Hours</p>
            <p class="text-2xl font-bold text-gray-800"><?= $employeesWithHours ?></p>
            <p class="text-xs text-gray-400 mt-1">Out of <?= $totalTimesheets ?> active employees</p>
        </div>
    </div>

    <!-- Main Timesheet Card -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <!-- Filter and Pagination Controls -->
        <div
            class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2">
                    <label class="text-xs font-medium text-gray-500">Filter:</label>
                    <select
                        class="text-sm bg-white border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                        onchange="window.location.href = '?timesheet_filter=' + this.value + '&timesheet_page=1&tab=timesheet'">
                        <option value="all" <?= $timesheetFilter == 'all' ? 'selected' : '' ?>>All Time</option>
                        <option value="this_week" <?= $timesheetFilter == 'this_week' ? 'selected' : '' ?>>This Week
                        </option>
                        <option value="last_week" <?= $timesheetFilter == 'last_week' ? 'selected' : '' ?>>Last Week
                        </option>
                        <option value="this_month" <?= $timesheetFilter == 'this_month' ? 'selected' : '' ?>>This Month
                        </option>
                    </select>
                </div>

                <?php if ($filterApplied): ?>
                    <a href="?timesheet_filter=all&timesheet_page=1&tab=timesheet"
                        class="text-xs text-gray-500 hover:text-gray-700 bg-white border border-gray-200 px-2 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                        <i class="fas fa-times-circle"></i>
                        Clear filter
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($totalTimesheetPages > 1): ?>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500">Page <?= $timesheetPage ?> of <?= $totalTimesheetPages ?></span>
                    <div class="flex gap-1">
                        <?php if ($timesheetPage > 1): ?>
                            <a href="?timesheet_filter=<?= $timesheetFilter ?>&timesheet_page=<?= $timesheetPage - 1 ?>"
                                class="w-7 h-7 flex items-center justify-center text-xs rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($timesheetPage < $totalTimesheetPages): ?>
                            <a href="?timesheet_filter=<?= $timesheetFilter ?>&timesheet_page=<?= $timesheetPage + 1 ?>&tab=timesheet"
                                class="w-7 h-7 flex items-center justify-center text-xs rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Active Filter Indicator -->
        <?php if ($filterApplied): ?>
            <div
                class="mx-6 mt-4 p-3 bg-gray-50 border border-gray-200 rounded-lg flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="fas fa-filter text-gray-400"></i>
                    <span>Active filter: <span class="font-medium text-gray-800"><?= $filterLabel ?></span>
                        <span class="text-gray-400 text-xs ml-1">(<?= date('M j', strtotime($dateRangeStart)) ?> -
                            <?= date('M j, Y', strtotime($dateRangeEnd)) ?>)</span>
                    </span>
                </div>
                <a href="?timesheet_filter=all&timesheet_page=1&tab=timesheet"
                    class="text-xs bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center gap-1">
                    <i class="fas fa-times"></i>
                    Remove filter
                </a>
            </div>
        <?php endif; ?>

        <!-- Timesheets Table -->
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Department</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Week Ending</th>
                            <th class="text-right py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Regular Hours</th>
                            <th class="text-right py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Overtime</th>
                            <th class="text-right py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Hours</th>
                            <th
                                class="text-center py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="text-center py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($timesheets)): ?>
                            <?php foreach ($timesheets as $timesheet):
                                $totalHours = $timesheet['regular_hours'] + $timesheet['overtime_hours'];
                                $weekEnding = $timesheet['last_attendance_date'] ? date('M j, Y', strtotime($timesheet['last_attendance_date'])) : 'No records';

                                // Determine status
                                if ($totalHours == 0) {
                                    $status = 'No Hours';
                                    $statusClass = 'bg-gray-100 text-gray-600 border border-gray-200';
                                } elseif ($timesheet['timesheet_status'] == 'Approved') {
                                    $status = 'Approved';
                                    $statusClass = 'bg-green-50 text-green-700 border border-green-200';
                                } else {
                                    $status = 'Pending';
                                    $statusClass = 'bg-yellow-50 text-yellow-700 border border-yellow-200';
                                }
                                ?>
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-800"><?= htmlspecialchars($timesheet['full_name']) ?>
                                        </div>
                                        <div class="text-xs text-gray-400"><?= htmlspecialchars($timesheet['position'] ?? '') ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">
                                        <?= htmlspecialchars($timesheet['department'] ?? 'N/A') ?>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600"><?= $weekEnding ?></td>
                                    <td class="py-3 px-4 text-right text-sm font-medium text-gray-800">
                                        <?= number_format($timesheet['regular_hours'], 1) ?>
                                    </td>
                                    <td
                                        class="py-3 px-4 text-right text-sm font-medium <?= $timesheet['overtime_hours'] > 0 ? 'text-gray-800' : 'text-gray-400' ?>">
                                        <?= number_format($timesheet['overtime_hours'], 1) ?>
                                    </td>
                                    <td class="py-3 px-4 text-right text-sm font-semibold text-gray-800">
                                        <?= number_format($totalHours, 1) ?>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex justify-center">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                                <?= $status ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-center gap-3">
                                            <button
                                                class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1"
                                                onclick="viewTimesheet(<?= $timesheet['employee_id'] ?>, '<?= htmlspecialchars($timesheet['full_name']) ?>')">
                                                <i class="fas fa-eye text-xs"></i>
                                                View
                                            </button>
                                            <?php if ($status != 'Approved' && $totalHours > 0): ?>
                                                <button
                                                    class="text-sm text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1 border border-green-200"
                                                    onclick="approveTimesheet(<?= $timesheet['employee_id'] ?>, '<?= htmlspecialchars($timesheet['full_name']) ?>')">
                                                    <i class="fas fa-check text-xs"></i>
                                                    Approve
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-clock text-4xl mb-3 text-gray-300"></i>
                                        <p class="text-base font-medium text-gray-600">No timesheets found</p>
                                        <p class="text-sm text-gray-400 mt-1">No timesheet records available for the
                                            selected period</p>
                                        <?php if ($filterApplied): ?>
                                            <a href="?timesheet_filter=all&timesheet_page=1&tab=timesheet"
                                                class="mt-4 text-sm text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                                                <i class="fas fa-times"></i>
                                                Clear filter to see all records
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Bottom Pagination -->
            <?php if ($totalTimesheetPages > 1): ?>
                <div class="flex justify-center items-center gap-2 mt-6 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mr-2">Page <?= $timesheetPage ?> of <?= $totalTimesheetPages ?></p>
                    <?php for ($i = 1; $i <= $totalTimesheetPages; $i++): ?>
                        <a href="?timesheet_filter=<?= $timesheetFilter ?>&timesheet_page=<?= $i ?>&tab=timesheet"
                            class="w-8 h-8 flex items-center justify-center text-sm rounded-lg transition-colors duration-200
                            <?= $i == $timesheetPage ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>

            <!-- Summary Footer -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-sm">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="text-gray-600"><span class="font-medium text-gray-800">Total Regular:</span>
                            <?= number_format($totalRegularPeriod, 1) ?> hrs</span>
                        <span class="text-gray-600"><span class="font-medium text-gray-800">Total OT:</span>
                            <?= number_format($totalOvertimePeriod, 1) ?> hrs</span>
                        <span class="text-gray-600"><span class="font-medium text-gray-800">Grand Total:</span>
                            <?= number_format($totalHoursPeriod, 1) ?> hrs</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">Pending</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">Approved</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">No Hours</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>