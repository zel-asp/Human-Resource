<div class="tab-content" id="time-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Time and Attendance</h2>
            <p class="text-gray-600 mt-1">Real-time employee attendance tracking</p>
        </div>
        <button class="btn-primary" onclick="openModal('manualTimeModal')">
            <i class="fas fa-plus mr-2"></i>Manual Entry
        </button>
    </div>

    <!-- Today's Attendance Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-sm text-gray-600">Present Today</p>
            <p class="text-2xl font-bold text-green-600">42</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">On Leave</p>
            <p class="text-2xl font-bold text-blue-600">8</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Late</p>
            <p class="text-2xl font-bold text-yellow-600">3</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Absent</p>
            <p class="text-2xl font-bold text-red-600">2</p>
        </div>
    </div>

    <!-- Attendance List -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Today's Attendance</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3">Employee</th>
                        <th class="text-left py-3">Department</th>
                        <th class="text-left py-3">Shift</th>
                        <th class="text-left py-3">Time In</th>
                        <th class="text-left py-3">Time Out</th>
                        <th class="text-left py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                <span class="attendance-status status-present"></span>
                                Grace Lee
                            </div>
                        </td>
                        <td class="py-3">Restaurant</td>
                        <td class="py-3">Morning (7am-3pm)</td>
                        <td class="py-3">6:55 AM</td>
                        <td class="py-3">-</td>
                        <td class="py-3"><span class="status-badge bg-green-100 text-green-800">Present</span></td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">
                            <div class="flex items-center gap-2">
                                <span class="attendance-status status-late"></span>
                                James Davis
                            </div>
                        </td>
                        <td class="py-3">Kitchen</td>
                        <td class="py-3">Morning (6am-2pm)</td>
                        <td class="py-3">6:30 AM</td>
                        <td class="py-3">-</td>
                        <td class="py-3"><span class="status-badge bg-yellow-100 text-yellow-800">Late
                                (15 min)</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>