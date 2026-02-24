(function () {
    const body = document.body;

    // Modal functions
    function closeAllModals() {
        document.querySelectorAll('[id$="Modal"]').forEach(modal => modal.classList.add('hidden'));
        body.classList.remove('modal-open');
    }

    function openModal(id) {
        closeAllModals();
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('hidden');
            body.classList.add('modal-open');
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) modal.classList.add('hidden');
        if (!document.querySelector('[id$="Modal"]:not(.hidden)')) body.classList.remove('modal-open');
    }

    // Modal triggers
    document.getElementById('openProfileModalBtn')?.addEventListener('click', () => openModal('profileModal'));
    document.getElementById('openLeaveModalBtn')?.addEventListener('click', () => openModal('leaveModal'));
    document.getElementById('openAttendanceModalBtn')?.addEventListener('click', () => openModal('attendanceModal'));
    document.getElementById('openPayslipModalBtn')?.addEventListener('click', () => openModal('payslipModal'));
    document.getElementById('openSettingsModalBtn')?.addEventListener('click', () => openModal('settingsModal'));

    // View all triggers
    document.getElementById('viewAllRequestsBtn')?.addEventListener('click', (e) => {
        e.preventDefault();
        openModal('viewAllRequestsModal');
    });

    document.getElementById('viewAllTasksBtn')?.addEventListener('click', (e) => {
        e.preventDefault();
        openModal('viewAllTasksModal');
    });

    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            closeModal(this.getAttribute('data-modal'));
        });
    });

    document.querySelectorAll('[id$="Modal"]').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) closeModal(this.id);
        });
    });
    const tabRequestsBtn = document.getElementById('tabRequestsBtn');
    const tabTasksBtn = document.getElementById('tabTasksBtn');
    const requestsPanel = document.getElementById('requestsPanel');
    const tasksPanel = document.getElementById('tasksPanel');
    const viewAllRequestsBtn = document.getElementById('viewAllRequestsBtn');
    const viewAllTasksBtn = document.getElementById('viewAllTasksBtn');

    function setActiveTab(active) {
        if (active === 'requests') {
            tabRequestsBtn.classList.remove('tab-inactive');
            tabRequestsBtn.classList.add('tab-active');
            tabTasksBtn.classList.remove('tab-active');
            tabTasksBtn.classList.add('tab-inactive');
            requestsPanel.classList.remove('hidden');
            tasksPanel.classList.add('hidden');
        } else {
            tabTasksBtn.classList.remove('tab-inactive');
            tabTasksBtn.classList.add('tab-active');
            tabRequestsBtn.classList.remove('tab-active');
            tabRequestsBtn.classList.add('tab-inactive');
            tasksPanel.classList.remove('hidden');
            requestsPanel.classList.add('hidden');
        }
    }

    tabRequestsBtn.addEventListener('click', (e) => {
        e.preventDefault();
        setActiveTab('requests');
    });

    tabTasksBtn.addEventListener('click', (e) => {
        e.preventDefault();
        setActiveTab('tasks');
    });
    setActiveTab('requests');
})();