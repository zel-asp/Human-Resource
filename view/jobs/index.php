<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HotelJobs · Complete Application</title>
        <!-- Tailwind + Font Awesome -->
        <link rel="stylesheet" href="/assets/css/output.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body class="bg-gray-100 p-4 md:p-8 antialiased">
        <!-- Main Container - Separated from background -->
        <div class="max-w-6xl mx-auto bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <!-- Page Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Join our team</h1>
                <p class="text-gray-500">Browse open positions and submit your application</p>
            </div>

            <!-- Job Listings Section -->
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-5 pb-2 border-b border-gray-100">
                    <i class="fas fa-briefcase text-gray-400"></i>
                    <h2 class="text-lg font-semibold text-gray-800">Open Positions</h2>
                    <?php if (!empty($jobPostings)): ?>
                        <span class="ml-auto text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                            <?= count($jobPostings) ?> available
                        </span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($jobPostings)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <?php foreach ($jobPostings as $job): ?>
                            <div
                                class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                <!-- Card Header with subtle gradient -->
                                <div class="px-5 py-4 border-b border-gray-100 bg-linear-to-r from-gray-50 to-white">
                                    <div class="flex items-start justify-between">
                                        <h3 class="font-semibold text-gray-800"><?= htmlspecialchars($job['position']) ?></h3>
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                            Hiring
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1"><?= htmlspecialchars($job['department']) ?></p>
                                </div>

                                <!-- Card Body -->
                                <div class="p-5">
                                    <!-- Quick Info Pills -->
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-gray-50 text-gray-600 border border-gray-100">
                                            <i class="fas fa-clock mr-1 text-gray-400"></i>
                                            <?= htmlspecialchars($job['shift']) ?>
                                        </span>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-md text-xs bg-gray-50 text-gray-600 border border-gray-100">
                                            <i class="fas fa-map-pin mr-1 text-gray-400"></i>
                                            <?= htmlspecialchars($job['location']) ?>
                                        </span>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                                        <?= !empty($job['description']) ? htmlspecialchars($job['description']) : 'Join our team and grow your career in hospitality.' ?>
                                    </p>

                                    <!-- Salary and Apply -->
                                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                        <div class="flex items-center">
                                            <span class="text-xs text-gray-400 mr-1">💰</span>
                                            <span
                                                class="text-sm font-medium text-gray-800"><?= htmlspecialchars($job['salary']) ?></span>
                                        </div>
                                        <button onclick="selectPosition('<?= htmlspecialchars($job['position']) ?>')"
                                            class="text-sm text-gray-500 hover:text-gray-700 bg-gray-50 hover:bg-gray-100 px-3 py-1.5 rounded-lg transition-colors duration-200 flex items-center gap-1">
                                            Apply
                                            <i class="fas fa-arrow-right text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="bg-gray-50 rounded-xl border border-gray-200 p-10 text-center">
                        <div
                            class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                            <i class="fas fa-briefcase text-2xl text-gray-300"></i>
                        </div>
                        <p class="text-gray-500 text-sm mb-1">No open positions at the moment</p>
                        <p class="text-xs text-gray-400">Please check back later for new opportunities</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Application Form Section -->
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6" id="applySection">
                <div class="flex items-center gap-2 mb-5 pb-2 border-b border-gray-200">
                    <i class="fas fa-file-signature text-gray-400"></i>
                    <h2 class="text-lg font-semibold text-gray-800">Apply Now</h2>
                    <span class="ml-auto text-xs bg-white text-gray-600 px-2 py-1 rounded-full border border-gray-200"
                        id="selected-position-display"></span>
                </div>

                <!-- Flash Messages -->
                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="mb-4 space-y-2">
                        <?php foreach ($_SESSION['success'] as $msg): ?>
                            <div class="flex items-center justify-between bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg"
                                role="alert">
                                <span class="text-sm flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-500"></i>
                                    <?= htmlspecialchars($msg) ?>
                                </span>
                                <button onclick="this.parentElement.remove();" class="text-green-600 hover:text-green-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="mb-4 space-y-2">
                        <?php foreach ($_SESSION['error'] as $msg): ?>
                            <div class="flex items-center justify-between bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg"
                                role="alert">
                                <span class="text-sm flex items-center gap-2">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                    <?= htmlspecialchars($msg) ?>
                                </span>
                                <button onclick="this.parentElement.remove();" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form method="POST" action="/submitApplication" class="space-y-4" id="applicationForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Full Name -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Full
                                name <span class="text-red-400">*</span></label>
                            <input type="text" name="full_name" placeholder="Jamie Smith" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email
                                <span class="text-red-400">*</span></label>
                            <input type="email" name="email" placeholder="you@example.com" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Phone
                                <span class="text-red-400">*</span></label>
                            <input type="tel" name="phone" placeholder="(555) 123-4567" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm">
                        </div>

                        <!-- Position (hidden, set by JavaScript) -->
                        <input type="hidden" name="position" id="selected-position" value="">

                        <!-- Display selected position (read-only) -->
                        <div>
                            <label
                                class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Selected
                                Position</label>
                            <div class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-sm text-gray-600"
                                id="position-display">
                                Not selected
                            </div>
                        </div>

                        <!-- Experience -->
                        <div>
                            <label
                                class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Experience
                                <span class="text-red-400">*</span></label>
                            <input type="text" name="experience" placeholder="e.g. 3 years in restaurant" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm">
                        </div>

                        <!-- Education -->
                        <div>
                            <label
                                class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Education
                                <span class="text-red-400">*</span></label>
                            <input type="text" name="education" placeholder="e.g. Culinary arts diploma" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Gender
                                <span class="text-red-400">*</span></label>
                            <select name="gender" id="gender" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm">
                                <option value="Select you gender">Select you gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Age
                                <span class="text-red-400">*</span></label>
                            <input type="text" name="age" placeholder="18" required
                                class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm">
                        </div>
                    </div>

                    <!-- Skills -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Skills
                            <span class="text-red-400">*</span></label>
                        <textarea name="skills" rows="2" placeholder="e.g. POS systems, multilingual, food safety"
                            required
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm"></textarea>
                    </div>

                    <!-- Resume -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Resume
                            (optional)</label>
                        <div class="flex items-center gap-2">
                            <input type="file" name="resume" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-gray-200 file:text-gray-600 hover:file:bg-gray-300 border border-gray-200 rounded-lg">
                            <input type="hidden" name="resume_url" id="resume_url">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">PDF, DOC, or image (max 5MB)</p>
                    </div>

                    <!-- Cover Note -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cover note
                            (optional)</label>
                        <textarea name="cover_note" rows="2" placeholder="Anything else you'd like us to know..."
                            class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-200 focus:border-gray-400 transition-all duration-200 text-sm"></textarea>
                    </div>

                    <!-- Submit -->
                    <?php if (!empty($jobPostings)): ?>
                        <button type="submit"
                            class="w-full px-4 py-3 text-sm font-medium text-white bg-gray-800 hover:bg-gray-900 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            Submit Application
                        </button>
                    <?php else: ?>
                        <div
                            class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-700 text-sm flex items-center gap-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            No open positions at the moment. The application form is temporarily disabled.
                        </div>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Footer Note -->
            <div class="mt-6 text-center text-xs text-gray-400">
                <p>All applications are reviewed within 3-5 business days. We'll contact you for next steps.</p>
            </div>
        </div>

        <script>
            function selectPosition(position) {
                document.getElementById('selected-position').value = position;
                document.getElementById('position-display').textContent = position;
                document.getElementById('selected-position-display').textContent = 'Applying for: ' + position;

                document.getElementById('applySection').scrollIntoView({ behavior: 'smooth' });
            }
        </script>
    </body>
    <script src="/assets/js/resumeUpload.js" type="module"></script>

</html>