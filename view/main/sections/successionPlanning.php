<div class="tab-content" id="succession-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Succession Planning</h2>
            <p class="text-gray-500 text-sm mt-1">Employees ready for promotion or advancement</p>
        </div>
    </div>

    <!-- Succession Pipeline Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Ready for Promotion</p>
            <p class="text-2xl font-bold text-gray-800"><?= $successionReadyCount ?></p>
            <p class="text-xs text-gray-400 mt-1">Completed all requirements</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Training Completed</p>
            <p class="text-2xl font-bold text-gray-800"><?= number_format($successionTotalTrainings) ?></p>
            <p class="text-xs text-gray-400 mt-1">Total certifications earned</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">No Competency Gaps</p>
            <p class="text-2xl font-bold text-gray-800"><?= $successionNoGapsCount ?></p>
            <p class="text-xs text-gray-400 mt-1">Fully qualified employees</p>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-5 justify-center">
                <span class="text-sm text-gray-500">Filter:</span>
                <select name="succession_dept" onchange="applySuccessionFilter()"
                    class="text-sm bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option value="">All Departments</option>
                    <?php foreach ($successionDepartments as $dept): ?>
                        <option value="<?= htmlspecialchars($dept['department']) ?>"
                            <?= $successionDepartmentFilter == $dept['department'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($dept['department']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="flex items-center gap-2 ml-auto">
                    <span class="text-sm text-gray-500">Sort:</span>
                    <select name="succession_sort" onchange="applySuccessionFilter()"
                        class="text-sm bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <option value="readiness" <?= $successionSortBy == 'readiness' ? 'selected' : '' ?>>Readiness Score
                        </option>
                        <option value="department" <?= $successionSortBy == 'department' ? 'selected' : '' ?>>Department
                        </option>
                        <option value="name" <?= $successionSortBy == 'name' ? 'selected' : '' ?>>Name</option>
                        <option value="date" <?= $successionSortBy == 'date' ? 'selected' : '' ?>>Date Completed</option>
                    </select>
                </div>
            </div>

            <?php if (!empty($successionDepartmentFilter)): ?>
                <a href="?tab=succession&succession_page=1"
                    class="text-xs text-red-600 hover:text-red-800 flex items-center gap-1">
                    <i class="fas fa-times"></i> Clear
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Succession Candidates List -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Succession Candidates</h3>
            <span
                class="text-xs font-medium bg-green-50 text-green-700 px-2.5 py-1 rounded-full border border-green-200">
                <?= $successionReadyCount ?> candidates ready
            </span>
        </div>

        <div class="p-6">
            <div class="space-y-4">
                <?php if (!empty($successionCandidates)): ?>
                    <?php foreach ($successionCandidates as $candidate):
                        $badge = getReadinessBadge($candidate['readiness_status']);
                        $icon = getReadinessIcon($candidate['readiness_status']);
                        ?>
                        <div
                            class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow duration-200 <?= $candidate['readiness_status'] == 'ready_now' ? 'bg-gradient-to-r from-white to-green-50' : '' ?>">
                            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div>
                                        <div class="flex items-center gap-3 mb-1">
                                            <h4 class="text-lg font-semibold text-gray-800">
                                                <?= htmlspecialchars($candidate['full_name']) ?>
                                            </h4>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= $badge['class'] ?>">
                                                <i class="fas <?= $icon ?> mr-1 text-xs"></i><?= $badge['text'] ?>
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500 mb-2"><?= htmlspecialchars($candidate['position']) ?> •
                                            <?= htmlspecialchars($candidate['department']) ?> Department
                                        </p>

                                        <!-- Completion Badges - FIXED variable names -->
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <?php if ($candidate['all_tasks_complete']): ?>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 rounded-md text-xs border border-green-200">
                                                    <i class="fas fa-check-circle text-xs"></i> All Tasks Complete
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($candidate['all_trainings_complete']): ?>
                                                <!-- Changed from enough_trainings -->
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-700 rounded-md text-xs border border-blue-200">
                                                    <i class="fas fa-graduation-cap text-xs"></i>
                                                    <?= $candidate['completed_trainings'] ?>/<?= $candidate['total_trainings'] ?>
                                                    Trainings
                                                </span>
                                            <?php endif; ?>

                                            <?php if ($candidate['no_competency_gaps']): ?>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-1 bg-purple-50 text-purple-700 rounded-md text-xs border border-purple-200">
                                                    <i class="fas fa-star text-xs"></i> No Competency Gaps
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Qualification Details -->
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3">
                                            <div class="flex items-center gap-2 text-xs">
                                                <i class="fas fa-tasks text-gray-400 w-4"></i>
                                                <span class="text-gray-600">Tasks: <span
                                                        class="font-medium text-gray-800"><?= $candidate['completed_tasks'] ?>/<?= $candidate['total_tasks'] ?>
                                                        completed</span></span>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs">
                                                <i class="fas fa-clock text-gray-400 w-4"></i>
                                                <span class="text-gray-600">Last Training: <span
                                                        class="font-medium text-gray-800"><?= $candidate['last_training_date'] ? date('M Y', strtotime($candidate['last_training_date'])) : 'N/A' ?></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons - FIXED -->
                                <div class="flex justify-end lg:flex-col gap-2 lg:min-w-35">
                                    <?php if ($candidate['readiness_status'] == 'ready_now'): ?>
                                        <button
                                            onclick="confirmPromotion(<?= $candidate['id'] ?>, '<?= htmlspecialchars($candidate['full_name']) ?>')"
                                            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                                            <i class="fas fa-arrow-up"></i>
                                            Confirm Promotion
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                        <p>No succession candidates found</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($successionTotalPages > 1): ?>
                <div class="mt-6 flex items-center justify-end gap-2 border-t border-gray-100 pt-4">
                    <p class="text-xs text-gray-500">
                        Showing <span
                            class="font-medium"><?= min(1 + ($successionPage - 1) * $successionPerPage, $successionTotalCandidates) ?>-<?= min($successionPage * $successionPerPage, $successionTotalCandidates) ?></span>
                        of <span class="font-medium"><?= $successionTotalCandidates ?></span> candidates
                    </p>
                    <div class="flex items-center gap-2">
                        <?php if ($successionPage > 1): ?>
                            <a href="?tab=succession&succession_page=<?= $successionPage - 1 ?><?= !empty($successionDepartmentFilter) ? '&succession_dept=' . urlencode($successionDepartmentFilter) : '' ?><?= !empty($successionSortBy) ? '&succession_sort=' . urlencode($successionSortBy) : '' ?>"
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </a>
                        <?php else: ?>
                            <button
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-400 cursor-not-allowed"
                                disabled>
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= min(5, $successionTotalPages); $i++): ?>
                            <a href="?tab=succession&succession_page=<?= $i ?><?= !empty($successionDepartmentFilter) ? '&succession_dept=' . urlencode($successionDepartmentFilter) : '' ?><?= !empty($successionSortBy) ? '&succession_sort=' . urlencode($successionSortBy) : '' ?>"
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg <?= $i == $successionPage ? 'bg-primary text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?> transition-colors">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($successionPage < $successionTotalPages): ?>
                            <a href="?tab=succession&succession_page=<?= $successionPage + 1 ?><?= !empty($successionDepartmentFilter) ? '&succession_dept=' . urlencode($successionDepartmentFilter) : '' ?><?= !empty($successionSortBy) ? '&succession_sort=' . urlencode($successionSortBy) : '' ?>"
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </a>
                        <?php else: ?>
                            <button
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-400 cursor-not-allowed"
                                disabled>
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Stats Footer -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-700 mb-2">Top Departments with Ready Candidates</h4>
            <div class="space-y-2">
                <?php foreach ($successionDeptSummary as $dept): ?>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600"><?= htmlspecialchars($dept['department']) ?></span>
                        <span class="font-medium text-gray-800"><?= $dept['ready_candidates'] ?> candidates</span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    function applySuccessionFilter() {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', 'succession');
        url.searchParams.set('succession_page', '1');

        const dept = document.querySelector('select[name="succession_dept"]').value;
        const position = document.querySelector('select[name="succession_position"]').value;
        const sort = document.querySelector('select[name="succession_sort"]').value;

        if (dept) url.searchParams.set('succession_dept', dept);
        else url.searchParams.delete('succession_dept');

        if (position) url.searchParams.set('succession_position', position);
        else url.searchParams.delete('succession_position');

        if (sort) url.searchParams.set('succession_sort', sort);
        else url.searchParams.delete('succession_sort');

        window.location.href = url.toString();
    }


</script>