<div id="assessmentModal" class="modal">
    <div class="modal-content max-w-3xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Competency Assessment Form</h3>
            <button onclick="closeModal('assessmentModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <form id="competencyAssessmentForm" method="POST" action="/competency-assessment">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <div class="bg-blue-50 p-4 rounded-lg mb-4">
                <h4 class="font-semibold text-blue-800 mb-2">Step 1: Prepare Assessment</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Employee</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="assigned_to"
                            id="employeeSelect" required onchange="showCompetencyName()">
                            <option value="">Select employee with completed training</option>
                            <?php if (!empty($employeesForDropdown)): ?>
                                <?php foreach ($employeesForDropdown as $employee): ?>
                                    <option value="<?= $employee['id'] ?>"
                                        data-competency-name="<?= htmlspecialchars($employee['competency_name']) ?>"
                                        data-competency-id="<?= $employee['competency_id'] ?>">
                                        <?= htmlspecialchars($employee['full_name']) ?> -
                                        <?= htmlspecialchars($employee['position']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No employees available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Competency to Assess</label>
                        <input type="text" class="profile-input bg-gray-100" id="competencyNameDisplay" readonly
                            placeholder="Competency name will appear here">
                        <input type="hidden" name="competency_id" id="competencyIdInput">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Assessment Date</label>
                        <input type="date" class="profile-input" name="assessment_date" value="<?= date('Y-m-d') ?>"
                            min="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Evaluator</label>
                        <select class="profile-input" name="assessor_id" required>
                            <option value="">Select Evaluator</option>
                            <?php foreach ($evaluators as $evaluator): ?>
                                <option value="<?= $evaluator['id'] ?>">
                                    <?= htmlspecialchars($evaluator['full_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Evaluation Form -->
            <div class="mb-4">
                <h4 class="font-semibold mb-2">Step 2: Evaluate Competency</h4>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium">Proficiency Level</label>
                        <select class="profile-input" name="proficiency_level" required>
                            <option value="">Select Level</option>
                            <option value="1">1 - Novice (Needs supervision)</option>
                            <option value="2">2 - Developing (Can perform basic tasks)</option>
                            <option value="3">3 - Intermediate (Works independently)</option>
                            <option value="4">4 - Advanced (Guides others)</option>
                            <option value="5">5 - Expert (Strategic advisor)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Assessment Notes</label>
                        <textarea class="profile-input" name="assessment_notes" rows="3"
                            placeholder="Provide specific examples and observations..." required></textarea>
                    </div>
                </div>
            </div>

            <!-- Submit Evaluation -->
            <div class="flex justify-end gap-2 mb-4">
                <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg"
                    onclick="closeModal('assessmentModal')">Cancel</button>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-check mr-2"></i>Submit Evaluation
                </button>
            </div>
        </form>
    </div>
</div>