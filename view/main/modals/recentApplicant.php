<div id="recruitment-applicantModal<?= $applicant['id'] ?>" class="modal">
    <div class="modal-content bg-white rounded---radius-card) shadow-(--shadow-card) w-full max-w-lg mx-4 p-6 relative">
        <!-- Close button -->
        <button onclick="closeModal('recruitment-applicantModal<?= $applicant['id'] ?>')"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">
            &times;
        </button>

        <!-- Header -->
        <h3 class="text-xl font-semibold mb-4">
            <?= htmlspecialchars($applicant['full_name']) ?> - Applicant Details
        </h3>

        <!-- Body -->
        <div class="space-y-4 text-gray-700 text-sm">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Position</p>
                    <p class="font-medium">
                        <?= htmlspecialchars($applicant['position']) ?>
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Applied Date</p>
                    <p class="font-medium">
                        <?= htmlspecialchars(date('M d, Y', strtotime($applicant['created_at']))) ?>
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">
                        <?= htmlspecialchars($applicant['email']) ?>
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Phone</p>
                    <p class="font-medium">
                        <?= htmlspecialchars($applicant['phone']) ?>
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Experience</p>
                    <p class="font-medium">
                        <?= htmlspecialchars($applicant['experience']) ?>
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Education</p>
                    <p class="font-medium">
                        <?= htmlspecialchars($applicant['education']) ?>
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-sm text-gray-600">Skills</p>
                    <p class="font-medium">
                        <?= htmlspecialchars($applicant['skills']) ?>
                    </p>
                </div>
            </div>

            <?php if (!empty($applicant['resume_path'])): ?>
                <div class="border-t pt-4">
                    <h4 class="font-medium mb-2">Resume</h4>
                    <a href="<?= htmlspecialchars($applicant['resume_path']) ?>" target="_blank"
                        class="w-full text-left border rounded-lg p-4 bg-gray-50 hover:bg-gray-100 transition duration-200 flex items-center gap-3">
                        <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                        <div>
                            <p class="font-medium">
                                <?= basename($applicant['resume_path']) ?>
                            </p>
                            <p class="text-xs text-gray-500">Uploaded
                                <?= date('M d, Y', strtotime($applicant['created_at'])) ?>
                            </p>
                        </div>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="flex justify-end gap-2 mt-6">
            <button class="px-4 py-2 bg-gray-200 rounded-lg"
                onclick="closeModal('recruitment-applicantModal<?= $applicant['id'] ?>')">Close</button>
            <button class="btn-success" onclick="scheduleInterview(<?= $applicant['id'] ?>)">Schedule Interview</button>
        </div>
    </div>
</div>