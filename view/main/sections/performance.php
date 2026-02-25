<!-- Main Performance Management Content -->
<div class="tab-content" id="performance-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Performance Management</h2>
            <p class="text-gray-600 mt-1">Evaluate performance and determine employment status</p>
        </div>
    </div>

    <!-- Performance Dashboard -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-sm text-gray-600">Pending Evaluations</p>
            <p class="text-2xl font-bold text-primary">8</p>
            <p class="text-xs text-gray-500">4 probationary reviews due</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Ready for Regular</p>
            <p class="text-2xl font-bold text-green-600">3</p>
            <p class="text-xs text-gray-500">Based on recent evaluations</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">On PIP</p>
            <p class="text-2xl font-bold text-yellow-600">2</p>
            <p class="text-xs text-gray-500">Performance improvement plans</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Avg Rating</p>
            <p class="text-2xl font-bold text-blue-600">3.8/5.0</p>
            <p class="text-xs text-gray-500">All employees</p>
        </div>
    </div>

    <!-- Probationary Employees -->
    <div class="card p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Probationary Employees - Pending Evaluation</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3">Employee</th>
                        <th class="text-left py-3">Position</th>
                        <th class="text-left py-3">Start Date</th>
                        <th class="text-left py-3">Review Due</th>
                        <th class="text-left py-3">Status</th>
                        <th class="text-left py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($probationaryEmployees as $emp): ?>
                        <tr class="border-b border-gray-100">
                            <td class="py-3 font-medium">
                                <?= htmlspecialchars($emp['full_name']) ?>
                            </td>
                            <td class="py-3">
                                <?= htmlspecialchars($emp['position']) ?>
                            </td>
                            <td class="py-3">
                                <?= $emp['start_date'] ? date('M d, Y', strtotime($emp['start_date'])) : '-' ?>
                            </td>
                            <td class="py-3">
                                <?= $emp['hired_date'] ? date('M d, Y', strtotime($emp['hired_date'] . ' + 90 days')) : '-' ?>
                            </td>
                            <td class="py-3">
                                <span class="status-badge bg-yellow-100 text-yellow-800">Probationary</span>
                            </td>
                            <td class="py-3">
                                <button class="text-primary hover:text-primary-dark"
                                    onclick="openModal('performanceEvaluationModal<?= $emp['id'] ?>')">
                                    <i class="fas fa-star mr-1"></i>Evaluate
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Evaluation Results -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Recent Evaluation Results</h3>

        <?php if (!empty($recentEvaluations)): ?>
            <?php foreach ($recentEvaluations as $eval): ?>
                <?php
                $isHighPerformance = $eval['overall_score'] >= 3.5;
                $probationEndDate = date('M d, Y', strtotime($eval['hired_date'] . ' + 90 days'));
                ?>

                <?php if ($isHighPerformance): ?>
                    <!-- High Performance - Regular Status -->
                    <div class="border border-green-200 rounded-lg p-4 mb-4 bg-green-50">
                        <div class="flex justify-between items-start">
                            <div class="flex items-start gap-3">
                                <div class="bg-green-100 rounded-full p-2">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">
                                        <?= htmlspecialchars($eval['full_name']) ?>
                                    </p>
                                    <p class="text-sm">
                                        <?= htmlspecialchars($eval['position']) ?> • Probationary ended
                                        <?= $probationEndDate ?>
                                    </p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-sm font-bold text-green-700">
                                            <?= number_format($eval['overall_score'], 1) ?>/5.0
                                        </span>
                                        <span class="text-xs bg-green-200 text-green-800 px-2 py-1 rounded">High Performance</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn-primary text-sm px-3 py-1"
                                onclick="openModal('regularModal_<?= $eval['employee_id'] ?>')">
                                <i class="fas fa-user-check mr-1"></i>Make Regular
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            <?= htmlspecialchars($eval['interpretation']) ?>
                        </p>
                    </div>
                <?php else: ?>
                    <!-- Low Performance - PIP Required -->
                    <div class="border border-yellow-200 rounded-lg p-4 mb-4 bg-yellow-50">
                        <div class="flex justify-between items-start">
                            <div class="flex items-start gap-3">
                                <div class="bg-yellow-100 rounded-full p-2">
                                    <i class="fas fa-exclamation-triangle text-yellow-600"></i>
                                </div>
                                <div>
                                    <p class="font-medium">
                                        <?= htmlspecialchars($eval['full_name']) ?>
                                    </p>
                                    <p class="text-sm">
                                        <?= htmlspecialchars($eval['position']) ?> • Probationary ended
                                        <?= $probationEndDate ?>
                                    </p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-sm font-bold text-yellow-700">
                                            <?= number_format($eval['overall_score'], 1) ?>/5.0
                                        </span>
                                        <span class="text-xs bg-yellow-200 text-yellow-800 px-2 py-1 rounded">Needs
                                            Improvement</span>
                                    </div>
                                </div>
                            </div>
                            <button class="bg-yellow-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-yellow-700"
                                onclick="openModal('pipModal_<?= $eval['employee_id'] ?>')">
                                <i class="fas fa-chart-line mr-1"></i>Create PIP
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mt-2">
                            <?= htmlspecialchars($eval['interpretation']) ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Include modals for this employee -->
                <?php
                // Pass evaluation data to partials
                $modalData = [
                    'employee_id' => $eval['employee_id'],
                    'evaluation_id' => $eval['evaluation_id'],
                    'full_name' => $eval['full_name'],
                    'overall_score' => $eval['overall_score'],
                    'interpretation' => $eval['interpretation']
                ];

                require base_path('view/main/modals/newReview.php');

                ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-clipboard-list text-4xl mb-3 opacity-50"></i>
                <p>No evaluation results found.</p>
                <p class="text-sm mt-1">Complete performance evaluations to see results here.</p>
            </div>
        <?php endif; ?>
    </div>
</div>