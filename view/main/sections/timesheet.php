<div class="tab-content" id="timesheet-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Timesheet Management</h2>
            <p class="text-gray-600 mt-1">Review and approve employee timesheets</p>
        </div>
        <div class="flex gap-2">
            <button class="btn-success" onclick="approveAllTimesheets()">Approve All</button>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex gap-2 mb-4">
            <select class="border rounded-lg px-3 py-2 text-sm">
                <option>This Week</option>
                <option>Last Week</option>
                <option>This Month</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3">Employee</th>
                        <th class="text-left py-3">Week Ending</th>
                        <th class="text-left py-3">Regular Hours</th>
                        <th class="text-left py-3">Overtime</th>
                        <th class="text-left py-3">Total Hours</th>
                        <th class="text-left py-3">Status</th>
                        <th class="text-left py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100">
                        <td class="py-3 font-medium">Grace Lee</td>
                        <td class="py-3">Mar 17, 2024</td>
                        <td class="py-3">38</td>
                        <td class="py-3">2.5</td>
                        <td class="py-3 font-medium">40.5</td>
                        <td class="py-3"><span class="status-badge bg-yellow-100 text-yellow-800">Pending</span></td>
                        <td class="py-3">
                            <button class="text-primary hover:underline mr-2"
                                onclick="viewTimesheet('Grace Lee')">View</button>
                            <button class="text-green-600 hover:underline"
                                onclick="approveTimesheet('Grace Lee')">Approve</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-100">
                        <td class="py-3 font-medium">James Davis</td>
                        <td class="py-3">Mar 17, 2024</td>
                        <td class="py-3">40</td>
                        <td class="py-3">0</td>
                        <td class="py-3 font-medium">40</td>
                        <td class="py-3"><span class="status-badge bg-green-100 text-green-800">Approved</span></td>
                        <td class="py-3">
                            <button class="text-primary hover:underline"
                                onclick="viewTimesheet('James Davis')">View</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>