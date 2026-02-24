<div class="tab-content" id="leave-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Leave Management</h2>
            <p class="text-gray-600 mt-1">Manage employee leave requests and balances</p>
        </div>
    </div>

    <!-- Leave Balances -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="card p-4">
            <p class="text-sm text-gray-600">Vacation Leave</p>
            <p class="text-2xl font-bold text-primary">124</p>
            <p class="text-xs text-gray-500">days remaining</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Sick Leave</p>
            <p class="text-2xl font-bold text-green-600">86</p>
            <p class="text-xs text-gray-500">days remaining</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Emergency Leave</p>
            <p class="text-2xl font-bold text-blue-600">32</p>
            <p class="text-xs text-gray-500">days remaining</p>
        </div>
        <div class="card p-4">
            <p class="text-sm text-gray-600">Pending Requests</p>
            <p class="text-2xl font-bold text-yellow-600">12</p>
            <p class="text-xs text-gray-500">awaiting approval</p>
        </div>
    </div>

    <!-- Leave Requests -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Pending Leave Requests</h3>
        <div class="space-y-3">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium">Grace Lee</p>
                    <p class="text-sm">Vacation Leave • Mar 25-27, 2024</p>
                    <p class="text-xs text-gray-500">3 days</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm">Approve</button>
                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm">Deny</button>
                </div>
            </div>

            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="font-medium">James Davis</p>
                    <p class="text-sm">Sick Leave • Mar 18, 2024</p>
                    <p class="text-xs text-gray-500">1 day</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm">Approve</button>
                    <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm">Deny</button>
                </div>
            </div>
        </div>
    </div>
</div>