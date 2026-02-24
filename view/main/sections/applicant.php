<div class="tab-content" id="applicant-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Applicant Management</h2>
            <p class="text-gray-600 mt-1">Track and manage job applicants through the hiring pipeline
            </p>
        </div>
    </div>

    <div class="card p-6">
        <!-- Filter Tabs - MODIFIED: Made scrollable on mobile -->
        <div class="flex gap-2 mb-6 border-b border-gray-200 pb-2 overflow-x-auto whitespace-nowrap">
            <button class="px-4 py-2 text-sm font-medium text-primary border-b-2 border-primary"
                onclick="filterApplicants('all')">All</button>
            <button class="px-4 py-2 text-sm font-medium text-gray-600" onclick="filterApplicants('new')">New</button>
            <button class="px-4 py-2 text-sm font-medium text-gray-600"
                onclick="filterApplicants('review')">Review</button>
            <button class="px-4 py-2 text-sm font-medium text-gray-600"
                onclick="filterApplicants('interview')">Interview</button>
            <button class="px-4 py-2 text-sm font-medium text-gray-600"
                onclick="filterApplicants('offer')">Offer</button>
            <button class="px-4 py-2 text-sm font-medium text-gray-600"
                onclick="filterApplicants('rejected')">Rejected</button>
        </div>

        <!-- Applicants Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Name</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Position</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Department
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Applied Date
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Resume</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 font-medium">Alice Johnson</td>
                        <td class="py-3 px-4">Restaurant Server</td>
                        <td class="py-3 px-4">
                            <span class="location-badge location-restaurant">
                                <i class="fas fa-utensils"></i>
                                Restaurant
                            </span>
                        </td>
                        <td class="py-3 px-4">2024-02-15</td>
                        <td class="py-3 px-4">
                            <button onclick="openModal('resumeModal1')" class="text-primary hover:underline">
                                <i class="fas fa-file-pdf mr-1"></i>View
                            </button>
                        </td>
                        <td class="py-3 px-4">
                            <select class="status-select" onchange="updateStatus('Alice Johnson', this.value)">
                                <option value="New">New</option>
                                <option value="Review">Review</option>
                                <option value="Interview" selected>Interview</option>
                                <option value="Offer">Offer</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </td>
                        <td class="py-3 px-4">
                            <button onclick="openModal('applicantModal1')" class="text-primary hover:underline mr-2">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>