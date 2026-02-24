<div class="tab-content" id="analytics-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">HR Analytics Dashboard</h2>
            <p class="text-gray-600 mt-1">Key metrics and insights</p>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="metric-card">
            <div class="metric-value">12%</div>
            <div class="metric-label">Turnover Rate</div>
            <p class="text-xs text-green-600 mt-1">↓ 2% from last month</p>
        </div>
        <div class="metric-card">
            <div class="metric-value">94%</div>
            <div class="metric-label">Retention Rate</div>
            <p class="text-xs text-green-600 mt-1">↑ 1% from last month</p>
        </div>
        <div class="metric-card">
            <div class="metric-value">18</div>
            <div class="metric-label">Days to Hire</div>
            <p class="text-xs text-red-600 mt-1">↑ 3 days from last month</p>
        </div>
        <div class="metric-card">
            <div class="metric-value">4.2</div>
            <div class="metric-label">Engagement Score</div>
            <p class="text-xs text-green-600 mt-1">/5.0</p>
        </div>
    </div>

    <!-- Charts (Placeholders) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card p-6">
            <h3 class="text-lg font-semibold mb-4">Headcount by Department</h3>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Restaurant</span>
                        <span>45</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill green" style="width: 45%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Kitchen</span>
                        <span>38</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill blue" style="width: 38%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span>Housekeeping</span>
                        <span>42</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill yellow" style="width: 42%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="text-lg font-semibold mb-4">Monthly Hires vs Terminations</h3>
            <div class="grid grid-cols-3 gap-2 text-center">
                <div class="p-3 bg-green-50 rounded">
                    <p class="text-sm text-gray-600">Hires</p>
                    <p class="text-xl font-bold text-green-600">12</p>
                </div>
                <div class="p-3 bg-red-50 rounded">
                    <p class="text-sm text-gray-600">Terminations</p>
                    <p class="text-xl font-bold text-red-600">5</p>
                </div>
                <div class="p-3 bg-blue-50 rounded">
                    <p class="text-sm text-gray-600">Net</p>
                    <p class="text-xl font-bold text-blue-600">+7</p>
                </div>
            </div>
        </div>
    </div>
</div>