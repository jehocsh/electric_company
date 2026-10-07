<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account - Puihaha Electric Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px 0; }
        .main-container { background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 30px; margin: 20px auto; max-width: 800px; }
        .header-section { text-align: center; margin-bottom: 30px; }
        .header-section h1 { color: #667eea; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-container">
            <div class="header-section">
                <h1><i class="bi bi-pencil-square text-warning"></i> Edit Account</h1>
            </div>

            <div class="mb-4">
                <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <form action="<?= base_url('account/update/' . $account['id']) ?>" method="POST">
                <?= csrf_field() ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Account Number</label>
                        <input type="text" name="account_number" class="form-control" value="<?= esc($account['account_number']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Meter Number</label>
                        <input type="text" name="meter_number" class="form-control" value="<?= esc($account['meter_number']) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Customer Name</label>
                    <input type="text" name="customer_name" class="form-control" value="<?= esc($account['customer_name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" rows="2" required><?= esc($account['address']) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($account['phone']) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($account['email']) ?>">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Connection Type</label>
                        <select name="connection_type" class="form-select" required>
                            <option value="residential" <?= $account['connection_type'] == 'residential' ? 'selected' : '' ?>>Residential</option>
                            <option value="commercial" <?= $account['connection_type'] == 'commercial' ? 'selected' : '' ?>>Commercial</option>
                            <option value="industrial" <?= $account['connection_type'] == 'industrial' ? 'selected' : '' ?>>Industrial</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" <?= $account['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $account['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="suspended" <?= $account['status'] == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold">Update Account</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>