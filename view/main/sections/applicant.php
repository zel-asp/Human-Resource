<div class="tab-content" id="applicant-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Applicant Management</h2>
            <p class="text-gray-600 mt-1">Track and manage job applicants through the hiring pipeline
            </p>
        </div>
    </div>

    <div class="card p-6">
        <!-- Filter Tabs - MODIFIED: Made scrollable on mobile -->
        <div class="filter-chips">
            <div class="filter-chip active" data-filter="all">All</div>
            <div class="filter-chip" data-filter="new">New</div>
            <div class="filter-chip" data-filter="review">Review</div>
            <div class="filter-chip" data-filter="interview">Interview</div>
            <div class="filter-chip" data-filter="rejected">Rejected</div>
            <div class="filter-chip" data-filter="hired">Hired</div>
        </div>


        <!-- Applicants Table -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Name</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Position</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Applied Date</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Resume</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($applicants)): ?>
                        <?php foreach ($applicants as $applicant): ?>
                            <?php
                            $id = (int) $applicant['id'];
                            $fullName = htmlspecialchars($applicant['full_name']);
                            $position = htmlspecialchars($applicant['position']);
                            $email = htmlspecialchars($applicant['email']);
                            $phone = htmlspecialchars($applicant['phone']);
                            $experience = htmlspecialchars($applicant['experience']);
                            $education = htmlspecialchars($applicant['education']);
                            $skills = htmlspecialchars($applicant['skills']);
                            $resume = htmlspecialchars($applicant['resume_path']);
                            $coverNote = htmlspecialchars($applicant['cover_note']);
                            $created = date('Y-m-d', strtotime($applicant['created_at']));
                            $status = strtolower($applicant['status'] ?? 'Probationary');
                            ?>
                            <tr class="border-b border-gray-100 hover:bg-gray-50 applicant-row" data-status="<?= $status ?>"
                                data-id="<?= $id ?>">
                                <td class="py-3 px-4 font-medium"><?= $fullName ?></td>
                                <td class="py-3 px-4">
                                    <span class="location-badge location-restaurant">
                                        <i class="fas fa-briefcase"></i>
                                        <?= $position ?>
                                    </span>
                                </td>
                                <td class="py-3 px-4"><?= $created ?></td>
                                <td class="py-3 px-4">
                                    <?php if (!empty($resume)): ?>
                                        <a href="<?= $resume ?>" target="_blank" class="text-primary hover:underline">
                                            <i class="fas fa-file-pdf mr-1"></i>View
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-400">No Resume</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4">
                                    <select name="status" class="status-select" data-id="<?= $id ?>">
                                        <?php
                                        $statuses = ['New', 'Review', 'Interview', 'Rejected', 'Hired'];
                                        foreach ($statuses as $s): ?>
                                            <option value="<?= $s ?>" <?= strtolower($s) === strtolower($status) ? 'selected' : '' ?>>
                                                <?= $s ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td class="py-3 px-4 flex justify-center items-center gap-2">
                                    <!-- View Button -->
                                    <button type="button" onclick="openModal('applicantModal<?= $id ?>')"
                                        class="flex items-center justify-center gap-1 px-3 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 hover:text-blue-700 rounded-md text-sm font-medium transition h-10">
                                        <i class="fas fa-eye"></i>
                                        <span>View</span>
                                    </button>

                                    <!-- Edit Form -->
                                    <button type="button"
                                        class="flex items-center justify-center gap-1 px-3 py-2 bg-yellow-50 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-800 rounded-md text-sm font-medium transition h-10 update-status-btn"
                                        data-id="<?= $id ?>" data-csrf="<?= $_SESSION['csrf_token'] ?>">
                                        <i class="fas fa-sync-alt"></i>
                                        <span>Update</span>
                                    </button>

                                    <!-- Delete Form -->
                                    <form action="/deleteApplicant" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this applicant?');"
                                        class="inline">
                                        <input type="hidden" name="id" value="<?= $id ?>">
                                        <input type="hidden" value="DELETE" name="__method">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                                        <button type="submit"
                                            class="flex items-center justify-center gap-1 px-3 py-2 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-800 rounded-md text-sm font-medium transition h-10">
                                            <i class="fas fa-trash-alt"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Applicant Modal -->
                            <div id="applicantModal<?= $id ?>" class="modal">
                                <div class="modal-content">
                                    <div class="flex justify-between items-center mb-4">
                                        <h3 class="text-xl font-semibold"><?= $fullName ?> - Applicant Details</h3>
                                        <button onclick="closeModal('applicantModal<?= $id ?>')"
                                            class="text-gray-500 hover:text-gray-700">✕</button>
                                    </div>
                                    <div class="space-y-2 text-sm text-gray-700">
                                        <p><strong>Email:</strong> <?= $email ?></p>
                                        <p><strong>Phone:</strong> <?= $phone ?></p>
                                        <p><strong>Position Applied:</strong> <?= $position ?></p>
                                        <p><strong>Experience:</strong> <?= $experience ?></p>
                                        <p><strong>Education:</strong> <?= $education ?></p>
                                        <p><strong>Skills:</strong> <?= $skills ?></p>
                                        <p><strong>Cover Note:</strong><br><?= nl2br($coverNote) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">No applicants found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>