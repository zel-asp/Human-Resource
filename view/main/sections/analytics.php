<div class="tab-content" id="analytics-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">HR Analytics Dashboard</h2>
            <p class="text-gray-500 text-sm mt-1">Key metrics and insights</p>
        </div>
        <div class="flex gap-2">
            <select id="analyticsRangeSelect"
                class="text-sm bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="30" <?= $analyticsDateRange == 30 ? 'selected' : '' ?>>Last 30 days</option>
                <option value="90" <?= $analyticsDateRange == 90 ? 'selected' : '' ?>>Last quarter</option>
                <option value="365" <?= $analyticsDateRange == 365 ? 'selected' : '' ?>>Year to date</option>
            </select>
            <button onclick="exportAnalyticsData()"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-download"></i>
                Export
            </button>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Average Salary Card -->
        <div
            class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Average Salary</p>
                    <p class="text-2xl font-bold text-gray-800">₱<?= number_format($analyticsAvgSalary, 2) ?></p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-blue-500"></i>
                </div>
            </div>
            <div class="mt-2 flex items-center gap-1 text-xs">
                <span class="text-green-600 flex items-center gap-0.5">
                    <i class="fas fa-arrow-up text-xs"></i><?= $analyticsSalaryIncreasePct ?>%
                </span>
                <span class="text-gray-400">from last year</span>
            </div>
        </div>

        <!-- Salary Increases Card -->
        <div
            class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Salary Increases</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $analyticsSalaryIncrease ?>%</p>
                    <p class="text-xs text-gray-400 mt-1">Avg. raise this year</p>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrow-trend-up text-green-500"></i>
                </div>
            </div>
            <div class="mt-2 flex items-center gap-1 text-xs">
                <span class="text-gray-600 font-medium"><?= $analyticsEmployeesPromoted ?> employees</span>
                <span class="text-gray-400">• received raises</span>
            </div>
        </div>

        <!-- Training & Certifications Completed Card -->
        <div
            class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Training Completed</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $analyticsTrainingsCompleted ?></p>
                </div>
                <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-graduation-cap text-amber-500"></i>
                </div>
            </div>
            <div class="mt-2 flex items-center gap-1 text-xs">
                <span class="text-blue-600 flex items-center gap-0.5">
                    <i class="fas fa-certificate text-xs"></i><?= $analyticsCertificationsEarned ?> certifications
                </span>
            </div>
        </div>

        <!-- Performance Ratings Card -->
        <div
            class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Performance Ratings</p>
                    <p class="text-2xl font-bold text-gray-800"><?= $analyticsAvgRating ?>/5.0</p>
                </div>
                <div class="w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center">
                    <i class="fas fa-star text-purple-500"></i>
                </div>
            </div>
            <div class="mt-2 flex items-center gap-1 text-xs">
                <div class="flex items-center gap-1">
                    <?php
                    $rating = $analyticsAvgRating ?? 4.2;
                    $fullStars = floor($rating);
                    $halfStar = ($rating - $fullStars) >= 0.5;
                    ?>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php if ($i <= $fullStars): ?>
                            <i class="fas fa-star text-amber-400 text-xs"></i>
                        <?php elseif ($i == $fullStars + 1 && $halfStar): ?>
                            <i class="fas fa-star-half-alt text-amber-400 text-xs"></i>
                        <?php else: ?>
                            <i class="far fa-star text-amber-400 text-xs"></i>
                        <?php endif; ?>
                    <?php endfor; ?>
                    <span class="text-gray-400 ml-1">(<?= $analyticsTotalRatings ?> ratings)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Headcount by Department - Donut Chart -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-linear-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-semibold text-gray-800">Headcount by Department</h3>
                <p class="text-xs text-gray-500 mt-1">Distribution across <?= count($analyticsDeptHeadcount) ?> teams
                </p>
            </div>
            <div class="p-6">
                <!-- Search -->
                <div class="mb-4">
                    <input type="text" id="deptSearch" placeholder="Search departments..."
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg text-sm">
                </div>

                <!-- Compact Table -->
                <div class="overflow-y-auto max-h-1000 custom-scrollbar">
                    <table class="w-full">
                        <thead class="sticky top-0 bg-white">
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-2 text-xs font-medium text-gray-500 uppercase">Department</th>
                                <th class="text-right py-2 text-xs font-medium text-gray-500 uppercase">Count</th>
                                <th class="text-right py-2 text-xs font-medium text-gray-500 uppercase">% of Total</th>
                                <th class="w-24"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Sort by count descending
                            usort($analyticsDeptHeadcount, fn($a, $b) => $b['count'] - $a['count']);
                            $totalHeadcount = array_sum(array_column($analyticsDeptHeadcount, 'count'));
                            ?>

                            <?php foreach ($analyticsDeptHeadcount as $index => $dept):
                                $percentage = round(($dept['count'] / $totalHeadcount) * 100, 1);
                                $colorIndex = $index % count($analyticsDeptColors);
                                ?>
                                <tr class="border-b border-gray-50 hover:bg-gray-50 department-row">
                                    <td class="py-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full"
                                                style="background-color: <?= $analyticsDeptColors[$colorIndex] ?>"></span>
                                            <span
                                                class="text-sm text-gray-700"><?= htmlspecialchars($dept['department']) ?></span>
                                        </div>
                                    </td>
                                    <td class="py-2 text-right text-sm font-medium"><?= $dept['count'] ?></td>
                                    <td class="py-2 text-right text-sm text-gray-600"><?= $percentage ?>%</td>
                                    <td class="py-2">
                                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                                            <div class="h-1.5 rounded-full"
                                                style="width: <?= $percentage ?>%; background-color: <?= $analyticsDeptColors[$colorIndex] ?>;">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between">
                    <span class="text-xs text-gray-500">Showing <?= count($analyticsDeptHeadcount) ?> departments</span>
                    <span class="text-xs font-medium text-gray-700">Total: <?= $totalHeadcount ?> employees</span>
                </div>
            </div>
        </div>

        <!-- Monthly Hires vs Terminations - Line Chart -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-linear-to-r from-green-50 to-emerald-50">
                <h3 class="text-lg font-semibold text-gray-800">Hires vs Terminations Trend</h3>
                <p class="text-xs text-gray-500 mt-1">6-month comparison</p>
            </div>
            <div class="p-6">
                <div class="h-60">
                    <canvas id="analyticsHiresChart"></canvas>
                </div>
                <!-- Summary Cards -->
                <div class="grid grid-cols-3 gap-3 mt-4">
                    <div class="bg-green-50 rounded-lg p-2 text-center">
                        <p class="text-xs text-green-600 font-medium">Total Hires</p>
                        <p class="text-lg font-bold text-green-700"><?= $analyticsTotalHires ?></p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-2 text-center">
                        <p class="text-xs text-red-600 font-medium">Total Terminations</p>
                        <p class="text-lg font-bold text-red-700"><?= $analyticsTotalTerminations ?></p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-2 text-center">
                        <p class="text-xs text-blue-600 font-medium">Net Growth</p>
                        <p class="text-lg font-bold text-blue-700">+<?= $analyticsNetGrowth ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Metrics Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Demographics - Gender Distribution -->
        <!-- Gender Distribution -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-linear-to-r from-pink-50 to-rose-50">
                <h3 class="text-lg font-semibold text-gray-800">Gender Distribution</h3>
            </div>
            <div class="p-6">
                <div class="h-37 mb-4">
                    <canvas id="analyticsGenderChart"></canvas>
                </div>
                <div class="grid grid-cols-2 gap-2 text-center">
                    <div class="p-2 bg-pink-50 rounded-lg">
                        <p class="text-lg font-bold text-pink-700"><?= $analyticsFemalePct ?>%</p>
                        <p class="text-xs text-gray-600">Female · <?= $analyticsFemaleCount ?> emp</p>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <p class="text-lg font-bold text-blue-700"><?= $analyticsMalePct ?>%</p>
                        <p class="text-xs text-gray-600">Male · <?= $analyticsMaleCount ?> emp</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Age Distribution -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-linear-to-r from-blue-50 to-cyan-50">
                <h3 class="text-lg font-semibold text-gray-800">Age Distribution</h3>
            </div>
            <div class="p-6">
                <div class="h-37 mb-4">
                    <canvas id="analyticsAgeChart"></canvas>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <p class="text-lg font-bold text-blue-700"><?= $analyticsAge18_30 ?>%</p>
                        <p class="text-xs text-gray-600">18-30</p>
                    </div>
                    <div class="p-2 bg-green-50 rounded-lg">
                        <p class="text-lg font-bold text-green-700"><?= $analyticsAge31_45 ?>%</p>
                        <p class="text-xs text-gray-600">31-45</p>
                    </div>
                    <div class="p-2 bg-amber-50 rounded-lg">
                        <p class="text-lg font-bold text-amber-700"><?= $analyticsAge46 ?>%</p>
                        <p class="text-xs text-gray-600">46+</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenure Distribution -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-linear-to-r from-purple-50 to-violet-50">
                <h3 class="text-lg font-semibold text-gray-800">Tenure Distribution</h3>
            </div>
            <div class="p-6">
                <div class="h-37 mb-4">
                    <canvas id="analyticsTenureChart"></canvas>
                </div>
                <div class="grid grid-cols-3 gap-2 text-center">
                    <div class="p-2 bg-purple-50 rounded-lg">
                        <p class="text-lg font-bold text-purple-700">
                            <?= $analyticsTenureLess1 ?>%
                        </p>
                        <p class="text-xs text-gray-600">&lt;1 year</p>
                    </div>
                    <div class="p-2 bg-indigo-50 rounded-lg">
                        <p class="text-lg font-bold text-indigo-700">
                            <?= $analyticsTenure1to3 ?>%
                        </p>
                        <p class="text-xs text-gray-600">1-3 years</p>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <p class="text-lg font-bold text-blue-700">
                            <?= $analyticsTenure3plus ?>%
                        </p>
                        <p class="text-xs text-gray-600">3+ years</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Freshness Note -->
    <div class="mt-4 text-xs text-gray-400 flex items-center justify-end gap-2">
        <i class="fas fa-sync-alt text-blue-500"></i>
        <span>Data updated daily • Last sync: <?= $analyticsLastSync ?></span>
    </div>
