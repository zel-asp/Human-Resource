<!-- Complete Training Modal -->
<div id="completeTrainingModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Complete Training & Record Results</h3>
            <button onclick="closeModal('completeTrainingModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form class="space-y-4">
            <!-- Training Info -->
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="font-medium">Customer Service Excellence Training</p>
                <p class="text-sm text-gray-600">Mar 15-16, 2026 • Trainer: Sarah Johnson</p>
            </div>

            <!-- Record Results per Employee -->
            <div>
                <label class="block text-sm font-medium mb-2">Training Results</label>
                <div class="space-y-3 max-h-60 overflow-y-auto">
                    <div class="border rounded-lg p-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">Grace Lee</p>
                                <p class="text-sm text-gray-600">Server</p>
                            </div>
                            <select class="border rounded p-1 text-sm">
                                <option>Select Result</option>
                                <option>Passed</option>
                                <option>Failed</option>
                                <option>Incomplete</option>
                                <option>Certified</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label class="text-xs block">Assessment Score (%)</label>
                            <input type="number" class="border rounded p-1 text-sm w-20" min="0" max="100">
                        </div>
                        <div class="mt-2">
                            <label class="text-xs block">Trainer Comments</label>
                            <textarea class="border rounded p-1 text-sm w-full" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="border rounded-lg p-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">James Wilson</p>
                                <p class="text-sm text-gray-600">Server</p>
                            </div>
                            <select class="border rounded p-1 text-sm">
                                <option>Select Result</option>
                                <option>Passed</option>
                                <option>Failed</option>
                                <option>Incomplete</option>
                                <option>Certified</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label class="text-xs block">Assessment Score (%)</label>
                            <input type="number" class="border rounded p-1 text-sm w-20" min="0" max="100">
                        </div>
                        <div class="mt-2">
                            <label class="text-xs block">Trainer Comments</label>
                            <textarea class="border rounded p-1 text-sm w-full" rows="2"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Certificate Upload (for certification type) -->
            <div>
                <label class="block text-sm font-medium mb-1">Upload Certificates (if applicable)</label>
                <input type="file" class="profile-input w-full p-2 border rounded" multiple accept=".pdf,.jpg">
            </div>

            <!-- Update Competency -->
            <div class="border-t pt-4">
                <div class="flex items-start gap-3">
                    <input type="checkbox" id="updateCompetency" class="w-4 h-4 mt-1" checked>
                    <div>
                        <label for="updateCompetency" class="text-sm font-medium">Update employee competency
                            records</label>
                        <p class="text-xs text-gray-500">This will automatically update competency levels based on
                            training results</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg"
                    onclick="closeModal('completeTrainingModal')">Cancel</button>
                <button type="button" class="btn-primary px-4 py-2" onclick="completeTraining()">
                    <i class="fas fa-save mr-2"></i>Save Results & Update Competency
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Main Training Management Content -->
<div class="tab-content" id="training-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Training Management</h2>
            <p class="text-gray-600 mt-1">Manage training programs based on competency gaps</p>
        </div>
        <button class="btn-primary" onclick="openModal('trainingModal')">
            <i class="fas fa-plus mr-2"></i>New Training Program
        </button>
    </div>

    <!-- Training Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-sm text-gray-600">Active Trainings</p>
            <p class="text-2xl font-bold">6</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Internal</p>
            <p class="text-2xl font-bold">4</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">External</p>
            <p class="text-2xl font-bold">1</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Certifications</p>
            <p class="text-2xl font-bold">1</p>
        </div>
    </div>

    <!-- Trainings by Type -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Internal Trainings -->
        <div class="card p-6">
            <h3 class="font-semibold mb-3 flex items-center">
                <i class="fas fa-building mr-2 text-blue-600"></i>
                Internal Trainings
            </h3>
            <div class="space-y-3">
                <div class="border-l-4 border-blue-500 pl-3">
                    <p class="font-medium">New Hire Orientation</p>
                    <p class="text-sm text-gray-600">Trainer: Sarah Johnson</p>
                    <p class="text-xs text-gray-500">Mar 15, 2026 • 8 attendees</p>
                </div>
                <div class="border-l-4 border-blue-500 pl-3">
                    <p class="font-medium">POS System Training</p>
                    <p class="text-sm text-gray-600">Trainer: Mike Chen</p>
                    <p class="text-xs text-gray-500">Mar 18, 2026 • 5 attendees</p>
                </div>
            </div>
        </div>

        <!-- External Trainings -->
        <div class="card p-6">
            <h3 class="font-semibold mb-3 flex items-center">
                <i class="fas fa-globe mr-2 text-green-600"></i>
                External Trainings
            </h3>
            <div class="space-y-3">
                <div class="border-l-4 border-green-500 pl-3">
                    <p class="font-medium">Leadership Workshop</p>
                    <p class="text-sm text-gray-600">Provider: Leadership Academy</p>
                    <p class="text-xs text-gray-500">Mar 20-22, 2026 • 3 attendees</p>
                </div>
            </div>
        </div>

        <!-- Certifications -->
        <div class="card p-6">
            <h3 class="font-semibold mb-3 flex items-center">
                <i class="fas fa-certificate mr-2 text-purple-600"></i>
                Certifications
            </h3>
            <div class="space-y-3">
                <div class="border-l-4 border-purple-500 pl-3">
                    <p class="font-medium">Food Safety Manager</p>
                    <p class="text-sm text-gray-600">Provider: ServSafe</p>
                    <p class="text-xs text-gray-500">Certification #: SERV-2026-123</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Training Schedule Table -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Training Schedule</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3">Training Title</th>
                        <th class="text-left py-3">Type</th>
                        <th class="text-left py-3">Provider/Trainer</th>
                        <th class="text-left py-3">Schedule</th>
                        <th class="text-left py-3">Attendees</th>
                        <th class="text-left py-3">Status</th>
                        <th class="text-left py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">Customer Service Excellence</td>
                        <td class="py-3"><span class="status-badge bg-blue-100 text-blue-800">Internal</span></td>
                        <td class="py-3">Sarah Johnson</td>
                        <td class="py-3">Mar 15-16, 9am-5pm</td>
                        <td class="py-3">12</td>
                        <td class="py-3"><span class="status-badge bg-green-100 text-green-800">Scheduled</span></td>
                        <td class="py-3">
                            <button class="text-primary hover:text-primary-dark"
                                onclick="openModal('completeTrainingModal')">
                                <i class="fas fa-check-circle mr-1"></i>Complete
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">Food Safety Certification</td>
                        <td class="py-3"><span class="status-badge bg-purple-100 text-purple-800">Certification</span>
                        </td>
                        <td class="py-3">ServSafe</td>
                        <td class="py-3">Mar 25, 2026</td>
                        <td class="py-3">8</td>
                        <td class="py-3"><span class="status-badge bg-yellow-100 text-yellow-800">Pending</span></td>
                        <td class="py-3">
                            <button class="text-primary hover:text-primary-dark" disabled>Not Started</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Completed Trainings & Results -->
    <div class="card p-6 mt-6">
        <h3 class="text-lg font-semibold mb-4">Completed Trainings & Results</h3>
        <div class="space-y-4">
            <div class="border rounded-lg p-4">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium">Food Safety Refresher</p>
                        <p class="text-sm text-gray-600">Completed: Mar 10, 2026 • Trainer: Lisa Wong</p>
                    </div>
                    <span class="status-badge bg-green-100 text-green-800">Completed</span>
                </div>

                <!-- Results per employee -->
                <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="text-sm flex justify-between items-center p-2 bg-gray-50 rounded">
                        <span>Grace Lee</span>
                        <span class="font-medium text-green-600">Passed (92%)</span>
                    </div>
                    <div class="text-sm flex justify-between items-center p-2 bg-gray-50 rounded">
                        <span>John Smith</span>
                        <span class="font-medium text-green-600">Passed (88%)</span>
                    </div>
                </div>

                <!-- Competency Update -->
                <div class="mt-2 text-xs text-gray-500 flex items-center">
                    <i class="fas fa-arrow-up text-green-500 mr-1"></i>
                    Competency levels updated: Customer Service (2 → 3), Food Safety (3 → 4)
                </div>
            </div>
        </div>
    </div>
</div>