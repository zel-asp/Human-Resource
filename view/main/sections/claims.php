<div class="tab-content" id="claims-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Claims & Reimbursement</h2>
            <p class="text-gray-500 text-sm mt-1">Manage employee expense claims and reimbursements</p>
        </div>
        <button class="btn-primary" onclick="openModal('newClaimModal')">
            <i class="fas fa-plus"></i>
            New Claim
        </button>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Pending Claims</p>
            <div class="flex items-baseline justify-between">
                <p class="text-2xl font-bold text-gray-800">8</p>
                <span class="text-sm text-gray-500">₱24.5K total</span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Awaiting review</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Approved</p>
            <div class="flex items-baseline justify-between">
                <p class="text-2xl font-bold text-gray-800">15</p>
                <span class="text-sm text-gray-500">₱45.2K total</span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Ready for processing</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Processed This Month</p>
            <div class="flex items-baseline justify-between">
                <p class="text-2xl font-bold text-gray-800">23</p>
                <span class="text-sm text-gray-500">₱67.8K total</span>
            </div>
            <p class="text-xs text-gray-400 mt-1">Successfully completed</p>
        </div>
    </div>

    <!-- Recent Claims Table -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Recent Claims</h3>
            <span class="text-xs font-medium bg-white text-gray-600 px-2.5 py-1 rounded-full border border-gray-200">
                Last 30 days
            </span>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee</th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Type
                            </th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Amount
                            </th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date
                            </th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                            </th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-xs font-medium">
                                        GL
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">Grace Lee</span>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">Meal Allowance</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱850</td>
                            <td class="py-3 text-sm text-gray-600">Mar 15, 2024</td>
                            <td class="py-3">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">
                                    Pending
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                        <i class="fas fa-eye text-xs"></i>
                                        View
                                    </button>
                                    <button
                                        class="text-sm text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-2.5 py-1 rounded-lg transition-colors duration-200 border border-green-200 flex items-center gap-1">
                                        <i class="fas fa-check text-xs"></i>
                                        Approve
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-xs font-medium">
                                        JD
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">James Davis</span>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">Transportation</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱320</td>
                            <td class="py-3 text-sm text-gray-600">Mar 14, 2024</td>
                            <td class="py-3">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    Approved
                                </span>
                            </td>
                            <td class="py-3">
                                <button
                                    class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                    <i class="fas fa-eye text-xs"></i>
                                    View
                                </button>
                            </td>
                        </tr>

                        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-xs font-medium">
                                        MR
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">Maria Rodriguez</span>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">Medical Reimbursement</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱2,450</td>
                            <td class="py-3 text-sm text-gray-600">Mar 12, 2024</td>
                            <td class="py-3">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    Processing
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                        <i class="fas fa-eye text-xs"></i>
                                        View
                                    </button>
                                    <button
                                        class="text-sm text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-2.5 py-1 rounded-lg transition-colors duration-200 border border-green-200 flex items-center gap-1">
                                        <i class="fas fa-check text-xs"></i>
                                        Approve
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-xs font-medium">
                                        RW
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">Robert Wilson</span>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">Training Fee</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱5,000</td>
                            <td class="py-3 text-sm text-gray-600">Mar 10, 2024</td>
                            <td class="py-3">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                    Rejected
                                </span>
                            </td>
                            <td class="py-3">
                                <button
                                    class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                    <i class="fas fa-eye text-xs"></i>
                                    View
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Table Footer with Summary -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 text-sm">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-600">
                            <span class="font-medium text-gray-800">Total Pending:</span> ₱3,620
                        </span>
                        <span class="text-gray-600">
                            <span class="font-medium text-gray-800">Total Approved:</span> ₱8,970
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">Pending</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">Approved</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">Processing</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="w-2 h-2 bg-red-400 rounded-full"></span>
                            <span class="text-xs text-gray-500">Rejected</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Footer -->
    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex items-center justify-between">
            <span class="text-xs text-gray-600">Average Claim Amount</span>
            <span class="text-sm font-medium text-gray-800">₱1,850</span>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex items-center justify-between">
            <span class="text-xs text-gray-600">Processing Time</span>
            <span class="text-sm font-medium text-gray-800">2.4 days</span>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex items-center justify-between">
            <span class="text-xs text-gray-600">Most Common Type</span>
            <span class="text-sm font-medium text-gray-800">Meal Allowance</span>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 flex items-center justify-between">
            <span class="text-xs text-gray-600">This Month Total</span>
            <span class="text-sm font-medium text-gray-800">₱67,800</span>
        </div>
    </div>
</div>