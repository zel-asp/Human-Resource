<div class="tab-content" id="payroll-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Payroll Management</h2>
            <p class="text-gray-500 text-sm mt-1">Process payroll and manage compensation</p>
        </div>
        <button class="btn-primary" onclick="processPayroll()">
            <i class="fas fa-calculator"></i>
            Process Payroll
        </button>
    </div>

    <!-- Payroll Period Info -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 mb-6 shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-gray-600"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Current Payroll Period</p>
                    <p class="text-lg font-semibold text-gray-800">Mar 1-15, 2024</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500">Payroll Date:</span>
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                    March 20, 2024
                </span>
            </div>
        </div>
    </div>

    <!-- Payroll Summary Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Gross Pay</p>
            <p class="text-2xl font-bold text-gray-800">₱1,245,000</p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-xs text-gray-400">Before deductions</span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Total Deductions</p>
            <p class="text-2xl font-bold text-gray-800">₱155,625</p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-xs text-gray-400">Taxes & benefits</span>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Net Pay</p>
            <p class="text-2xl font-bold text-gray-800">₱1,089,375</p>
            <div class="flex items-center gap-2 mt-1">
                <span class="text-xs text-gray-400">Take-home pay</span>
            </div>
        </div>
    </div>

    <!-- Payroll List -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div
            class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h3 class="text-lg font-semibold text-gray-800">Payroll Summary</h3>
            <div class="flex items-center gap-3">
                <span class="text-xs text-gray-500">86 employees</span>
                <span class="inline-flex items-center gap-1 text-xs">
                    <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                    <span class="text-gray-500">Processed: 42</span>
                </span>
                <span class="inline-flex items-center gap-1 text-xs">
                    <span class="w-2 h-2 bg-yellow-400 rounded-full"></span>
                    <span class="text-gray-500">Pending: 44</span>
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Employee</th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Regular Hours</th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Overtime</th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Gross
                                Pay</th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deductions</th>
                            <th class="text-left py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Net
                                Pay</th>
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
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Grace Lee</p>
                                        <p class="text-xs text-gray-400">Restaurant Server</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">80</td>
                            <td class="py-3 text-sm text-gray-600">5</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱25,500</td>
                            <td class="py-3 text-sm text-gray-600">₱3,825</td>
                            <td class="py-3 text-sm font-semibold text-gray-800">₱21,675</td>
                            <td class="py-3">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    Processed
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                        <i class="fas fa-receipt text-xs"></i>
                                        Payslip
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
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">James Davis</p>
                                        <p class="text-xs text-gray-400">Line Cook</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">80</td>
                            <td class="py-3 text-sm text-gray-600">0</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱18,400</td>
                            <td class="py-3 text-sm text-gray-600">₱2,760</td>
                            <td class="py-3 text-sm font-semibold text-gray-800">₱15,640</td>
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
                                        <i class="fas fa-edit text-xs"></i>
                                        Review
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
                                        MC
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Michael Chen</p>
                                        <p class="text-xs text-gray-400">Sous Chef</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">80</td>
                            <td class="py-3 text-sm text-gray-600">8</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱32,800</td>
                            <td class="py-3 text-sm text-gray-600">₱4,920</td>
                            <td class="py-3 text-sm font-semibold text-gray-800">₱27,880</td>
                            <td class="py-3">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                    Processed
                                </span>
                            </td>
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <button
                                        class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-2.5 py-1 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                        <i class="fas fa-receipt text-xs"></i>
                                        Payslip
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                            <td class="py-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-xs font-medium">
                                        SW
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Sarah Wong</p>
                                        <p class="text-xs text-gray-400">Pastry Chef</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-sm text-gray-600">80</td>
                            <td class="py-3 text-sm text-gray-600">3</td>
                            <td class="py-3 text-sm font-medium text-gray-800">₱28,500</td>
                            <td class="py-3 text-sm text-gray-600">₱4,275</td>
                            <td class="py-3 text-sm font-semibold text-gray-800">₱24,225</td>
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
                                        <i class="fas fa-edit text-xs"></i>
                                        Review
                                    </button>
                                    <button
                                        class="text-sm text-green-600 hover:text-green-700 bg-green-50 hover:bg-green-100 px-2.5 py-1 rounded-lg transition-colors duration-200 border border-green-200 flex items-center gap-1">
                                        <i class="fas fa-check text-xs"></i>
                                        Approve
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Payroll Summary Footer -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">Total Regular Hours</p>
                        <p class="text-lg font-semibold text-gray-800">6,880 hrs</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Total Overtime Hours</p>
                        <p class="text-lg font-semibold text-gray-800">245 hrs</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Average Net Pay</p>
                        <p class="text-lg font-semibold text-gray-800">₱21,450</p>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-500">Showing <span class="font-medium">1-4</span> of <span
                        class="font-medium">86</span> employees</p>
                <div class="flex items-center gap-2">
                    <button
                        class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200 disabled:opacity-50"
                        disabled>
                        <i class="fas fa-chevron-left text-xs"></i>
                    </button>
                    <button
                        class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-gray-800 text-white">1</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">2</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">3</button>
                    <span class="text-gray-400">...</span>
                    <button
                        class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">22</button>
                    <button
                        class="w-8 h-8 flex items-center justify-center text-sm rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors duration-200">
                        <i class="fas fa-chevron-right text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payroll Actions -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <button
            class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-left flex items-start gap-3">
            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center shrink-0">
                <i class="fas fa-file-invoice text-gray-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800">Generate Payslips</p>
                <p class="text-xs text-gray-500 mt-1">PDF format</p>
            </div>
        </button>

        <button
            class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-left flex items-start gap-3">
            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center shrink-0">
                <i class="fas fa-chart-bar text-gray-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800">Payroll Report</p>
                <p class="text-xs text-gray-500 mt-1">Export summary</p>
            </div>
        </button>

        <button
            class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-left flex items-start gap-3">
            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center shrink-0">
                <i class="fas fa-bank text-gray-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800">Bank File</p>
                <p class="text-xs text-gray-500 mt-1">For payroll transfer</p>
            </div>
        </button>

        <button
            class="p-4 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 transition-colors duration-200 text-left flex items-start gap-3">
            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center shrink-0">
                <i class="fas fa-history text-gray-600"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-800">Payroll History</p>
                <p class="text-xs text-gray-500 mt-1">View previous runs</p>
            </div>
        </button>
    </div>
</div>