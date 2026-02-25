<div class="tab-content" id="recruitment-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Recruitment Management</h2>
            <p class="text-gray-600 mt-1">Create job postings and attract candidates for hotel & restaurant positions
            </p>
        </div>
        <button class="btn-primary" onclick="openModal('newJobModal')">
            <i class="fas fa-plus mr-2"></i>New Job Posting
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php if (!empty($jobPostings)): ?>
            <?php foreach ($jobPostings as $job): ?>
                <div class="card p-6">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-semibold text-lg"><?= htmlspecialchars($job['position']) ?></h3>
                        <span class="status-badge bg-green-100 text-green-800">Active</span>
                    </div>

                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <p><i class="fas fa-utensils mr-2 w-5"></i><?= htmlspecialchars($job['department']) ?></p>
                        <p><i class="fas fa-map-marker-alt mr-2 w-5"></i><?= htmlspecialchars($job['location']) ?></p>
                        <p><i class="fas fa-clock mr-2 w-5"></i><?= htmlspecialchars($job['shift']) ?></p>
                        <p><i class="fas fa-dollar-sign mr-2 w-5"></i><?= htmlspecialchars($job['salary']) ?></p>
                    </div>

                    <div class="border-t border-gray-100 pt-4 flex gap-2">
                        <button class="text-gray-600 hover:underline text-sm" onclick="openEditJobModal(
                        <?= $job['id'] ?>,
                        '<?= htmlspecialchars($job['position'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($job['location'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($job['shift'], ENT_QUOTES) ?>',
                        '<?= htmlspecialchars($job['salary'], ENT_QUOTES) ?>'
                    )">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </button>

                        <form method="POST" action="/delete-job"
                            onsubmit="return confirm('Are you sure you want to delete this job posting?');">
                            <input type="hidden" value="DELETE" name="__method">
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                            <input type="hidden" name="job_id" value="<?= $job['id'] ?>">
                            <button type="submit" class="text-red-600 hover:underline text-sm" name="delete-jobBtn">
                                <i class="fas fa-trash mr-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600">No job postings found.</p>
        <?php endif; ?>
    </div>

    <!-- Recent Applicants Preview (limited to 5) -->
    <div class="card p-6 mt-6">
        <h3 class="text-lg font-semibold mb-4">Recent Applicants</h3>
        <div class="space-y-3">
            <?php if (!empty($recentApplicants)): ?>
                <?php foreach ($recentApplicants as $applicant): ?>
                    <!-- Applicant preview -->
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center text-white text-sm">
                                <?= strtoupper(substr($applicant['full_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="font-medium"><?= htmlspecialchars($applicant['full_name']) ?></p>
                                <p class="text-sm text-gray-600">
                                    Applied for: <?= htmlspecialchars($applicant['position']) ?> •
                                    <?= htmlspecialchars(date('M d, Y', strtotime($applicant['created_at']))) ?>
                                </p>
                            </div>
                        </div>
                        <button onclick="openModal('recruitment-applicantModal<?= $applicant['id'] ?>')"
                            class="text-primary hover:underline text-sm">
                            <i class="fas fa-eye mr-1"></i>View
                        </button>
                    </div>

                    <!-- Modal for this applicant -->
                    <div id="recruitment-applicantModal<?= $applicant['id'] ?>" class="modal">
                        <div
                            class="modal-content bg-white rounded-(--radius-card) shadow-(--shadow-card) w-full max-w-lg mx-4 p-6 relative">
                            <!-- Close button -->
                            <button onclick="closeModal('recruitment-applicantModal<?= $applicant['id'] ?>')"
                                class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl font-bold">
                                &times;
                            </button>

                            <!-- Header -->
                            <h3 class="text-xl font-semibold mb-4"><?= htmlspecialchars($applicant['full_name']) ?> - Applicant
                                Details</h3>

                            <!-- Body -->
                            <div class="space-y-4 text-gray-700 text-sm">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Position</p>
                                        <p class="font-medium"><?= htmlspecialchars($applicant['position']) ?></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Applied Date</p>
                                        <p class="font-medium">
                                            <?= htmlspecialchars(date('M d, Y', strtotime($applicant['created_at']))) ?>
                                        </p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-600">Email</p>
                                        <p class="font-medium"><?= htmlspecialchars($applicant['email']) ?></p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-600">Phone</p>
                                        <p class="font-medium"><?= htmlspecialchars($applicant['phone']) ?></p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-600">Experience</p>
                                        <p class="font-medium"><?= htmlspecialchars($applicant['experience']) ?></p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-600">Education</p>
                                        <p class="font-medium"><?= htmlspecialchars($applicant['education']) ?></p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-600">Skills</p>
                                        <p class="font-medium"><?= htmlspecialchars($applicant['skills']) ?></p>
                                    </div>
                                    <?php if (!empty($applicant['resume_path'])): ?>
                                        <div class="col-span-2 border-t pt-4">
                                            <h4 class="font-medium mb-2">Resume</h4>
                                            <a href="<?= htmlspecialchars($applicant['resume_path']) ?>" target="_blank"
                                                class="w-full text-left border rounded-lg p-4 bg-gray-50 hover:bg-gray-100 transition duration-200 flex items-center gap-3">
                                                <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                                                <div>
                                                    <p class="font-medium"><?= basename($applicant['resume_path']) ?></p>
                                                    <p class="text-xs text-gray-500">
                                                        Uploaded <?= date('M d, Y', strtotime($applicant['created_at'])) ?>
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
                                    <button class="btn-success" onclick="scheduleInterview(<?= $applicant['id'] ?>)">Schedule
                                        Interview</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-600">No recent applicants.</p>
            <?php endif; ?>
        </div>
    </div>
</div>