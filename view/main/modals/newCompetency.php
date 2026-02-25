<div id="assessmentModal" class="modal">
    <div class="modal-content max-w-3xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Competency Assessment Form</h3>
            <button onclick="closeModal('assessmentModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Assessment Preparation Section -->
        <div class="bg-blue-50 p-4 rounded-lg mb-4">
            <h4 class="font-semibold text-blue-800 mb-2">Step 1: Prepare Assessment</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Employee</label>
                    <select class="profile-input">
                        <option>Select Employee</option>
                        <option>Grace Lee - Server</option>
                        <option>John Smith - Cook</option>
                        <option>Maria Garcia - Manager</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Competency to Assess</label>
                    <select class="profile-input">
                        <option>Select Competency</option>
                        <option>Customer Service</option>
                        <option>Food Safety</option>
                        <option>POS Systems</option>
                        <option>Team Leadership</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Assessment Date</label>
                    <input type="date" class="profile-input" value="2026-02-25">
                </div>
                <div>
                    <label class="block text-sm font-medium">Assessor</label>
                    <input type="text" class="profile-input" value="Current User" readonly>
                </div>
            </div>
        </div>

        <!-- Evaluation Form -->
        <div class="mb-4">
            <h4 class="font-semibold mb-2">Step 2: Evaluate Competency</h4>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium">Proficiency Level</label>
                    <select class="profile-input">
                        <option>Select Level</option>
                        <option value="1">1 - Novice (Needs supervision)</option>
                        <option value="2">2 - Developing (Can perform basic tasks)</option>
                        <option value="3">3 - Intermediate (Works independently)</option>
                        <option value="4">4 - Advanced (Guides others)</option>
                        <option value="5">5 - Expert (Strategic advisor)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Assessment Notes</label>
                    <textarea class="profile-input" rows="3"
                        placeholder="Provide specific examples and observations..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">Supporting Evidence</label>
                    <input type="file" class="profile-input" accept=".pdf,.doc,.docx">
                </div>
            </div>
        </div>

        <!-- Submit Evaluation -->
        <div class="flex justify-end gap-2 mb-4">
            <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg"
                onclick="closeModal('assessmentModal')">Cancel</button>
            <button type="button" class="btn-primary" onclick="submitAssessment()">
                <i class="fas fa-check mr-2"></i>Submit Evaluation
            </button>
        </div>
    </div>
</div>