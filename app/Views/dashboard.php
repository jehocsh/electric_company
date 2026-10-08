<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Puihaha Electric</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/custom.css') ?>" rel="stylesheet">
</head>
<body class="dashboard-page">
    <header class="dashboard-topbar">
        <div class="container py-3 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <a class="dashboard-brand" href="<?= base_url() ?>">
                <i class="fas fa-bolt me-2"></i>Puihaha Electric
            </a>
            <div class="d-flex align-items-center gap-3">
                <span class="dashboard-user d-none d-sm-inline">Signed in as <strong><?= esc($username) ?></strong></span>
                <form action="<?= base_url('logout') ?>" method="post" class="m-0">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-outline-light px-3">
                        <i class="fas fa-arrow-right-from-bracket me-1"></i> Log out
                    </button>
                </form>
            </div>
        </div>
    </header>
    <main class="container dashboard-content">
        <div class="main-container">
            <!-- Header with Logout -->
            <div class="dashboard-heading d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
                <div>
                    <span class="home-login-card__eyebrow">Admin portal</span>
                    <h1 class="mb-1">Customer accounts</h1>
                    <p class="mb-0">Monitor and manage every electric service account in one place.</p>
                </div>
                <a href="<?= base_url('account/create') ?>" class="btn btn-primary px-4">
                    <i class="fas fa-plus me-2"></i>Add account
                </a>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success" role="alert"><i class="fas fa-circle-check me-2"></i><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger" role="alert"><i class="fas fa-circle-exclamation me-2"></i><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6 col-xl-3">
                    <div class="dashboard-stat stat-total">
                        <span class="dashboard-stat__icon"><i class="fas fa-users"></i></span>
                        <h2><?= esc($total_accounts) ?></h2>
                        <p>Total Accounts</p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="dashboard-stat stat-active">
                        <span class="dashboard-stat__icon"><i class="fas fa-circle-check"></i></span>
                        <h2><?= esc($active_accounts) ?></h2>
                        <p>Active Accounts</p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="dashboard-stat stat-inactive">
                        <span class="dashboard-stat__icon"><i class="fas fa-circle-pause"></i></span>
                        <h2><?= esc($inactive_accounts) ?></h2>
                        <p>Inactive Accounts</p>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-3">
                    <div class="dashboard-stat stat-suspended">
                        <span class="dashboard-stat__icon"><i class="fas fa-triangle-exclamation"></i></span>
                        <h2><?= esc($suspended_accounts) ?></h2>
                        <p>Suspended Accounts</p>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="dashboard-panel dashboard-filter mb-4">
                <form method="GET" action="<?= base_url('dashboard') ?>">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="Search accounts..." value="<?= esc($search_keyword ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="active" <?= ($filter_status ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($filter_status ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                <option value="suspended" <?= ($filter_status ?? '') == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="type">
                                <option value="">All Types</option>
                                <option value="residential" <?= ($filter_type ?? '') == 'residential' ? 'selected' : '' ?>>Residential</option>
                                <option value="commercial" <?= ($filter_type ?? '') == 'commercial' ? 'selected' : '' ?>>Commercial</option>
                                <option value="industrial" <?= ($filter_type ?? '') == 'industrial' ? 'selected' : '' ?>>Industrial</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-magnifying-glass"></i> Search</button>
                        </div>
                    </div>
                </form>
                <?php if ($search_keyword || $filter_status || $filter_type): ?>
                    <div class="mt-2">
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-xmark"></i> Clear Filters</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Customer Accounts Table -->
            <div class="dashboard-panel p-0 overflow-hidden table-responsive">
                <table class="table dashboard-table">
                    <thead>
                        <tr>
                            <th>Account Number</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Connection Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($accounts)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No accounts found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($accounts as $account): ?>
                                <tr>
                                    <td><strong class="text-primary"><?= esc($account['account_number']) ?></strong></td>
                                    <td><strong><?= esc($account['customer_name']) ?></strong></td>
                                    <td><?= esc($account['email']) ?></td>
                                    <td><span class="type-badge"><?= esc(ucfirst($account['connection_type'])) ?></span></td>
                                    <td>
                                        <?php $status = in_array($account['status'], ['active', 'inactive', 'suspended'], true) ? $account['status'] : 'inactive'; ?>
                                        <span class="status-badge status-<?= esc($status) ?>"><?= esc(ucfirst($account['status'])) ?></span>
                                    </td>
                                    <td><div class="account-actions justify-content-end">
                                        <a href="<?= base_url('account/' . $account['id']) ?>" class="btn btn-sm btn-outline-primary" title="View account">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('account/edit/' . $account['id']) ?>" class="btn btn-sm btn-outline-warning" title="Edit account">
        <i class="fas fa-pen"></i>
    </a>
    <a href="<?= base_url('account/delete/' . $account['id']) ?>" class="btn btn-sm btn-outline-danger" title="Delete account" onclick="return confirm('Are you sure you want to delete this account?')">
        <i class="fas fa-trash"></i>
    </a>
                                    </div></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if ($pager): ?>
                <div class="dashboard-pagination d-flex justify-content-between align-items-center mt-3">
                    <div>Showing page <?= $current_page ?> of <?= $pager->getPageCount() ?></div>
                    <div><?= $pager->links() ?></div>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
