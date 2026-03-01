<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden modal-enter z-50">
    <div class="bg-white rounded-xl max-w-2xl w-full mx-4 shadow-2xl overflow-hidden">
        <!-- Header with clean design -->
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fa-solid fa-id-card mr-2 text-primary"></i>Employee Profile
            </h3>
            <button class="close-modal text-gray-400 hover:text-gray-600 transition-colors" data-modal="profileModal">
                <i class="fa-solid fa-circle-xmark fa-xl"></i>
            </button>
        </div>

        <?php if ($employeeInfo): ?>
            <!-- Profile Header with clean avatar -->
            <div class="px-6 py-5 bg-gray-50/50">
                <div class="flex items-start gap-5">
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xl font-semibold text-gray-900">
                                    <?= htmlspecialchars($employeeInfo['full_name'] ?? 'N/A') ?>
                                </p>
                                <p class="text-sm text-gray-500 mt-0.5">
                                    <?= htmlspecialchars($employeeInfo['position'] ?? 'N/A') ?>
                                </p>
                            </div>
                            <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-medium rounded-full">
                                <?= htmlspecialchars($employeeInfo['employee_number'] ?? 'N/A') ?>
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-4 mt-3">
                            <span class="text-sm text-gray-600">
                                <i
                                    class="fa-solid fa-envelope mr-2 text-gray-400"></i><?= htmlspecialchars($employeeInfo['email'] ?? 'N/A') ?>
                            </span>
                            <span class="text-sm text-gray-600">
                                <i
                                    class="fa-solid fa-mobile mr-2 text-gray-400"></i><?= htmlspecialchars($employeeInfo['phone'] ?? 'N/A') ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid - Clean cards design -->
            <div class="p-6 space-y-6">
                <!-- Employment Details -->
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Employment Details</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-lg p-3">
                            <span class="text-xs text-gray-500 block">Department</span>
                            <span
                                class="text-sm font-medium text-gray-900"><?= htmlspecialchars($employeeInfo['department'] ?? 'N/A') ?></span>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <span class="text-xs text-gray-500 block">Start Date</span>
                            <span class="text-sm font-medium text-gray-900">
                                <?= $employeeInfo['start_date'] ? date('M d, Y', strtotime($employeeInfo['start_date'])) : 'Not set' ?>
                            </span>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <span class="text-xs text-gray-500 block">Employment</span>
                            <span
                                class="text-sm font-medium text-gray-900"><?= htmlspecialchars($employeeInfo['status'] ?? 'N/A') ?></span>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-3">
                            <span class="text-xs text-gray-500 block">Manager</span>
                            <span class="text-sm font-medium text-gray-900">Sarah V.</span>
                        </div>
                    </div>
                </div>

                <!-- Status Badges -->
                <div>
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Status</h4>
                    <div class="flex flex-wrap gap-2">
                        <!-- Onboarding Status -->
                        <span class="px-3 py-1.5 text-xs font-medium rounded-full 
                        <?php
                        $onboardingClass = 'bg-amber-50 text-amber-700';
                        if (($employeeInfo['onboarding_status'] ?? '') == 'Onboarded') {
                            $onboardingClass = 'bg-green-50 text-green-700';
                        } elseif (($employeeInfo['onboarding_status'] ?? '') == 'In Progress') {
                            $onboardingClass = 'bg-blue-50 text-blue-700';
                        }
                        echo $onboardingClass;
                        ?>">
                            <i class="fas fa-circle-check mr-1"></i>
                            Onboarding: <?= htmlspecialchars($employeeInfo['onboarding_status'] ?? 'Onboarding') ?>
                        </span>

                        <!-- Evaluation Status -->
                        <span class="px-3 py-1.5 text-xs font-medium rounded-full 
                        <?php
                        $evalClass = 'bg-amber-50 text-amber-700';
                        if (($employeeInfo['evaluation_status'] ?? '') == 'Completed') {
                            $evalClass = 'bg-green-50 text-green-700';
                        }
                        echo $evalClass;
                        ?>">
                            <i class="fa-solid fa-chart-line mr-1"></i>
                            Evaluation: <?= htmlspecialchars($employeeInfo['evaluation_status'] ?? 'Pending') ?>
                        </span>

                        <!-- Account Status -->
                        <?php if ($employeeAccount): ?>
                            <span
                                class="px-3 py-1.5 text-xs font-medium rounded-full 
                        <?= ($employeeAccount['account_status'] ?? '') == 'Active' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' ?>">
                                <i class="fa-solid fa-shield mr-1"></i>
                                Account: <?= htmlspecialchars($employeeAccount['account_status'] ?? 'N/A') ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Two Column Grid for Additional Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Applicant History -->
                    <?php if (!empty($employeeInfo['applicant_name'])): ?>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Application History
                            </h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Applied Position</span>
                                    <span
                                        class="font-medium text-gray-900"><?= htmlspecialchars($employeeInfo['applied_position'] ?? 'N/A') ?></span>
                                </div>
                                <div class="flex justify-between text-sm py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Hired Date</span>
                                    <span class="font-medium text-gray-900">
                                        <?= $employeeInfo['hired_date'] ? date('M d, Y', strtotime($employeeInfo['hired_date'])) : 'N/A' ?>
                                    </span>
                                </div>
                                <?php if (!empty($employeeInfo['skills'])): ?>
                                    <div class="text-sm py-2">
                                        <span class="text-gray-600 block mb-1">Skills</span>
                                        <span
                                            class="font-medium text-gray-900"><?= htmlspecialchars($employeeInfo['skills']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Account Details -->
                    <?php if ($employeeAccount): ?>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Account Activity</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Username</span>
                                    <span
                                        class="font-medium text-gray-900"><?= htmlspecialchars($employeeAccount['username'] ?? 'N/A') ?></span>
                                </div>
                                <div class="flex justify-between text-sm py-2 border-b border-gray-200">
                                    <span class="text-gray-600">Last Login</span>
                                    <span class="font-medium text-gray-900">
                                        <?php
                                        if ($employeeAccount['last_login']) {
                                            $timestamp = strtotime($employeeAccount['last_login']);
                                            echo date('M d, Y · g:ia', $timestamp);
                                        } else {
                                            echo 'Never';
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="flex justify-between text-sm py-2">
                                    <span class="text-gray-600">Member Since</span>
                                    <span class="font-medium text-gray-900">
                                        <?= date('M d, Y', strtotime($employeeAccount['generated_date'] ?? 'now')) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Benefits Section -->
                <?php if (!empty($employeeBenefits)): ?>
                    <div>
                        <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Benefits</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <?php foreach ($employeeBenefits as $benefit): ?>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <span
                                                class="text-sm font-medium text-gray-900"><?= htmlspecialchars($benefit['benefit_type'] ?? 'N/A') ?></span>
                                            <p class="text-xs text-gray-500 mt-0.5">Provider:
                                                <?= htmlspecialchars($benefit['provider_name'] ?? 'N/A') ?>
                                            </p>
                                        </div>
                                        <?php if (!empty($benefit['coverage_amount'])): ?>
                                            <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded">
                                                $<?= number_format($benefit['coverage_amount'], 0) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($benefit['effective_date'])): ?>
                                        <p class="text-xs text-gray-400 mt-2">
                                            <i class="fa-solid fa-calendar mr-1"></i>
                                            <?= date('M d, Y', strtotime($benefit['effective_date'])) ?>
                                            <?php if (!empty($benefit['expiry_date'])): ?>
                                                - <?= date('M d, Y', strtotime($benefit['expiry_date'])) ?>
                                            <?php endif; ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Footer with clean design -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-200 flex justify-between items-center">
                <span class="text-xs text-gray-400">
                    <i class="fa-solid fa-clock mr-1"></i>updated <?= date('g:ia') ?>
                </span>
                <button
                    class="close-modal px-5 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors"
                    data-modal="profileModal">
                    Close
                </button>
            </div>

        <?php else: ?>
            <div class="text-center py-12 px-6">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-circle-exclamation text-2xl text-gray-400"></i>
                </div>
                <p class="text-gray-600 font-medium">Employee information not found</p>
                <p class="text-sm text-gray-400 mt-1">Please try again later</p>
                <button
                    class="close-modal mt-6 px-5 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-hover transition-colors"
                    data-modal="profileModal">
                    Close
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>