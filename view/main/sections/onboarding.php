<div class="tab-content" id="onboarding-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">New Hire Onboarding</h2>
            <p class="text-gray-600 mt-1">Track and manage new employees through their onboarding
                journey</p>
        </div>
        <button class="btn-primary" onclick="openModal('addNewHireModal')">
            <i class="fas fa-plus mr-2"></i>Add New Hire
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Onboarding Progress Board -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Onboarding Progress Board -->
            <div class="card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Onboarding Progress</h3>
                    <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5">
                        <option>All Departments</option>
                        <option>Kitchen</option>
                        <option>Service</option>
                        <option>Management</option>
                    </select>
                </div>
                <div class="space-y-4">
                    <!-- Onboarding 1 - Grace Lee -->
                    <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                                    GL
                                </div>
                                <div>
                                    <h4 class="font-medium">Grace Lee</h4>
                                    <p class="text-sm text-gray-600">Restaurant Server • Started Mar 15,
                                        2024</p>
                                </div>
                            </div>
                            <span class="status-badge bg-blue-100 text-blue-800">Week 2 of 4</span>
                        </div>

                        <!-- Overall Progress Bar -->
                        <div class="mb-3">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-medium">Overall Progress</span>
                                <span>65%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill blue" style="width: 65%"></div>
                            </div>
                        </div>

                        <!-- Onboarding Steps - MODIFIED: Made responsive -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-4">
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-full mx-auto flex items-center justify-center text-green-600 mb-1">
                                    ✓
                                </div>
                                <p class="text-xs font-medium">Paperwork</p>
                                <p class="text-xs text-gray-500">Completed</p>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-full mx-auto flex items-center justify-center text-green-600 mb-1">
                                    ✓
                                </div>
                                <p class="text-xs font-medium">Uniform</p>
                                <p class="text-xs text-gray-500">Completed</p>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div
                                    class="w-8 h-8 bg-blue-100 rounded-full mx-auto flex items-center justify-center text-blue-600 mb-1">
                                    ⋯
                                </div>
                                <p class="text-xs font-medium">Training</p>
                                <p class="text-xs text-gray-500">3/5 modules</p>
                                <div class="progress-bar mt-1">
                                    <div class="progress-fill green" style="width: 60%"></div>
                                </div>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded-lg">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-full mx-auto flex items-center justify-center text-gray-400 mb-1">
                                    ○
                                </div>
                                <p class="text-xs font-medium">Mentor</p>
                                <p class="text-xs text-gray-500">Not started</p>
                            </div>
                        </div>

                        <!-- Assigned Tasks Section -->
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="text-sm font-semibold text-gray-700">Assigned Tasks</h5>
                                <button onclick="openModal('addTaskModal1')"
                                    class="text-xs text-primary hover:underline">
                                    <i class="fas fa-plus mr-1"></i>Add Task
                                </button>
                            </div>

                            <!-- Task List -->
                            <div class="space-y-2">
                                <!-- Task 1 - Completed -->
                                <div class="flex items-center justify-between text-sm bg-green-50 p-2 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" checked disabled class="rounded text-green-600">
                                        <div>
                                            <span class="font-medium line-through text-gray-500">Complete
                                                I-9 Form</span>
                                            <p class="text-xs text-gray-500">Assigned to: HR Dept</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-500">Completed Mar 14</span>
                                </div>

                                <!-- Task 2 - In Progress -->
                                <div class="flex items-center justify-between text-sm bg-blue-50 p-2 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded text-primary">
                                        <div>
                                            <span class="font-medium">Menu Training</span>
                                            <p class="text-xs text-gray-500">Assigned to: Sarah Johnson
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-medium text-orange-600">Due Today,
                                            2pm</span>
                                    </div>
                                </div>

                                <!-- Task 3 - Upcoming -->
                                <div class="flex items-center justify-between text-sm p-2">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded text-primary">
                                        <div>
                                            <span class="font-medium">POS System Training</span>
                                            <p class="text-xs text-gray-500">Assigned to: Mike Chen</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-600">Due Mar 20</span>
                                    </div>
                                </div>

                                <!-- Task 4 - Overdue -->
                                <div class="flex items-center justify-between text-sm bg-red-50 p-2 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" class="rounded text-primary">
                                        <div>
                                            <span class="font-medium">Food Handler's Permit</span>
                                            <p class="text-xs text-gray-500">Assigned to: Grace Lee</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-medium text-red-600">Overdue by 2
                                            days</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Next Task and View Details -->
                            <div class="flex justify-between items-center text-sm mt-3">
                                <div>
                                    <span class="text-gray-600">Next Task:</span>
                                    <span class="font-medium ml-1">Menu Training - Today 2pm</span>
                                </div>
                                <button onclick="openModal('onboardingDetailModal1')"
                                    class="text-primary hover:underline">View Details</button>
                            </div>
                        </div>
                    </div>

                    <!-- Onboarding 2 - James Davis -->
                    <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-secondary rounded-full flex items-center justify-center text-white font-semibold">
                                    JD
                                </div>
                                <div>
                                    <h4 class="font-medium">James Davis</h4>
                                    <p class="text-sm text-gray-600">Line Cook • Started Mar 10, 2024
                                    </p>
                                </div>
                            </div>
                            <span class="status-badge bg-green-100 text-green-800">Week 3 of 4</span>
                        </div>

                        <!-- Assigned Tasks Summary -->
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h5 class="text-sm font-semibold text-gray-700">Task Summary</h5>
                                <span class="text-xs bg-primary text-white px-2 py-1 rounded-full">4
                                    tasks remaining</span>
                            </div>

                            <!-- Task List with Progress Bars -->
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span>Kitchen Safety Training</span>
                                        <span class="text-orange-600">Due Tomorrow</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill yellow" style="width: 75%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span>Knife Skills Assessment</span>
                                        <span class="text-gray-600">Due Mar 22</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill blue" style="width: 30%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar - Tasks and Upcoming Start Dates -->
        <div class="space-y-6">
            <!-- Task Assignment Card -->
            <div class="card p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Quick Task Assignment</h3>
                    <button class="text-primary text-sm hover:underline">View All</button>
                </div>

                <!-- Task Assignment Form -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign Task
                            To</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option>Select new hire</option>
                            <option>Grace Lee - Server</option>
                            <option>James Davis - Cook</option>
                            <option>Isabella Martinez - Sous Chef</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Task Type</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option>Select task type</option>
                            <option>Paperwork</option>
                            <option>Training Module</option>
                            <option>Equipment Setup</option>
                            <option>Mentor Meeting</option>
                            <option>Certification</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Task
                            Description</label>
                        <input type="text" placeholder="e.g., Complete W-4 Form"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Due Date</label>
                            <input type="date" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option>Low</option>
                                <option>Medium</option>
                                <option>High</option>
                                <option>Urgent</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign To
                            (Staff)</label>
                        <select class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                            <option>Select trainer/mentor</option>
                            <option>Sarah Johnson - Manager</option>
                            <option>Mike Chen - Trainer</option>
                            <option>Lisa Wong - HR</option>
                        </select>
                    </div>

                    <button class="w-full btn-primary py-2">
                        <i class="fas fa-plus-circle mr-2"></i>Assign Task
                    </button>
                </div>
            </div>

            <!-- Upcoming Start Dates with Tasks -->
            <div class="card p-6">
                <h3 class="text-lg font-semibold mb-4">Upcoming Start Dates</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Isabella Martinez</p>
                            <p class="text-sm text-gray-600">Sous Chef • Mar 18, 2024</p>
                            <!-- Pre-boarding Tasks -->
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">
                                    3 tasks pending
                                </span>
                                <span class="text-xs text-gray-500">In 3 days</span>
                            </div>
                        </div>
                        <button class="text-primary text-sm hover:underline"
                            onclick="openModal('preboardingTasksModal')">
                            View Tasks
                        </button>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium">Marcus Wong</p>
                            <p class="text-sm text-gray-600">Dishwasher • Mar 20, 2024</p>
                            <!-- Pre-boarding Tasks -->
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">
                                    All tasks ready
                                </span>
                                <span class="text-xs text-gray-500">In 5 days</span>
                            </div>
                        </div>
                        <button class="text-primary text-sm hover:underline"
                            onclick="openModal('preboardingTasksModal2')">
                            View Tasks
                        </button>
                    </div>
                </div>

                <!-- Task Summary -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <h4 class="font-medium text-sm mb-3">This Week's Tasks</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Total Tasks</span>
                            <span class="font-semibold">24</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Completed</span>
                            <span class="font-semibold text-green-600">16</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">In Progress</span>
                            <span class="font-semibold text-blue-600">5</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Overdue</span>
                            <span class="font-semibold text-red-600">3</span>
                        </div>
                    </div>

                    <!-- Progress Bar for Weekly Tasks -->
                    <div class="mt-3">
                        <div class="flex justify-between text-xs mb-1">
                            <span>Weekly Progress</span>
                            <span>67%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill green" style="width: 67%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>