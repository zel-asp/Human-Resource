(function () {
    const body = document.body;

    // ========================
    // GLOBAL FUNCTIONS (accessible to inline HTML)
    // ========================

    // Sidebar toggle function - MAKE THIS GLOBAL
    window.toggleSidebar = function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        if (sidebar && overlay) {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }
    };

    // ========================
    // MODAL FUNCTIONS
    // ========================
    function closeAllModals() {
        document.querySelectorAll('[id$="Modal"]').forEach(modal => modal.classList.add('hidden'));
        body.classList.remove('modal-open');
    }

    // Expose openModal globally
    window.openModal = function (modalId) {
        closeAllModals();
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            body.classList.add('modal-open');
            document.body.style.overflow = 'hidden';

            // Update URL
            const url = new URL(window.location);
            url.searchParams.set('modal', modalId);
            window.history.replaceState({}, '', url);
        }
    };

    // Expose closeModal globally
    window.closeModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');

            if (!document.querySelector('[id$="Modal"]:not(.hidden)')) {
                body.classList.remove('modal-open');
                document.body.style.overflow = '';

                // Remove modal from URL
                const url = new URL(window.location);
                url.searchParams.delete('modal');
                window.history.replaceState({}, '', url);
            }
        }
    };

    // Close modal when clicking outside
    window.closeModalOnOutsideClick = function (event, modalId) {
        if (event.target === event.currentTarget) {
            closeModal(modalId);
        }
    };

    // ========================
    // TAB FUNCTIONS
    // ========================
    window.switchTab = function (tabName) {
        const requestsPanel = document.getElementById('requestsPanel');
        const tasksPanel = document.getElementById('tasksPanel');
        const requestsBtn = document.getElementById('tabRequestsBtn');
        const tasksBtn = document.getElementById('tabTasksBtn');

        if (!requestsPanel || !tasksPanel || !requestsBtn || !tasksBtn) return;

        // Hide all panels
        requestsPanel.classList.add('hidden');
        tasksPanel.classList.add('hidden');

        // Reset button classes
        requestsBtn.classList.remove('border-primary', 'text-primary');
        requestsBtn.classList.add('text-gray-500');
        tasksBtn.classList.remove('border-primary', 'text-primary');
        tasksBtn.classList.add('text-gray-500');

        // Show selected panel
        if (tabName === 'tasks') {
            tasksPanel.classList.remove('hidden');
            tasksBtn.classList.add('border-primary', 'text-primary');
            tasksBtn.classList.remove('text-gray-500');
        } else {
            requestsPanel.classList.remove('hidden');
            requestsBtn.classList.add('border-primary', 'text-primary');
            requestsBtn.classList.remove('text-gray-500');
        }

        // Store the dashboard tab preference in localStorage
        localStorage.setItem('dashboardSubTab', tabName);

        // Update URL without reload
        const url = new URL(window.location);
        url.searchParams.set('subtab', tabName);
        window.history.replaceState({}, '', url);
    };

    // Initialize everything when DOM is loaded
    document.addEventListener('DOMContentLoaded', function () {
        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get('tab');
        const modal = urlParams.get('modal');
        const subtab = urlParams.get('subtab') || localStorage.getItem('dashboardSubTab') || 'requests';

        console.log('DOM Loaded - URL params:', { tab, modal, subtab });

        // Setup dashboard tabs if we're on the dashboard
        if (tab === 'dashboard' || !tab) {
            const requestsBtn = document.getElementById('tabRequestsBtn');
            const tasksBtn = document.getElementById('tabTasksBtn');

            if (requestsBtn) {
                requestsBtn.removeAttribute('onclick');
                requestsBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.switchTab('requests');
                });
            }

            if (tasksBtn) {
                tasksBtn.removeAttribute('onclick');
                tasksBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    window.switchTab('tasks');
                });
            }

            // Restore the last used dashboard tab
            window.switchTab(subtab);
        }

        // Open modal if specified in URL
        if (modal) {
            console.log('Attempting to open modal:', modal);
            setTimeout(() => {
                window.openModal(modal);
            }, 200);
        }

        // ========================
        // EVENT LISTENERS
        // ========================

        // Modal triggers
        document.getElementById('openProfileModalBtn')?.addEventListener('click', () => window.openModal('profileModal'));
        document.getElementById('openLeaveModalBtn')?.addEventListener('click', () => window.openModal('leaveModal'));
        document.getElementById('openAttendanceModalBtn')?.addEventListener('click', () => window.openModal('attendanceModal'));
        document.getElementById('openPayslipModalBtn')?.addEventListener('click', () => window.openModal('payslipModal'));
        document.getElementById('openSettingsModalBtn')?.addEventListener('click', () => window.openModal('settingsModal'));

        // Setup modal close buttons
        document.querySelectorAll('.close-modal, [data-close-modal]').forEach(button => {
            button.addEventListener('click', function () {
                const modal = this.closest('[id$="Modal"]');
                if (modal) {
                    window.closeModal(modal.id);
                }
            });
        });

        // Close sidebar when clicking on main content on mobile
        const mainContent = document.querySelector('main');
        if (mainContent) {
            mainContent.addEventListener('click', function () {
                if (window.innerWidth < 1024) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('overlay');
                    if (sidebar && sidebar.classList.contains('open')) {
                        sidebar.classList.remove('open');
                        overlay.classList.remove('open');
                    }
                }
            });
        }

        // Setup modal backdrop clicks
        document.querySelectorAll('.modal-backdrop, [data-modal-backdrop], [id$="Modal"]').forEach(backdrop => {
            backdrop.addEventListener('click', function (e) {
                if (e.target === this) {
                    window.closeModal(this.id);
                }
            });
        });
    });
})();