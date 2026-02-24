<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HotelJobs · complete application</title>
        <!-- Tailwind + Font Awesome -->
        <link rel="stylesheet" href="/assets/css/output.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </head>

    <body class="p-4 md:p-8 antialiased">

        <div class="max-w-6xl mx-auto">
            <!-- page header -->
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 tracking-tight" style="color: #1a2e40;"> Join
                    our hotel & restaurant</h1>
                <p class="text-gray-600 mt-2 text-lg">Browse open positions and send your complete application below</p>
            </div>

            <!-- JOB LISTINGS (full width) -->
            <div class="space-y-5 mb-10">
                <h2 class="text-xl font-semibold flex items-center gap-2 text-gray-800">
                    <i class="fas fa-briefcase" style="color: var(--color-primary);"></i> Open positions
                </h2>

                <?php if (!empty($jobPostings)): ?>
                    <?php foreach ($jobPostings as $job): ?>
                        <div class="bg-white rounded-card shadow-card p-5 job-card-hover">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">
                                        <?= htmlspecialchars($job['position']) ?>
                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 mt-1 text-sm text-gray-500">
                                        <span class="dept-badge"><i class="fas fa-building mr-1"></i>
                                            <?= htmlspecialchars($job['department']) ?>
                                        </span>
                                        <span><i class="far fa-clock mr-1"></i>
                                            <?= htmlspecialchars($job['shift']) ?>
                                        </span>
                                        <span><i class="fas fa-map-pin mr-1"></i>
                                            <?= htmlspecialchars($job['location']) ?>
                                        </span>
                                    </div>
                                </div>
                                <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-3 py-1 rounded-pill">now
                                    hiring</span>
                            </div>
                            <p class="text-gray-600 text-sm mt-3 leading-relaxed">
                                <?= !empty($job['description']) ? htmlspecialchars($job['description']) : 'Apply now for this position.' ?>
                            </p>
                            <div class="flex items-center justify-between mt-4 text-sm">
                                <span class="text-gray-500"><i class="fas fa-dollar-sign mr-1 text-gray-400"></i>
                                    <?= htmlspecialchars($job['salary']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No open positions at the moment. Please check back later.</p>
                <?php endif; ?>
            </div>

            <div class="bg-white rounded-card shadow-soft p-6 w-full" id="applySection">
                <h2 class="text-xl font-semibold flex items-center gap-2 mb-5 text-gray-800"><i
                        class="fas fa-file-signature" style="color: var(--color-primary);"></i> Apply now</h2>

                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="mb-4 space-y-2">
                        <?php foreach ($_SESSION['success'] as $msg): ?>
                            <div class="flex items-center justify-between bg-green-100 border-green-400 text-green-700 px-4 py-3 rounded shadow-md"
                                role="alert">
                                <span>
                                    <?= htmlspecialchars($msg) ?>
                                </span>
                                <button onclick="this.parentElement.remove();"
                                    class="ml-4 font-bold text-green-700 hover:text-green-900">&times;</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="mb-4 space-y-2">
                        <?php foreach ($_SESSION['error'] as $msg): ?>
                            <div class="flex items-center justify-between bg-red-100 text-red-700 px-4 py-3 rounded shadow-md"
                                role="alert">
                                <span>
                                    <?= htmlspecialchars($msg) ?>
                                </span>
                                <button onclick="this.parentElement.remove();"
                                    class="ml-4 font-bold text-red-700 hover:text-red-900">&times;</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form method="POST" action="/submitApplication" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full name <span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="full_name" placeholder="Jamie Smith" required
                                class="w-full bg-input border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email <span
                                    class="text-red-400">*</span></label>
                            <input type="email" name="email" placeholder="you@example.com" required
                                class="w-full bg-input border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span
                                    class="text-red-400">*</span></label>
                            <input type="tel" name="phone" placeholder="(555) 123-4567"
                                class="w-full bg-input border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Desired position</label>
                            <select name="position"
                                class="w-full bg-input-alt border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom">
                                <?php if (!empty($jobPostings)): ?>
                                    <?php foreach ($jobPostings as $job): ?>
                                        <option value="<?= htmlspecialchars($job['position']) ?>">
                                            <?= htmlspecialchars($job['position']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="any">Any suitable / open</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Experience <span
                                    class="text-gray-400 text-xs">(years / summary)</span><span
                                    class="text-red-400">*</span></label>
                            <input type="text" name="experience" placeholder="e.g. 3 years in full-service restaurant"
                                class="w-full bg-input border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Education /
                                Certifications <span class="text-red-400">*</span></label>
                            <input type="text" name="education" placeholder="e.g. Culinary arts diploma, high school"
                                class="w-full bg-input border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Skills <span
                                class="text-red-400">*</span></label>
                        <textarea name="skills" rows="2" placeholder="e.g. POS systems, multilingual, food safety, ..."
                            class="w-full bg-input border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom resize-none"
                            required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Resume / CV (PDF or image) <span
                                class="text-gray-400 text-xs">optional</span></label>
                        <div class="flex items-center gap-2">
                            <input type="file" name="resume" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                class="block w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-input-alt file:text-gray-700 hover:file:bg-gray-200 border border-input rounded-md cursor-pointer bg-input">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">max 5MB (static demo, no upload)</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cover note (optional)</label>
                        <textarea name="cover_note" rows="2" placeholder="Anything else you'd like us to know..."
                            class="w-full bg-input border border-input rounded-md px-4 py-2.5 text-sm focus-ring-custom resize-none"></textarea>
                    </div>

                    <?php if (!empty($jobPostings)): ?>
                        <form method="POST" action="/submitApplication" class="space-y-5">
                            <!-- form fields here (as before) -->
                            <button type="submit"
                                class="w-full bg-primary hover:bg-primary-hover text-white font-medium py-3 rounded-md text-sm shadow-sm transition flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane"></i> Submit application
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="p-5 bg-yellow-100 text-yellow-800 rounded-md text-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Sorry, there are no open positions at the moment. The application form is temporarily disabled.
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </body>

</html>