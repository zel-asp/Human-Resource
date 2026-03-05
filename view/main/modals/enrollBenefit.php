<div id="enrollBenefitModal" class="modal fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Enroll Employees in Benefits</h3>
            <button onclick="closeModal('enrollBenefitModal')"
                class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form class="space-y-5" method="POST" action="/benefits/enroll">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                <!-- Employee Selection with Checkboxes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-users mr-1 text-gray-400"></i>
                        Select Employees <span class="text-red-400">*</span>
                    </label>

                    <!-- Search Box -->
                    <div class="relative mb-3">
                        <input type="text" id="employeeSearch"
                            class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                            placeholder="Search employees...">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                    </div>

                    <!-- Employee List with Checkboxes -->
                    <div class="border border-gray-200 rounded-lg max-h-64 overflow-y-auto custom-scrollbar">
                        <?php if (!empty($employeesForBenefits)): ?>
                            <div class="p-2 space-y-1">
                                <?php foreach ($employeesForBenefits as $employee): ?>
                                    <label
                                        class="employee-item flex items-center p-3 hover:bg-gray-50 rounded-lg cursor-pointer transition-colors duration-150 <?= $employee['benefit_status'] == 'enrolled' ? 'bg-gray-50' : '' ?>"
                                        data-search="<?= strtolower(htmlspecialchars($employee['full_name'] . ' ' . ($employee['employee_number'] ?? '') . ' ' . ($employee['position'] ?? ''))) ?>">
                                        <div class="flex items-center gap-3 w-full">
                                            <!-- Checkbox -->
                                            <div class="relative flex items-center">
                                                <input type="checkbox" name="employee_ids[]"
                                                    value="<?= htmlspecialchars($employee['id']) ?>"
                                                    class="employee-checkbox w-4 h-4 text-gray-800 bg-gray-100 border-gray-300 rounded focus:ring-gray-200 focus:ring-2"
                                                    <?= $employee['benefit_status'] == 'enrolled' ? 'disabled' : '' ?>
                                                    onchange="updateSelectedCount()">
                                            </div>

                                            <!-- Employee Avatar/Initials -->
                                            <div
                                                class="w-8 h-8 <?= $employee['benefit_status'] == 'enrolled' ? 'bg-gray-300' : 'bg-gray-100' ?> rounded-full flex items-center justify-center flex-shrink-0">
                                                <span
                                                    class="text-xs font-medium <?= $employee['benefit_status'] == 'enrolled' ? 'text-gray-500' : 'text-gray-600' ?>">
                                                    <?= strtoupper(substr($employee['full_name'], 0, 2)) ?>
                                                </span>
                                            </div>

                                            <!-- Employee Details -->
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p
                                                        class="text-sm font-medium <?= $employee['benefit_status'] == 'enrolled' ? 'text-gray-400' : 'text-gray-800' ?>">
                                                        <?= htmlspecialchars($employee['full_name']) ?>
                                                    </p>
                                                    <?php if ($employee['benefit_status'] == 'enrolled'): ?>
                                                        <span
                                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                                            <i class="fas fa-check-circle mr-1 text-xs"></i>
                                                            Already Enrolled
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <p
                                                    class="text-xs <?= $employee['benefit_status'] == 'enrolled' ? 'text-gray-400' : 'text-gray-500' ?>">
                                                    <?= htmlspecialchars($employee['employee_number'] ?? 'No ID') ?> •
                                                    <?= htmlspecialchars($employee['position'] ?? 'No position') ?>
                                                </p>
                                            </div>
                                        </div>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="p-6 text-center text-gray-400">
                                <i class="fas fa-users text-2xl mb-2"></i>
                                <p class="text-sm">No employees available for enrollment</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Selection Summary -->
                    <div class="mt-2 flex items-center justify-between text-xs">
                        <span class="text-gray-500">
                            <span id="selectedCount">0</span> employee(s) selected
                        </span>
                        <button type="button" onclick="clearSelection()"
                            class="text-red-500 hover:text-red-700 transition-colors duration-200">
                            Clear all
                        </button>
                    </div>
                </div>

                <!-- Benefit Details Grid (same as before) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Benefit Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-gift mr-1 text-gray-400"></i>
                            Benefit Type <span class="text-red-400">*</span>
                        </label>
                        <select
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                            name="benefit_type" required>
                            <option value="">Select benefit type</option>
                            <option value="HMO - Principal">HMO - Principal</option>
                            <option value="HMO - Principal + 1 Dependent">HMO - Principal + 1 Dependent</option>
                            <option value="HMO - Principal + 2 Dependents">HMO - Principal + 2 Dependents</option>
                            <option value="Dental Insurance">Dental Insurance</option>
                            <option value="Life Insurance">Life Insurance</option>
                        </select>
                    </div>

                    <!-- Provider -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-building mr-1 text-gray-400"></i>
                            Provider <span class="text-red-400">*</span>
                        </label>
                        <select
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                            name="provider_id" required>
                            <option value="">Select provider</option>
                            <?php if (!empty($benefitProviders)): ?>
                                <?php foreach ($benefitProviders as $provider): ?>
                                    <option value="<?= htmlspecialchars($provider['id']) ?>">
                                        <?= htmlspecialchars($provider['provider_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Effective Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                            Effective Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date"
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                            name="effective_date" min="<?= date('Y-m-d') ?>" required>
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-calendar-times mr-1 text-gray-400"></i>
                            Expiry Date
                        </label>
                        <input type="date"
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                            name="expiry_date" min="<?= date('Y-m-d') ?>">
                    </div>

                    <!-- Coverage Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-coins mr-1 text-gray-400"></i>
                            Coverage Amount
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">₱</span>
                            <input type="number" step="0.01" min="0"
                                class="w-full pl-8 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                                name="coverage_amount" placeholder="0.00">
                        </div>
                    </div>

                    <!-- Monthly Premium -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-credit-card mr-1 text-gray-400"></i>
                            Monthly Premium
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">₱</span>
                            <input type="number" step="0.01" min="0"
                                class="w-full pl-8 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                                name="monthly_premium" placeholder="0.00">
                        </div>
                    </div>
                </div>

                <!-- Dependents -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-users mr-1 text-gray-400"></i>
                        Dependents (if applicable)
                    </label>
                    <textarea
                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200"
                        name="dependents" rows="2"
                        placeholder="List dependents (name, relation, birth date)..."></textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal('enrollBenefitModal')"
                        class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" onclick="return validateSelection()" class="btn-primary">
                        <i class="fas fa-user-plus"></i>
                        Enroll Selected Employees
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Search functionality
    document.getElementById('employeeSearch')?.addEventListener('input', function (e) {
        const searchTerm = e.target.value.toLowerCase();
        const employees = document.querySelectorAll('.employee-item');

        employees.forEach(employee => {
            const searchData = employee.dataset.search || '';
            if (searchData.includes(searchTerm)) {
                employee.style.display = '';
            } else {
                employee.style.display = 'none';
            }
        });
    });

    // Update selected count
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.employee-checkbox:checked');
        document.getElementById('selectedCount').textContent = checkboxes.length;
    }

    // Clear all selections
    function clearSelection() {
        document.querySelectorAll('.employee-checkbox:checked').forEach(cb => {
            cb.checked = false;
        });
        updateSelectedCount();
    }

    // Validate selection before submit
    function validateSelection() {
        const selected = document.querySelectorAll('.employee-checkbox:checked');

        // Collect selected employee IDs
        const selectedIds = Array.from(selected).map(cb => cb.value);
        document.getElementById('selectedEmployeesInput').value = selectedIds.join(',');

        return true;
    }

    // Add event listeners to checkboxes
    document.querySelectorAll('.employee-checkbox').forEach(cb => {
        cb.addEventListener('change', updateSelectedCount);
    });

    // Initialize count on modal open
    document.addEventListener('DOMContentLoaded', function () {
        updateSelectedCount();
    });
</script>