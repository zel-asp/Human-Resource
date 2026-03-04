<div class="tab-content" id="shift-content">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Shift Management</h2>
            <p class="text-gray-500 text-sm mt-1">Create and manage employee schedules</p>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="openModal('bulkScheduleModal')"
                class="px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-upload"></i>
                Bulk Upload
            </button>
            <button onclick="openModal('createScheduleModal')"
                class="px-4 py-2 text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 rounded-lg transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Create Schedule
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Total Employees</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">48</p>
                    <p class="text-xs text-gray-400 mt-1">32 scheduled this week</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-gray-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Open Shifts</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">12</p>
                    <p class="text-xs text-gray-400 mt-1">Needs coverage</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-plus text-gray-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Swap Requests</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">5</p>
                    <p class="text-xs text-gray-400 mt-1">3 pending approval</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-arrows-rotate text-gray-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">Time Off</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">8</p>
                    <p class="text-xs text-gray-400 mt-1">Next 7 days</p>
                </div>
                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-umbrella-beach text-gray-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <select class="text-sm bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option>All Departments</option>
                    <option>Management</option>
                    <option>Restaurant</option>
                    <option>Hotel</option>
                </select>
                <select class="text-sm bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gray-200">
                    <option>All Shifts</option>
                    <option>Morning (7am-3pm)</option>
                    <option>Afternoon (3pm-11pm)</option>
                    <option>Graveyard (11pm-7am)</option>
                </select>
            </div>
            <div class="flex items-center gap-3">
                <span class="flex items-center gap-1 text-xs">
                    <span class="w-3 h-3 bg-blue-100 rounded-full"></span>
                    <span class="text-gray-500">Morning</span>
                </span>
                <span class="flex items-center gap-1 text-xs">
                    <span class="w-3 h-3 bg-amber-100 rounded-full"></span>
                    <span class="text-gray-500">Afternoon</span>
                </span>
                <span class="flex items-center gap-1 text-xs">
                    <span class="w-3 h-3 bg-purple-100 rounded-full"></span>
                    <span class="text-gray-500">Graveyard</span>
                </span>
            </div>
        </div>
    </div>

    <!-- Week Navigation -->
    <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm mb-4">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-4">
                <h3 class="font-semibold text-gray-800">Weekly Schedule</h3>
                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-medium border border-gray-200">
                    March 10 - March 16, 2025
                </span>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-50 border-r border-gray-200">
                        <i class="fas fa-chevron-left text-xs text-gray-600"></i>
                    </button>
                    <button class="px-4 h-8 bg-gray-800 text-white text-xs font-medium">
                        Today
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center bg-white hover:bg-gray-50 border-l border-gray-200">
                        <i class="fas fa-chevron-right text-xs text-gray-600"></i>
                    </button>
                </div>
                <div class="flex items-center gap-1 border-l border-gray-200 pl-3">
                    <button class="w-7 h-7 flex items-center justify-center bg-gray-800 text-white rounded-lg" title="Week view">
                        <i class="fas fa-calendar-week text-xs"></i>
                    </button>
                    <button class="w-7 h-7 flex items-center justify-center bg-white border border-gray-200 text-gray-400 rounded-lg hover:bg-gray-50" title="Month view">
                        <i class="fas fa-calendar-days text-xs"></i>
                    </button>
                    <button class="w-7 h-7 flex items-center justify-center bg-white border border-gray-200 text-gray-400 rounded-lg hover:bg-gray-50" title="List view">
                        <i class="fas fa-list text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-7 gap-3 mb-8">
        <?php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $dates = ['10', '11', '12', '13', '14', '15', '16'];
        $month = 'Mar';

        foreach ($days as $index => $day):
            $isToday = ($index == 2);
            ?>
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="px-4 py-3 <?= $isToday ? 'bg-gray-800 text-white' : 'bg-gray-50' ?> border-b border-gray-100">
                    <p class="text-xs font-medium <?= $isToday ? 'text-gray-300' : 'text-gray-500' ?>"><?= $day ?></p>
                    <p class="text-lg font-semibold leading-tight"><?= $month ?> <?= $dates[$index] ?></p>
                </div>
                
                <div class="p-3 min-h-[280px] space-y-2">
                    <!-- Morning Shift -->
                    <div onclick="openModal('viewShiftModal')"
                        class="p-2 bg-blue-50 border border-blue-200 rounded-lg text-xs hover:shadow-sm transition cursor-pointer group relative">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-blue-700">Morning</span>
                            <span class="text-[10px] text-gray-500">7am-3pm</span>
                        </div>
                        <p class="text-gray-600 text-xs mt-1">Grace Lee, John Smith +1</p>
                        <button onclick="event.stopPropagation(); openModal('editShiftModal')"
                            class="absolute top-1 right-1 w-6 h-6 bg-white rounded-lg shadow-sm text-gray-400 hover:text-gray-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <i class="fas fa-pen text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Afternoon Shift -->
                    <div onclick="openModal('viewShiftModal')"
                        class="p-2 bg-amber-50 border border-amber-200 rounded-lg text-xs hover:shadow-sm transition cursor-pointer group relative">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-amber-700">Afternoon</span>
                            <span class="text-[10px] text-gray-500">3pm-11pm</span>
                        </div>
                        <p class="text-gray-600 text-xs mt-1">James Davis, Sarah Chen</p>
                        <button onclick="event.stopPropagation(); openModal('editShiftModal')"
                            class="absolute top-1 right-1 w-6 h-6 bg-white rounded-lg shadow-sm text-gray-400 hover:text-gray-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <i class="fas fa-pen text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Graveyard Shift -->
                    <div onclick="openModal('viewShiftModal')"
                        class="p-2 bg-purple-50 border border-purple-200 rounded-lg text-xs hover:shadow-sm transition cursor-pointer group relative">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-purple-700">Graveyard</span>
                            <span class="text-[10px] text-gray-500">11pm-7am</span>
                        </div>
                        <p class="text-gray-600 text-xs mt-1">Mike Rivera</p>
                        <button onclick="event.stopPropagation(); openModal('editShiftModal')"
                            class="absolute top-1 right-1 w-6 h-6 bg-white rounded-lg shadow-sm text-gray-400 hover:text-gray-600 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                            <i class="fas fa-pen text-[10px]"></i>
                        </button>
                    </div>

                    <!-- Add Shift Button -->
                    <button onclick="openModal('createScheduleModal')"
                        class="w-full py-2 border border-dashed border-gray-200 rounded-lg text-gray-400 hover:text-gray-600 hover:border-gray-300 text-xs flex items-center justify-center gap-1 transition mt-2">
                        <i class="fas fa-plus"></i> Add Shift
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Shift Swap Requests -->
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Shift Swap Requests</h3>
            <span class="bg-red-50 text-red-600 text-xs px-2 py-1 rounded-full border border-red-200">3 pending</span>
        </div>

        <div class="space-y-3">
            <!-- Request 1 -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-arrows-rotate text-gray-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">Maria Garcia → James Davis</p>
                        <p class="text-xs text-gray-500">Wed, Mar 20 • Morning to Afternoon</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="w-7 h-7 bg-green-50 border border-green-200 text-green-600 rounded-lg hover:bg-green-100">
                        <i class="fas fa-check text-xs"></i>
                    </button>
                    <button class="w-7 h-7 bg-red-50 border border-red-200 text-red-600 rounded-lg hover:bg-red-100">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                    <span class="text-xs bg-yellow-50 text-yellow-600 px-2 py-1 rounded-full border border-yellow-200">Pending</span>
                </div>
            </div>

            <!-- Request 2 -->
            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-gray-600 text-xs"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">John Smith → Lisa Wong</p>
                        <p class="text-xs text-gray-500">Thu, Mar 21 • Afternoon to Morning</p>
                    </div>
                </div>
                <span class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded-full border border-green-200">Approved</span>
            </div>
        </div>

        <button onclick="openModal('allSwapRequestsModal')"
            class="text-sm text-gray-500 hover:text-gray-700 mt-4 inline-flex items-center gap-1">
            View all requests <i class="fas fa-arrow-right text-xs"></i>
        </button>
    </div>
</div>