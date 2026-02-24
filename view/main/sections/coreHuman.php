<div class="tab-content" id="hcm-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Core Human Capital Management</h2>
            <p class="text-gray-600 mt-1">Central employee records and organizational data</p>
        </div>
        <button class="btn-primary" onclick="openModal('addEmployeeModal')">
            <i class="fas fa-plus mr-2"></i>Add Employee
        </button>
    </div>

    <!-- Employee Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-sm text-gray-600">Total Employees</p>
            <p class="text-2xl font-bold text-primary">156</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Active</p>
            <p class="text-2xl font-bold text-green-600">142</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">On Leave</p>
            <p class="text-2xl font-bold text-blue-600">8</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Probationary</p>
            <p class="text-2xl font-bold text-yellow-600">12</p>
        </div>
    </div>

    <!-- Employee Directory -->
    <div class="card p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Employee Directory</h3>
            <input type="text" placeholder="Search employees..." class="border rounded-lg px-4 py-2 text-sm w-64">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3">Employee ID</th>
                        <th class="text-left py-3">Name</th>
                        <th class="text-left py-3">Position</th>
                        <th class="text-left py-3">Department</th>
                        <th class="text-left py-3">Hire Date</th>
                        <th class="text-left py-3">Status</th>
                        <th class="text-left py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">EMP001</td>
                        <td class="py-3 font-medium">Grace Lee</td>
                        <td class="py-3">Restaurant Server</td>
                        <td class="py-3">Restaurant</td>
                        <td class="py-3">Jan 15, 2023</td>
                        <td class="py-3"><span class="status-badge bg-green-100 text-green-800">Regular</span></td>
                        <td class="py-3">
                            <button class="text-primary hover:underline mr-2">View</button>
                            <button class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3">EMP002</td>
                        <td class="py-3 font-medium">James Davis</td>
                        <td class="py-3">Line Cook</td>
                        <td class="py-3">Kitchen</td>
                        <td class="py-3">Mar 10, 2024</td>
                        <td class="py-3"><span class="status-badge bg-yellow-100 text-yellow-800">Probationary</span>
                        </td>
                        <td class="py-3">
                            <button class="text-primary hover:underline mr-2">View</button>
                            <button class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>