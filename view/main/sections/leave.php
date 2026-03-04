<div class="tab-content" id="leave-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Leave Management</h2>
            <p class="text-gray-500 text-sm mt-1">Manage employee leave requests and balances</p>
        </div>
    </div>

    <!-- Leave Counts (by number of requests, not days) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Vacation Leave</p>
            <p class="text-2xl font-bold text-gray-800"><?= $vacationLeaveCount ?></p>
            <p class="text-xs text-gray-400 mt-1">approved requests</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Sick Leave</p>
            <p class="text-2xl font-bold text-gray-800"><?= $sickLeaveCount ?></p>
            <p class="text-xs text-gray-400 mt-1">approved requests</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Emergency Leave</p>
            <p class="text-2xl font-bold text-gray-800"><?= $emergencyLeaveCount ?></p>
            <p class="text-xs text-gray-400 mt-1">approved requests</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Pending Requests</p>
            <p class="text-2xl font-bold text-gray-800"><?= $pendingLeaveCount ?></p>
            <p class="text-xs text-gray-400 mt-1">awaiting approval</p>
        </div>
    </div>

    <!-- Pending Leave Requests with Pagination -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div
            class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-gray-800">Pending Leave Requests</h3>
            <?php if ($totalPendingPages > 1): ?>
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-500">Page <?= $pendingPage ?> of <?= $totalPendingPages ?></span>
                    <div class="flex gap-1">
                        <?php if ($pendingPage > 1): ?>
                            <a href="?pending_page=<?= $pendingPage - 1 ?>"
                                class="w-7 h-7 flex items-center justify-center text-xs rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        <?php if ($pendingPage < $totalPendingPages): ?>
                            <a href="?pending_page=<?= $pendingPage + 1 ?>"
                                class="w-7 h-7 flex items-center justify-center text-xs rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-6">
            <div class="space-y-3">
                <?php if (!empty($pendingLeaveRequests)): ?>
                    <?php foreach ($pendingLeaveRequests as $request): ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow duration-200">
                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        <div
                                            class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">
                                            <?= strtoupper(substr($request['full_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800"><?= htmlspecialchars($request['full_name']) ?>
                                            </p>
                                            <p class="text-xs text-gray-400"><?= htmlspecialchars($request['position']) ?> •
                                                <?= htmlspecialchars($request['department'] ?? 'No Department') ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="ml-10 space-y-2">
                                        <div class="flex items-center gap-2 text-sm">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                <?= htmlspecialchars($request['leave_type']) ?>
                                            </span>
                                            <span class="text-gray-400">•</span>
                                            <span class="text-gray-600">
                                                <?= date('M j', strtotime($request['start_date'])) ?> -
                                                <?= date('M j, Y', strtotime($request['end_date'])) ?>
                                            </span>
                                            <span class="text-gray-400">•</span>
                                            <span class="text-gray-600"><?= $request['actual_days'] ?> day(s)</span>
                                        </div>

                                        <?php if (!empty($request['reason'])): ?>
                                            <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                                                <p class="text-xs text-gray-500 mb-1">Reason:</p>
                                                <p class="text-sm text-gray-700"><?= htmlspecialchars($request['reason']) ?></p>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-xs text-gray-400 italic">No reason provided</p>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="flex gap-2 sm:flex-col">
                                    <!-- Approve Form -->
                                    <form method="POST" action="/leave/approve" class="inline"
                                        onsubmit="return confirm('Are you sure you want to approve this leave request?');">
                                        <input type="hidden" name="__method" value="PATCH">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                        <button type="submit"
                                            class="w-full sm:w-auto px-2 py-1 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors duration-200 flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-check"></i>
                                            Approve
                                        </button>
                                    </form>

                                    <!-- Deny Form -->
                                    <form method="POST" action="/leave/deny" class="inline"
                                        onsubmit="return confirm('Are you sure you want to deny this leave request?');">
                                        <input type="hidden" name="__method" value="PATCH">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                        <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                        <button type="submit"
                                            class="w-full sm:w-auto px-2 py-1 text-sm font-medium text-red-700 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition-colors duration-200 flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-xmark"></i>
                                            Deny
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-12">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check-circle text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-600 text-sm">No pending leave requests</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Bottom pagination for pending requests -->
            <?php if ($totalPendingPages > 1): ?>
                <div class="flex justify-center items-center gap-2 mt-6 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-500 mr-2">Page <?= $pendingPage ?> of <?= $totalPendingPages ?></p>
                    <?php for ($i = 1; $i <= $totalPendingPages; $i++): ?>
                        <a href="?pending_page=<?= $i ?>"
                            class="w-8 h-8 flex items-center justify-center text-sm rounded-lg transition-colors duration-200
                            <?= $i == $pendingPage ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Leave History with Pagination -->
    <?php if (!empty($paginatedLeaveHistory)): ?>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mt-6">
            <div
                class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-800">Leave History</h3>
                <?php if ($totalHistoryPages > 1): ?>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-gray-500">Page <?= $historyPage ?> of <?= $totalHistoryPages ?></span>
                        <div class="flex gap-1">
                            <?php if ($historyPage > 1): ?>
                                <a href="?history_page=<?= $historyPage - 1 ?>&tab=leave#history"
                                    class="w-7 h-7 flex items-center justify-center text-xs rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($historyPage < $totalHistoryPages): ?>
                                <a href="?history_page=<?= $historyPage + 1 ?>&tab=leave#history"
                                    class="w-7 h-7 flex items-center justify-center text-xs rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="p-6">
                <div class="overflow-x-auto" id="history">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Employee</th>
                                <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Leave
                                    Type</th>
                                <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                                    Range</th>
                                <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Days
                                </th>
                                <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Reason
                                </th>
                                <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                                </th>
                                <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($paginatedLeaveHistory as $request): ?>
                                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="py-3">
                                        <p class="font-medium text-gray-800"><?= htmlspecialchars($request['full_name']) ?></p>
                                        <p class="text-xs text-gray-400"><?= htmlspecialchars($request['position']) ?></p>
                                    </td>
                                    <td class="text-sm text-gray-600"><?= htmlspecialchars($request['leave_type']) ?></td>
                                    <td class="text-sm text-gray-600">
                                        <?= date('M j', strtotime($request['start_date'])) ?> -
                                        <?= date('M j, Y', strtotime($request['end_date'])) ?>
                                    </td>
                                    <td class="text-sm text-gray-800 font-medium"><?= $request['actual_days'] ?></td>
                                    <td class="max-w-xs">
                                        <?php if (!empty($request['reason'])): ?>
                                            <p class="text-sm text-gray-600 truncate hover:text-clip hover:whitespace-normal"
                                                title="<?= htmlspecialchars($request['reason']) ?>">
                                                <?= htmlspecialchars($request['reason']) ?>
                                            </p>
                                        <?php else: ?>
                                            <span class="text-xs text-gray-400 italic">No reason</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                            <?= $request['status'] == 'Approved' ? 'bg-green-50 text-green-700 border border-green-200' : '' ?>
                                            <?= $request['status'] == 'Pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : '' ?>
                                            <?= $request['status'] == 'Rejected' ? 'bg-red-50 text-red-700 border border-red-200' : '' ?>
                                            <?= $request['status'] == 'Cancelled' ? 'bg-gray-50 text-gray-600 border border-gray-200' : '' ?>">
                                            <?= $request['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($request['status'] == 'Pending'): ?>
                                            <div class="flex gap-2">
                                                <!-- Approve Form -->
                                                <form method="POST" action="/leave/approve" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to approve this leave request?');">
                                                    <input type="hidden" name="__method" value="PATCH">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                    <button type="submit"
                                                        class="text-sm text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-2.5 py-1 rounded-lg transition-colors duration-200 border border-green-200">
                                                        Approve
                                                    </button>
                                                </form>

                                                <!-- Deny Form -->
                                                <form method="POST" action="/leave/deny" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to deny this leave request?');">
                                                    <input type="hidden" name="__method" value="PATCH">
                                                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                                    <input type="hidden" name="request_id" value="<?= $request['id'] ?>">
                                                    <button type="submit"
                                                        class="text-sm text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-2.5 py-1 rounded-lg transition-colors duration-200 border border-red-200">
                                                        Deny
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-sm text-gray-400">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Bottom pagination for history -->
                <?php if ($totalHistoryPages > 1): ?>
                    <div class="flex justify-center items-center gap-2 mt-6 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mr-2">Page <?= $historyPage ?> of <?= $totalHistoryPages ?></p>
                        <?php for ($i = 1; $i <= $totalHistoryPages; $i++): ?>
                            <a href="?history_page=<?= $i ?>&tab=leave#history"
                                class="w-8 h-8 flex items-center justify-center text-sm rounded-lg transition-colors duration-200
                                <?= $i == $historyPage ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>