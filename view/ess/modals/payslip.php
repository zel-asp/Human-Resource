<!-- Payslip Modal -->
<div id="payslipModal" class="fixed inset-0 bg-gray-800/40 flex items-center justify-center hidden modal-enter z-50">
    <div class="bg-white rounded-md max-w-md w-full mx-4 p-6 shadow-xl">
        <div class="flex justify-between items-center mb-5">
            <h3 class="text-lg font-bold text-gray-800">
                <i class="fa-solid fa-file-lines mr-2 text-primary"></i>payslips
            </h3>
            <button class="close-modal text-gray-400 hover:text-gray-600" data-modal="payslipModal">
                <i class="fa-solid fa-circle-xmark fa-xl"></i>
            </button>
        </div>
        <p class="text-gray-500 text-sm mb-3">Download PDF</p>
        <ul class="divide-y">
            <li class="py-3 flex justify-between items-center">
                <span class="font-medium">September 2024</span>
                <span class="text-primary text-sm bg-[#ecf3fa] px-3 py-1 rounded-md cursor-pointer hover:bg-[#d9e2ed]">
                    <i class="fa-solid fa-circle-down mr-1"></i>Download
                </span>
            </li>
            <li class="py-3 flex justify-between items-center">
                <span class="font-medium">August 2024</span>
                <span class="text-primary text-sm bg-[#ecf3fa] px-3 py-1 rounded-md cursor-pointer hover:bg-[#d9e2ed]">
                    <i class="fa-solid fa-circle-down mr-1"></i>Download
                </span>
            </li>
            <li class="py-3 flex justify-between items-center">
                <span class="font-medium">July 2024</span>
                <span class="text-primary text-sm bg-[#ecf3fa] px-3 py-1 rounded-md cursor-pointer hover:bg-[#d9e2ed]">
                    <i class="fa-solid fa-circle-down mr-1"></i>Download
                </span>
            </li>
        </ul>
        <div class="mt-5 flex justify-end">
            <button
                class="close-modal bg-[#ecf3fa] text-primary px-4 py-2 rounded-md text-sm font-medium hover:bg-[#d9e2ed]"
                data-modal="payslipModal">
                Close
            </button>
        </div>
    </div>
</div>