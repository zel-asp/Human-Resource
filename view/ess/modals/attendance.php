<!-- Attendance Modal -->
<div id="attendanceModal" class="fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden modal-enter z-50">
    <div class="bg-white rounded-md max-w-2xl w-full mx-4 p-6 shadow-xl max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-5 sticky top-0 bg-white pb-2 border-b">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fa-solid fa-calendar-check mr-2 text-primary"></i>Attendance Summary
            </h3>
            <button class="close-modal text-gray-400 hover:text-gray-600" data-modal="attendanceModal">
                <i class="fa-solid fa-circle-xmark fa-xl"></i>
            </button>
        </div>

        <!-- Current Shift Info -->
        <?php if ($attendanceStatus != 'clocked_out'): ?>
            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                        <span class="text-sm font-medium text-blue-700">
                            Currently <?= $attendanceStatus == 'paused' ? 'Paused' : 'Working' ?>
                        </span>
                    </div>
                    <?php if ($currentAttendance && isset($currentAttendance['clock_in'])): ?>
                        <span class="text-xs text-gray-500">
                            Started: <?= date('g:i A', strtotime($currentAttendance['clock_in'])) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Current Period Summary Card -->
        <div class="mb-4 p-4 bg-primary/5 rounded-lg border border-primary/20">
            <div class="flex justify-between items-center mb-2">
                <p class="text-sm font-medium text-primary"><?= $periodName ?></p>
                <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded-full">Current Period</span>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <span class="text-xs text-gray-500">Regular</span>
                    <p class="text-lg font-semibold">
                        <?php
                        $hours = floor($currentPeriod['regular_hours']);
                        $minutes = round(($currentPeriod['regular_hours'] - $hours) * 60);
                        echo $hours . 'h ' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . 'm';
                        ?>
                    </p>
                </div>
                <div>
                    <span class="text-xs text-gray-500">Overtime</span>
                    <p class="text-lg font-semibold text-amber-600">
                        <?php
                        $hours = floor($currentPeriod['overtime_hours']);
                        $minutes = round(($currentPeriod['overtime_hours'] - $hours) * 60);
                        echo $hours . 'h ' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . 'm';
                        ?>
                    </p>
                </div>
                <div>
                    <span class="text-xs text-gray-500">Late</span>
                    <p class="text-lg font-semibold text-red-600">
                        <?= $currentPeriod['late_minutes'] ?>m
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Stats Grid -->
        <p class="text-gray-500 text-sm mb-2"><?= $currentMonthName ?> Summary</p>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
            <div class="bg-[#f2f5f9] p-3 rounded-md">
                <span class="text-xs text-gray-500">This week</span>
                <p class="text-lg font-semibold">
                    <?= floor($weekTotal) ?>h <?= round(($weekTotal - floor($weekTotal)) * 60) ?>m
                </p>
                <p class="text-xs text-gray-400"><?= $weekStats['days_worked'] ?> days</p>
            </div>

            <div class="bg-[#f2f5f9] p-3 rounded-md">
                <span class="text-xs text-gray-500">Overtime</span>
                <p class="text-lg font-semibold text-amber-600">
                    <?= floor($monthStats['month_overtime']) ?>h
                    <?= round(($monthStats['month_overtime'] - floor($monthStats['month_overtime'])) * 60) ?>m
                </p>
                <p class="text-xs text-gray-400">This month</p>
            </div>

            <div class="bg-[#f2f5f9] p-3 rounded-md">
                <span class="text-xs text-gray-500">Late arrivals</span>
                <p class="text-lg font-semibold <?= $monthStats['late_days'] > 0 ? 'text-red-600' : '' ?>">
                    <?= $monthStats['late_days'] ?> day<?= $monthStats['late_days'] != 1 ? 's' : '' ?>
                </p>
                <p class="text-xs text-gray-400"><?= $monthStats['total_late_minutes'] ?>m total</p>
            </div>
        </div>

        <!-- Detailed Stats Row -->
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="border rounded-lg p-3">
                <span class="text-xs text-gray-500 flex items-center gap-1">
                    <i class="fa-solid fa-clock text-green-500"></i> On time
                </span>
                <p class="text-xl font-semibold">
                    <?= $monthStats['days_worked'] - $monthStats['late_days'] - $monthStats['grace_days'] ?>
                </p>
                <p class="text-xs text-gray-400">days</p>
            </div>
            <div class="border rounded-lg p-3">
                <span class="text-xs text-gray-500 flex items-center gap-1">
                    <i class="fa-solid fa-hourglass-half text-yellow-500"></i> Grace period
                </span>
                <p class="text-xl font-semibold">
                    <?= $monthStats['grace_days'] ?>
                </p>
                <p class="text-xs text-gray-400">days</p>
            </div>
            <div class="border rounded-lg p-3">
                <span class="text-xs text-gray-500 flex items-center gap-1">
                    <i class="fa-solid fa-clock text-orange-500"></i> Early departure
                </span>
                <p class="text-xl font-semibold">
                    <?= $monthStats['early_departure_days'] ?>
                </p>
                <p class="text-xs text-gray-400">days (<?= formatMinutes($monthStats['total_early_minutes']) ?>)</p>
            </div>
            <div class="border rounded-lg p-3">
                <span class="text-xs text-gray-500 flex items-center gap-1">
                    <i class="fa-solid fa-chart-line text-blue-500"></i> Avg. daily
                </span>
                <p class="text-xl font-semibold">
                    <?php
                    $avgDaily = $monthStats['days_worked'] > 0 ? $monthTotal / $monthStats['days_worked'] : 0;
                    echo floor($avgDaily) . 'h ' . round(($avgDaily - floor($avgDaily)) * 60) . 'm';
                    ?>
                </p>
                <p class="text-xs text-gray-400">per working day</p>
            </div>
        </div>

        <!-- Shift Information -->
        <?php if ($employeeShift): ?>
            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                <p class="text-xs font-medium text-gray-500 mb-2">Your Shift Schedule</p>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="text-gray-500">Shift:</span>
                        <span class="font-medium ml-1"><?= $employeeShift['shift_name'] ?? 'Not Assigned' ?></span>
                    </div>
                    <div>
                        <span class="text-gray-500">Schedule:</span>
                        <span class="font-medium ml-1">
                            <?= date('g:i A', strtotime($employeeShift['start_time'])) ?> -
                            <?= date('g:i A', strtotime($employeeShift['end_time'])) ?>
                        </span>
                    </div>
                    <div>
                        <span class="text-gray-500">Grace period:</span>
                        <span class="font-medium ml-1"><?= $employeeShift['grace_period_minutes'] ?? 15 ?> minutes</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Recent Days Breakdown -->
        <?php if (!empty($dailyBreakdown)): ?>
            <div class="mt-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Daily Breakdown</p>
                <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                    <?php foreach ($dailyBreakdown as $day): ?>
                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg text-sm">
                            <div class="flex items-center gap-2">
                                <span class="font-medium"><?= date('M d', strtotime($day['date'])) ?></span>
                                <span class="text-xs text-gray-400"><?= $day['day_name'] ?></span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs">
                                    <?= $day['clock_in_time'] ?> - <?= $day['clock_out_time'] ?? '---' ?>
                                </span>
                                <?php if ($day['late_status'] == 'late'): ?>
                                    <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full">
                                        <?= $day['late_minutes'] ?>m late
                                    </span>
                                <?php elseif ($day['late_status'] == 'grace_period'): ?>
                                    <span class="text-xs bg-yellow-100 text-yellow-600 px-2 py-0.5 rounded-full">
                                        grace
                                    </span>
                                <?php endif; ?>
                                <?php if ($day['early_departure_minutes'] > 0): ?>
                                    <span class="text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">
                                        early <?= $day['early_departure_minutes'] ?>m
                                    </span>
                                <?php endif; ?>
                                <span class="text-xs font-medium">
                                    <?= formatHoursMinutes($day['regular_hours']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Action Buttons - FIXED -->
        <div class="mt-6 flex justify-end gap-2 sticky bottom-0 bg-white pt-2 border-t">
            <!-- View Full History Button (Styled properly) -->
            <a href="/?tab=attendance"
                class="bg-primary/10 text-primary hover:bg-primary/20 px-4 py-2 rounded-md text-sm font-medium transition flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left"></i>
                Full History
            </a>

            <button
                class="close-modal bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-200 transition"
                data-modal="attendanceModal">
                Close
            </button>
        </div>
    </div>
</div>