</div>

<!-- Pass PHP data to JavaScript -->
<script>
    // Search functionality
    document.getElementById('deptSearch')?.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.department-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const deptName = row.querySelector('.text-gray-700').textContent.toLowerCase();
            if (deptName.includes(searchTerm)) {
                row.style.display = 'table-row';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update showing count if you want
        const footer = document.querySelector('.border-t .text-gray-500');
        if (footer) {
            footer.textContent = `Showing ${visibleCount} of ${rows.length} departments`;
        }
    });

    window.analyticsData = {
        dateRange: <?= $analyticsDateRange ?? 0 ?>,
        deptLabels: <?= isset($analyticsDeptHeadcount) ? json_encode(array_column($analyticsDeptHeadcount, 'department')) : '[]' ?>,
        deptData: <?= isset($analyticsDeptHeadcount) ? json_encode(array_column($analyticsDeptHeadcount, 'count')) : '[]' ?>,
        deptColors: <?= isset($analyticsDeptColors) ? json_encode(array_slice($analyticsDeptColors, 0, count($analyticsDeptHeadcount ?? []))) : '[]' ?>,
        totalHeadcount: <?= $analyticsTotalHeadcount ?? 0 ?>,
        months: <?= isset($analyticsMonths) ? json_encode($analyticsMonths) : '[]' ?>,
        hiresData: <?= isset($analyticsHiresData) ? json_encode($analyticsHiresData) : '[]' ?>,
        terminationsData: <?= isset($analyticsTerminationsData) ? json_encode($analyticsTerminationsData) : '[]' ?>,
        totalHires: <?= $analyticsTotalHires ?? 0 ?>,
        totalTerminations: <?= $analyticsTotalTerminations ?? 0 ?>,
        netGrowth: <?= $analyticsNetGrowth ?? 0 ?>,
        femalePct: <?= $analyticsFemalePct ?? 0 ?>,
        malePct: <?= $analyticsMalePct ?? 0 ?>,
        femaleCount: <?= $analyticsFemaleCount ?? 0 ?>,
        maleCount: <?= $analyticsMaleCount ?? 0 ?>,
        ageData: [<?= $analyticsAge18_30 ?? 0 ?>, <?= $analyticsAge31_45 ?? 0 ?>, <?= $analyticsAge46 ?? 0 ?>],
        tenureData: [<?= $analyticsTenureLess1 ?? 0 ?>, <?= $analyticsTenure1to3 ?? 0 ?>, <?= $analyticsTenure3plus ?? 0 ?>],
        avgSalary: <?= $analyticsAvgSalary ?? 0 ?>,
        salaryIncreasePct: <?= $analyticsSalaryIncreasePct ?? 0 ?>,
        salaryIncrease: <?= $analyticsSalaryIncrease ?? 0 ?>,
        employeesPromoted: <?= $analyticsEmployeesPromoted ?? 0 ?>,
        trainingsCompleted: <?= $analyticsTrainingsCompleted ?? 0 ?>,
        certificationsEarned: <?= $analyticsCertificationsEarned ?? 0 ?>,
        avgRating: <?= $analyticsAvgRating ?? 0 ?>,
        totalRatings: <?= $analyticsTotalRatings ?? 0 ?>,
        lastSync: <?= json_encode($analyticsLastSync ?? '') ?>
    };
</script>