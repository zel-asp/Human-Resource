<div id="trainingModal" class="modal">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Schedule Training Program</h3>
            <button onclick="closeModal('trainingModal')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form class="space-y-4">
            <!-- Review Learning Result (from competency gap) -->
            <div class="bg-yellow-50 p-4 rounded-lg mb-2">
                <label class="block text-sm font-medium mb-2">Based on Competency Gap</label>
                <div class="text-sm">
                    <p><span class="font-medium">Employee:</span> Grace Lee - Customer Service (Level 2)</p>
                    <p><span class="font-medium">Required Level:</span> 3 - Intermediate</p>
                    <p><span class="font-medium">Recommended Intervention:</span> Customer Service Excellence Training
                    </p>
                </div>
            </div>

            <!-- Training Type -->
            <div>
                <label class="block text-sm font-medium mb-1">Training Type</label>
                <select class="profile-input w-full p-2 border rounded" id="trainingType"
                    onchange="toggleProviderFields()">
                    <option value="">Select Training Type</option>
                    <option value="internal">Internal Training</option>
                    <option value="external">External Training</option>
                    <option value="certification">Certification Program</option>
                </select>
            </div>

            <!-- Training Provider (dynamic based on type) -->
            <div id="internalProvider" class="hidden">
                <label class="block text-sm font-medium mb-1">Internal Trainer</label>
                <select class="profile-input w-full p-2 border rounded">
                    <option>Select Internal Trainer</option>
                    <option>Sarah Johnson - Senior Trainer</option>
                    <option>Mike Chen - Technical Lead</option>
                    <option>Lisa Wong - Compliance Officer</option>
                    <option>David Kim - Department Head</option>
                </select>
            </div>

            <div id="externalProvider" class="hidden">
                <label class="block text-sm font-medium mb-1">External Training Provider</label>
                <select class="profile-input w-full p-2 border rounded">
                    <option>Select Provider</option>
                    <option>SafeFood Certification Inc.</option>
                    <option>Hospitality Training Institute</option>
                    <option>Leadership Academy International</option>
                    <option>TechSkills Learning Center</option>
                </select>
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">Or Add New Provider</label>
                    <input type="text" class="profile-input w-full p-2 border rounded" placeholder="Provider name">
                </div>
            </div>

            <div id="certificationProvider" class="hidden">
                <label class="block text-sm font-medium mb-1">Certifying Body</label>
                <select class="profile-input w-full p-2 border rounded">
                    <option>Select Certifying Body</option>
                    <option>ServSafe Certification</option>
                    <option>American Hotel & Lodging Association</option>
                    <option>Project Management Institute</option>
                    <option>National Restaurant Association</option>
                </select>
                <div class="mt-2">
                    <label class="block text-sm font-medium mb-1">Certification Code</label>
                    <input type="text" class="profile-input w-full p-2 border rounded" placeholder="e.g., SERV-101">
                </div>
            </div>

            <!-- Training Details -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium mb-1">Training Title</label>
                    <input type="text" class="profile-input w-full p-2 border rounded"
                        value="Customer Service Excellence" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Training Code</label>
                    <input type="text" class="profile-input w-full p-2 border rounded" placeholder="Auto-generated"
                        readonly>
                </div>
            </div>

            <!-- Schedule Training -->
            <div class="border-t pt-4">
                <h4 class="font-medium mb-3">Schedule Training</h4>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Date</label>
                        <input type="date" class="profile-input w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">End Date</label>
                        <input type="date" class="profile-input w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Start Time</label>
                        <input type="time" class="profile-input w-full p-2 border rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">End Time</label>
                        <input type="time" class="profile-input w-full p-2 border rounded">
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium mb-1">Location/Venue</label>
                    <input type="text" class="profile-input w-full p-2 border rounded"
                        placeholder="e.g., Training Room A / Zoom link">
                </div>
            </div>

            <!-- Employee Selection -->
            <div>
                <label class="block text-sm font-medium mb-1">Select Employees</label>
                <select class="profile-input w-full p-2 border rounded" multiple size="3">
                    <option selected>Grace Lee - Server (Customer Service Gap)</option>
                    <option>John Smith - Cook (Food Safety Gap)</option>
                    <option>Maria Garcia - Manager (Leadership Gap)</option>
                    <option>James Wilson - Server (Customer Service Gap)</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <!-- Notify Employee -->
            <div class="flex items-center gap-3 border-t pt-4">
                <input type="checkbox" id="notifyEmployee" class="w-4 h-4" checked>
                <label for="notifyEmployee" class="text-sm font-medium">Send notification to selected employees</label>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" class="px-4 py-2 bg-gray-200 rounded-lg"
                    onclick="closeModal('trainingModal')">Cancel</button>
                <button type="button" class="btn-primary px-4 py-2" onclick="scheduleAndNotify()">
                    <i class="fas fa-calendar-check mr-2"></i>Schedule & Notify
                </button>
            </div>
        </form>
    </div>
</div>