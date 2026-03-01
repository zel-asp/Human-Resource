<!-- View Shift Modal -->
<div id="viewShiftModal" class="fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden modal-enter z-50">
    <div class="bg-white rounded-xl max-w-md w-full mx-4 shadow-2xl">
        <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fa-solid fa-clock mr-2 text-primary"></i>
                Shift Details
            </h3>
            <button class="close-modal text-gray-400 hover:text-gray-600" data-modal="viewShiftModal">
                <i class="fa-solid fa-circle-xmark fa-xl"></i>
            </button>
        </div>

        <div class="p-6">
            <!-- Shift Header -->
            <div class="flex items-center gap-3 mb-4">
                <span class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-sun text-blue-600 text-xl"></i>
                </span>
                <div>
                    <p class="text-lg font-semibold">Morning Shift</p>
                    <p class="text-sm text-gray-500">7:00 AM - 3:00 PM (8 hours)</p>
                </div>
                <span class="ml-auto bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs">Active</span>
            </div>

            <!-- Schedule Info -->
            <div class="space-y-3 mb-4">
                <div class="flex justify-between text-sm p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-500">Date</span>
                    <span class="font-medium">Wednesday, March 12, 2025</span>
                </div>
                <div class="flex justify-between text-sm p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-500">Department</span>
                    <span class="font-medium">Restaurant</span>
                </div>
                <div class="flex justify-between text-sm p-3 bg-gray-50 rounded-lg">
                    <span class="text-gray-500">Supervisor</span>
                    <span class="font-medium">Sarah Johnson</span>
                </div>
            </div>

            <!-- Assigned Employees -->
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Assigned Employees (3)</p>
                <div class="space-y-2">
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2">
                            <span
                                class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-xs">GL</span>
                            <span class="text-sm">Grace Lee</span>
                        </div>
                        <span class="text-xs text-gray-400">Restaurant Server</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2">
                            <span
                                class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-xs">JS</span>
                            <span class="text-sm">John Smith</span>
                        </div>
                        <span class="text-xs text-gray-400">Bartender</span>
                    </div>
                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-2">
                            <span
                                class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-xs">MG</span>
                            <span class="text-sm">Maria Garcia</span>
                        </div>
                        <span class="text-xs text-gray-400">Waitstaff</span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="p-3 bg-yellow-50 rounded-lg mb-4">
                <p class="text-xs font-medium text-yellow-700 mb-1">Notes</p>
                <p class="text-xs text-gray-600">Team meeting at 8:30 AM in the main dining area.</p>
            </div>

            <!-- Actions -->
            <div class="flex gap-2">
                <button onclick="openModal('editShiftModal')"
                    class="flex-1 px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:bg-primary-hover transition">
                    Edit Shift
                </button>
                <button
                    class="flex-1 px-4 py-2 border border-red-200 text-red-600 rounded-lg text-sm font-medium hover:bg-red-50 transition">
                    Cancel Shift
                </button>
            </div>
        </div>
    </div>
</div>