// Analytics Dashboard Charts
let analyticsCharts = {};

document.addEventListener('DOMContentLoaded', function () {
    initAnalyticsCharts();

    // Date range change handler
    document.getElementById('analyticsRangeSelect')?.addEventListener('change', function () {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', 'analytics');
        url.searchParams.set('analytics_range', this.value);
        window.location.href = url.toString();
    });
});

function initAnalyticsCharts() {
    const data = window.analyticsData;
    if (!data) return;

    // Department Chart (Donut)
    const deptCtx = document.getElementById('analyticsDeptChart')?.getContext('2d');
    if (deptCtx) {
        analyticsCharts.department = new Chart(deptCtx, {
            type: 'pie',
            data: {
                labels: data.deptLabels,
                datasets: [{
                    data: data.deptData,
                    backgroundColor: data.deptColors,
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                cutout: '65%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                const percentage = Math.round(context.raw / data.totalHeadcount * 100);
                                return `${context.label}: ${context.raw} employees (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }

    // Hires vs Terminations Line Chart
    const hiresCtx = document.getElementById('analyticsHiresChart')?.getContext('2d');
    if (hiresCtx) {
        analyticsCharts.hires = new Chart(hiresCtx, {
            type: 'line',
            data: {
                labels: data.months,
                datasets: [
                    {
                        label: 'Hires',
                        data: data.hiresData,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#16a34a',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    },
                    {
                        label: 'Terminations',
                        data: data.terminationsData,
                        borderColor: '#dc2626',
                        backgroundColor: 'rgba(220, 38, 38, 0.1)',
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#dc2626',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f3f4f6' },
                        ticks: { stepSize: 5 }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Gender Distribution Pie Chart
    const genderCtx = document.getElementById('analyticsGenderChart')?.getContext('2d');
    if (genderCtx) {
        analyticsCharts.gender = new Chart(genderCtx, {
            type: 'bar',
            data: {
                labels: ['Female', 'Male'],
                datasets: [{
                    data: [data.femalePct, data.malePct],
                    backgroundColor: ['#ec4899', '#3b82f6'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '60%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });
    }

    // Age Distribution Bar Chart
    const ageCtx = document.getElementById('analyticsAgeChart')?.getContext('2d');
    if (ageCtx) {
        analyticsCharts.age = new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: ['18-30', '31-45', '46+'],
                datasets: [{
                    data: data.ageData,
                    backgroundColor: ['#3b82f6', '#16a34a', '#d97706'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 50,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            callback: function (value) { return value + '%'; }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Tenure Distribution Bar Chart
    const tenureCtx = document.getElementById('analyticsTenureChart')?.getContext('2d');
    if (tenureCtx) {
        analyticsCharts.tenure = new Chart(tenureCtx, {
            type: 'bar',
            data: {
                labels: ['<1 yr', '1-3 yrs', '3+ yrs'],
                datasets: [{
                    data: data.tenureData,
                    backgroundColor: ['#9333ea', '#7c3aed', '#4f46e5'],
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 50,
                        grid: { color: '#f3f4f6' },
                        ticks: {
                            callback: function (value) { return value + '%'; }
                        }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }
}

// Export function
function exportAnalyticsData() {
    const data = window.analyticsData;
    const range = document.getElementById('analyticsRangeSelect').value;

    const csvContent = `Metric,Value,Change
Turnover Rate,${data.turnoverRate}%,${data.turnoverChange}%
Retention Rate,${data.retentionRate}%,+${data.retentionChange}%
Days to Hire,${data.daysToHire},${data.daysChange} days
Engagement Score,${data.engagementScore}/${data.engagementTotal},Top quartile
${data.deptLabels.map((label, i) => `${label} Headcount,${data.deptData[i]},${Math.round(data.deptData[i] / data.totalHeadcount * 100)}%`).join('\n')}
Total Hires (6 months),${data.totalHires},-
Total Terminations (6 months),${data.totalTerminations},-
Net Growth,+${data.netGrowth},-
Gender Distribution - Female,${data.femalePct}%,${data.femaleCount} employees
Gender Distribution - Male,${data.malePct}%,${data.maleCount} employees
Age 18-30,${data.ageData[0]}%,-
Age 31-45,${data.ageData[1]}%,-
Age 46+,${data.ageData[2]}%,-
Tenure <1 year,${data.tenureData[0]}%,-
Tenure 1-3 years,${data.tenureData[1]}%,-
Tenure 3+ years,${data.tenureData[2]}%,-`;

    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `hr-analytics-${range}-days.csv`;
    a.click();
}