<!-- Profile Modal -->
<div id="profileModal" class="fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden modal-enter z-50">
    <div class="bg-white rounded-md max-w-lg w-full mx-4 p-6 shadow-xl">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fa-regular fa-id-card mr-2 text-primary"></i>employee profile
            </h3>
            <button class="close-modal text-gray-400 hover:text-gray-600" data-modal="profileModal">
                <i class="fa-regular fa-circle-xmark fa-xl"></i>
            </button>
        </div>
        <div class="flex items-center gap-4 border-b pb-4">
            <img class="h-16 w-16 rounded-md object-cover ring-2 ring-[#e2eaf2]"
                src="https://ui-avatars.com/api/?name=Alex+Chen&background=2c5f8a&color=fff&size=64" alt="profile">
            <div>
                <p class="text-xl font-semibold">Alex Chen</p>
                <p class="text-sm text-gray-500">
                    <i class="fa-regular fa-envelope mr-1"></i>a.chen@company.com ·
                    <i class="fa-regular fa-mobile ml-1 mr-1"></i>+1 (555) 238-1192
                </p>
                <p class="text-xs text-primary mt-1">
                    <i class="fa-regular fa-building mr-1"></i>Product Engineering · ID #EMP-8742
                </p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4 text-sm">
            <div>
                <span class="text-gray-500">Department</span>
                <p class="font-medium">Product Engineering</p>
            </div>
            <div>
                <span class="text-gray-500">Manager</span>
                <p class="font-medium">Sarah V.</p>
            </div>
            <div>
                <span class="text-gray-500">Start date</span>
                <p class="font-medium">12 Apr 2021</p>
            </div>
            <div>
                <span class="text-gray-500">Employment</span>
                <p class="font-medium">Full-time</p>
            </div>
            <div>
                <span class="text-gray-500">Location</span>
                <p class="font-medium">Hybrid (NYC)</p>
            </div>
            <div>
                <span class="text-gray-500">Birthday</span>
                <p class="font-medium">Oct 8</p>
            </div>
        </div>
        <hr class="my-4">
        <div class="flex justify-between items-center">
            <span class="text-xs text-gray-400">
                <i class="fa-regular fa-clock mr-1"></i>updated 08:23
            </span>
            <button
                class="close-modal bg-primary hover:bg-primary-hover text-white text-sm font-medium py-2 px-5 rounded-md transition"
                data-modal="profileModal">
                Close
            </button>
        </div>
    </div>
</div>