<div id="viewAllRequestsModal"
    class="fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden modal-enter z-50">
    <div class="bg-white rounded-md max-w-lg w-full mx-4 p-6 shadow-xl max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fa-solid fa-list-alt mr-2 text-primary"></i>All Requests
            </h3>
            <button class="close-modal text-gray-400 hover:text-gray-600" data-modal="viewAllRequestsModal">
                <i class="fa-solid fa-circle-xmark fa-xl"></i>
            </button>
        </div>

        <!-- Summary Stats -->
        <div class="grid grid-cols-3 gap-2 mb-4">
            <div class="bg-amber-50 rounded-lg p-2 text-center">
                <p class="text-lg font-bold text-amber-600"><?= $leaveStats['pending_count'] ?? 0 ?></p>
                <p class="text-xs text-gray-500">Pending</p>
            </div>
            <div class="bg-green-50 rounded-lg p-2 text-center">
                <p class="text-lg font-bold text-green-600"><?= $leaveStats['approved_count'] ?? 0 ?></p>
                <p class="text-xs text-gray-500">Approved</p>
            </div>
            <div class="bg-red-50 rounded-lg p-2 text-center">
                <p class="text-lg font-bold text-red-600"><?= $leaveStats['rejected_count'] ?? 0 ?></p>
                <p class="text-xs text-gray-500">Rejected</p>
            </div>
        </div>

        <p class="text-gray-500 text-sm mb-4">Complete request history (<?= $leaveStats['total_requests'] ?? 0 ?>)</p>

        <div class="space-y-3">
            <?php if (!empty($allLeaveRequests)): ?>
                <?php foreach ($allLeaveRequests as $request): ?>
                    <?php
                    // Set badge color based on leave type
                    $typeClass = 'bg-[#dbeafe] text-primary-hover';

                    switch ($request['leave_type']) {
                        case 'Annual Leave':
                            $typeClass = 'bg-[#dbeafe] text-primary-hover';
                            $typeDisplay = 'annual';
                            break;
                        case 'Sick Leave':
                            $typeClass = 'bg-[#f0e7fc] text-[#5940a0]';
                            $typeDisplay = 'sick';
                            break;
                        case 'Personal Day':
                            $typeClass = 'bg-gray-200 text-gray-800';
                            $typeDisplay = 'personal';
                            break;
                        case 'Remote Work':
                            $typeClass = 'bg-[#e0eee5] text-[#2b6b4a]';
                            $typeDisplay = 'remote';
                            break;
                        default:
                            $typeClass = 'bg-[#dbeafe] text-primary-hover';
                            $typeIcon = 'fa-solid fa-calendar';
                            $typeDisplay = strtolower(str_replace(' ', '', $request['leave_type']));
                    }

                    // Status badge color and icon
                    $statusClass = 'text-amber-700 bg-amber-50';
                    $statusIcon = 'fa-solid fa-clock';
                    $statusText = 'pending';

                    if ($request['status'] == 'Approved') {
                        $statusClass = 'text-green-700 bg-green-50';
                        $statusIcon = 'fa-solid fa-check-circle';
                        $statusText = 'approved';
                    } elseif ($request['status'] == 'Rejected') {
                        $statusClass = 'text-red-700 bg-red-50';
                        $statusIcon = 'fa-solid fa-times-circle';
                        $statusText = 'rejected';
                    } elseif ($request['status'] == 'Cancelled') {
                        $statusClass = 'text-gray-700 bg-gray-100';
                        $statusIcon = 'fa-solid fa-ban';
                        $statusText = 'cancelled';
                    }

                    // Calculate date range display
                    $startDate = date('M d', strtotime($request['start_date']));
                    $endDate = date('M d', strtotime($request['end_date']));
                    $dateRange = ($request['start_date'] == $request['end_date'])
                        ? $startDate
                        : $startDate . ' – ' . $endDate;

                    // Calculate days
                    $days = $request['total_days'] ??
                        (round((strtotime($request['end_date']) - strtotime($request['start_date'])) / (60 * 60 * 24)) + 1);

                    // Time ago
                    $submitted = strtotime($request['created_at']);
                    $timeAgo = '';
                    $diff = time() - $submitted;

                    if ($diff < 60) {
                        $timeAgo = 'just now';
                    } elseif ($diff < 3600) {
                        $mins = floor($diff / 60);
                        $timeAgo = $mins . ' min' . ($mins > 1 ? 's' : '') . ' ago';
                    } elseif ($diff < 86400) {
                        $hours = floor($diff / 3600);
                        $timeAgo = $hours . ' hr' . ($hours > 1 ? 's' : '') . ' ago';
                    } elseif ($diff < 604800) {
                        $days = floor($diff / 86400);
                        $timeAgo = $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
                    } else {
                        $timeAgo = date('M d, Y', $submitted);
                    }
                    ?>

                    <!-- Request Item -->
                    <div
                        class="flex items-center justify-between p-3 bg-[#f2f5f9] rounded-md group hover:bg-[#e8eef5] transition">
                        <div class="flex items-center gap-3 flex-1">
                            <span class="<?= $typeClass ?> text-xs font-medium px-2.5 py-1 rounded-md flex items-center gap-1">
                                <i class="<?= $typeIcon ?>"></i>
                                <?= $typeDisplay ?>
                            </span>

                            <div class="flex-1">
                                <p class="text-sm font-medium">
                                    <?= htmlspecialchars($request['leave_type']) ?> ·
                                    <?= $dateRange ?>
                                    (<?= $days ?> day<?= $days > 1 ? 's' : '' ?>)
                                </p>
                                <p class="text-xs text-gray-400 flex items-center gap-2">
                                    <span><i class="fa-regular fa-clock mr-1"></i>submitted <?= $timeAgo ?></span>
                                    <?php if (!empty($request['reason'])): ?>
                                        <span>·
                                            <?= htmlspecialchars(substr($request['reason'], 0, 30)) ?>
                                            <?= strlen($request['reason']) > 30 ? '...' : '' ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <?php if ($request['status'] == 'Pending'): ?>
                                <button onclick="cancelLeaveRequest(<?= $request['id'] ?>)"
                                    class="opacity-0 group-hover:opacity-100 transition bg-red-600 hover:bg-red-700 text-white p-2 rounded-md text-xs"
                                    title="Cancel request">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            <?php endif; ?>
                            <span class="<?= $statusClass ?> px-3 py-1 text-xs font-medium rounded-md flex items-center gap-1">
                                <i class="<?= $statusIcon ?>"></i>
                                <?= $statusText ?>
                            </span>
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

        <div class="mt-6 flex justify-end gap-2">
            <?php if (($leaveStats['pending_count'] ?? 0) > 0): ?>
                <span class="text-xs text-gray-400 mr-auto">
                    <i class="fa-regular fa-clock mr-1"></i>
                    <?= $leaveStats['pending_count'] ?> pending
                </span>
            <?php endif; ?>
            <button
                class="close-modal bg-white text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-[#d9e2ed]"
                data-modal="viewAllRequestsModal">
                Close
            </button>
        </div>
    </div>
</div>