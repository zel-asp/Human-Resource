<div class="tab-content" id="learning-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Learning Management</h2>
            <p class="text-gray-600 mt-1">Track employee courses and certifications</p>
        </div>
        <button class="btn-primary" onclick="openModal('newCourseModal')">
            <i class="fas fa-plus mr-2"></i>Add Course
        </button>
    </div>

    <!-- Learning Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-sm text-gray-600">Active Courses</p>
            <p class="text-2xl font-bold text-primary">24</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Enrolled</p>
            <p class="text-2xl font-bold text-green-600">156</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Completed</p>
            <p class="text-2xl font-bold text-blue-600">89</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Certifications</p>
            <p class="text-2xl font-bold text-purple-600">45</p>
        </div>
    </div>

    <!-- Course List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card p-6">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-semibold">Food Safety Certification</h3>
                    <p class="text-sm text-gray-600">ServSafe Manager Course</p>
                </div>
                <span class="status-badge bg-green-100 text-green-800">Active</span>
            </div>
            <div class="space-y-2 text-sm">
                <p><i class="fas fa-users mr-2"></i>32 enrolled</p>
                <p><i class="fas fa-calendar mr-2"></i>Due: Apr 15, 2024</p>
                <div class="mt-3">
                    <div class="flex justify-between text-xs mb-1">
                        <span>Completion Rate</span>
                        <span>65%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill green" style="width: 65%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <h3 class="font-semibold">Wine & Beverage Training</h3>
                    <p class="text-sm text-gray-600">Sommelier Basics</p>
                </div>
                <span class="status-badge bg-blue-100 text-blue-800">Upcoming</span>
            </div>
            <div class="space-y-2 text-sm">
                <p><i class="fas fa-users mr-2"></i>18 enrolled</p>
                <p><i class="fas fa-calendar mr-2"></i>Starts: Apr 20, 2024</p>
                <div class="mt-3">
                    <div class="flex justify-between text-xs mb-1">
                        <span>Registration</span>
                        <span>45%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill blue" style="width: 45%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>