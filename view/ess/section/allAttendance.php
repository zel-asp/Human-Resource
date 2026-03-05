<div class="bg-white border border-gray-200 rounded-md p-5 shadow-sm">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Attendance Records</h2>

    <!-- Lifetime Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <div class="bg-linear-to-br from-blue-50 to-blue-100 p-4 rounded-lg">
            <span class="text-xs text-blue-600 font-medium">Total Days Worked</span>
            <p class="text-2xl font-bold text-blue-800"><?= $allTimeStats['total_days_worked'] ?? 0 ?></p>
            <p class="text-xs text-blue-600 mt-1">
                Since
                <?= isset($allTimeStats['first_work_date']) && $allTimeStats['first_work_date'] ? date('M Y', strtotime($allTimeStats['first_work_date'])) : 'N/A' ?>
            </p>
        </div>

        <div class="bg-linear-to-br from-green-50 to-green-100 p-4 rounded-lg">
            <span class="text-xs text-green-600 font-medium">Total Hours</span>
            <p class="text-2xl font-bold text-green-800">
                <?= floor(($allTimeStats['total_regular_hours'] ?? 0) + ($allTimeStats['total_overtime_hours'] ?? 0)) ?>
            </p>
            <p class="text-xs text-green-600 mt-1">
                Reg: <?= floor($allTimeStats['total_regular_hours'] ?? 0) ?>h ·
                OT: <?= floor($allTimeStats['total_overtime_hours'] ?? 0) ?>h
            </p>
        </div>

        <div class="bg-linear-to-br from-amber-50 to-amber-100 p-4 rounded-lg">
            <span class="text-xs text-amber-600 font-medium">Attendance Rate</span>
            <p class="text-2xl font-bold text-amber-800"><?= $attendanceRate ?? 0 ?>%</p>
            <p class="text-xs text-amber-600 mt-1">
                <?= $allTimeStats['total_days_worked'] ?? 0 ?>/<?= $workingDaysSince ?? 0 ?> days
            </p>
        </div>

        <div class="bg-linear-to-br from-purple-50 to-purple-100 p-4 rounded-lg">
            <span class="text-xs text-purple-600 font-medium">Late Days</span>
            <p class="text-2xl font-bold text-purple-800"><?= $allTimeStats['total_late_days'] ?? 0 ?></p>
            <p class="text-xs text-purple-600 mt-1">
                <?= $allTimeStats['total_late_minutes'] ?? 0 ?> minutes total
            </p>
        </div>
    </div>

    <!-- All Records Table -->
    <div>
        <h4 class="text-sm font-semibold text-gray-700 mb-3">Complete History</h4>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Date</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Day</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Clock In</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Clock Out</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Duration</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Regular</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">OT</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($allAttendanceRecords)): ?>
                        <?php foreach ($allAttendanceRecords as $record): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 py-2"><?= date('M d, Y', strtotime($record['date'])) ?></td>
                                <td class="px-3 py-2"><?= $record['day_name'] ?></td>
                                <td class="px-3 py-2"><?= $record['clock_in_time'] ?></td>
                                <td class="px-3 py-2"><?= $record['clock_out_time'] ?? '---' ?></td>
                                <td class="px-3 py-2"><?= $record['total_duration'] ?? '---' ?></td>
                                <td class="px-3 py-2">
                                    <?php
                                    $hours = floor($record['regular_hours']);
                                    $minutes = round(($record['regular_hours'] - $hours) * 60);
                                    echo $hours . 'h ' . str_pad($minutes, 2, '0', STR_PAD_LEFT) . 'm';
                                    ?>
                                </td>
                                <td class="px-3 py-2">
                                    <?php if ($record['overtime_hours'] > 0): ?>
                                        <span class="text-amber-600">
                                            <?php
                                            $otHours = floor($record['overtime_hours']);
                                            $otMinutes = round(($record['overtime_hours'] - $otHours) * 60);
                                            echo '+' . $otHours . 'h ' . str_pad($otMinutes, 2, '0', STR_PAD_LEFT) . 'm';
                                            ?>
                                        </span>
                                    <?php else: ?>
                                        ---
                                    <?php endif; ?>
                                </td>
                                <td class="px-3 py-2">
                                    <?php if (isset($record['late_status']) && $record['late_status'] == 'late'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-red-100 text-red-600 rounded-full text-xs">
                                            <i class="fa-solid fa-clock"></i> Late <?= $record['late_minutes'] ?>m
                                        </span>
                                    <?php elseif (isset($record['late_status']) && $record['late_status'] == 'grace_period'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs">
                                            <i class="fa-solid fa-hourglass"></i> Grace
                                        </span>
                                    <?php elseif (isset($record['early_departure_minutes']) && $record['early_departure_minutes'] > 0): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-orange-100 text-orange-600 rounded-full text-xs">
                                            <i class="fa-solid fa-door-open"></i> Early
                                            <?= $record['early_departure_minutes'] ?>m
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-100 text-green-600 rounded-full text-xs">
                                            <i class="fa-solid fa-check"></i> On Time
                                        </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-3 py-8 text-center text-gray-500">
                                <i class="fa-regular fa-calendar-xmark text-3xl mb-2"></i>
                                <p>No attendance records found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="flex justify-center items-center gap-2 mt-4">
                <?php if ($currentPage > 1): ?>
                    <a href="?tab=attendance&page=<?= $currentPage - 1 ?>"
                        class="px-3 py-1 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?tab=attendance&page=<?= $i ?>"
                        class="px-3 py-1 page-btn <?= $i == $currentPage ? 'bg-primary text-white' : 'bg-gray-100 hover:bg-gray-200' ?> rounded-md transition"
                        data-page="<?= $i ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <a href="?tab=attendance&page=<?= $currentPage + 1 ?>"
                        class="px-3 py-1 bg-gray-100 rounded-md hover:bg-gray-200 transition">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Summary Footer -->
    <div class="mt-6 p-4 bg-gray-50 rounded-lg flex flex-wrap justify-between items-center">
        <div class="text-sm text-gray-600">
            <span class="font-medium">Summary:</span>
            <?= $allTimeStats['total_days_worked'] ?? 0 ?> total days ·
            <?= floor($allTimeStats['total_regular_hours'] ?? 0) ?> regular hours ·
            <?= floor($allTimeStats['total_overtime_hours'] ?? 0) ?> overtime hours
        </div>
    </div>
</div>