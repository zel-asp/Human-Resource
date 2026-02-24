(function () {
    const employeeBtn = document.getElementById('show-employee');
    const hrBtn = document.getElementById('show-hr');
    const employeeForm = document.getElementById('employee-form');
    const hrForm = document.getElementById('hr-form');

    function setActiveButton(active) {
        if (active === 'employee') {
            employeeBtn.className = 'flex-1 py-2.5 text-sm font-medium rounded-md bg-white shadow-sm text-[#1e3a5f] border border-[#d0d9e6]';
            hrBtn.className = 'flex-1 py-2.5 text-sm font-medium text-primary hover:text-[#1e3a5f]';
        } else {
            hrBtn.className = 'flex-1 py-2.5 text-sm font-medium rounded-md bg-white shadow-sm text-[#1e3a5f] border border-[#d0d9e6]';
            employeeBtn.className = 'flex-1 py-2.5 text-sm font-medium text-primary hover:text-[#1e3a5f]';
        }
    }

    employeeBtn.addEventListener('click', function () {
        employeeForm.classList.remove('hidden');
        hrForm.classList.add('hidden');
        setActiveButton('employee');
    });

    hrBtn.addEventListener('click', function () {
        hrForm.classList.remove('hidden');
        employeeForm.classList.add('hidden');
        setActiveButton('hr');
    });
})();