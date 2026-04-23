<?php
session_start();
require_once 'config.php';
// Removed forced login check to allow guest donations
$user_id = $_SESSION['user_id'] ?? null;


$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';
    $amount = $_POST['amount'] ?? 0;
    if (empty($amount)) {
        $amount = $_POST['custom_amount'] ?? 0;
    }
    $payment_method = $_POST['payment_method'] ?? '';
    $reason = $_POST['reason'] ?? '';

    if ($type && $amount > 0 && $payment_method) {
        $stmt = $pdo->prepare("INSERT INTO donations (user_id, type, amount, payment_method, reason) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $type, $amount, $payment_method, $reason])) {
            if (!$user_id) {
                header("Location: login.php?donated=1");
                exit;
            }
            $message = "<div style='color: green; margin-bottom: 20px; text-align: center;'>Donation processed successfully! God bless you.</div>";
        } else {
            $message = "<div style='color: red; margin-bottom: 20px; text-align: center;'>Failed to process donation.</div>";
        }
    } else {
        $message = "<div style='color: red; margin-bottom: 20px; text-align: center;'>Please select type, amount, and payment method.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generous Giving</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .page-wrapper {
            max-width: 680px;
            margin: 0 auto;
            padding: 40px 20px 100px;
        }

        .segmented-control {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            background: #F1F5F9;
            padding: 5px;
            border-radius: var(--radius-md);
            margin-bottom: 40px;
        }

        .segment-tab {
            text-align: center;
            padding: 12px;
            border-radius: calc(var(--radius-md) - 4px);
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            transition: var(--transition);
            color: var(--text-dim);
            position: relative;
        }

        .segment-tab:hover {
            color: var(--text-main);
        }

        .segment-tab.active {
            background: white;
            color: var(--primary);
            box-shadow: var(--shadow-sm);
        }

        .segment-tab input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .amount-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .amount-card {
            background: white;
            border: 1px solid #E2E8F0;
            padding: 20px;
            border-radius: var(--radius-md);
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
        }

        .amount-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-sm);
            transform: translateY(-2px);
        }

        .amount-card.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
            box-shadow: 0 10px 20px var(--primary-glow);
        }

        .amount-card .val {
            font-size: 20px;
            font-weight: 800;
            display: block;
        }

        .amount-card .cur {
            font-size: 11px;
            opacity: 0.8;
            font-weight: 700;
            text-transform: uppercase;
        }

        .payment-method-grid {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 40px;
        }

        .payment-card {
            display: flex;
            align-items: center;
            padding: 18px 24px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: var(--radius-md);
            cursor: pointer;
            transition: var(--transition);
        }

        .payment-card:hover {
            border-color: var(--primary);
            background: #F8FAFC;
        }

        .payment-card.active {
            border-color: var(--primary);
            background: #EFF6FF;
            box-shadow: inset 0 0 0 1px var(--primary);
        }

        .payment-card input {
            margin-right: 20px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        .payment-info {
            flex-grow: 1;
        }

        .payment-name {
            display: block;
            font-weight: 700;
            font-size: 16px;
            color: var(--text-main);
        }

        .payment-desc {
            font-size: 12px;
            color: var(--text-dim);
        }

        .payment-logo {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #F1F5F9;
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav glass">
        <div class="nav-brand">
            <a href="<?php echo $user_id ? 'dashboard.php' : 'login.php'; ?>" class="mini-logo"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="brand-font" style="letter-spacing: 1px;">GIVE GENEROUSLY</h2>
        </div>
        <?php if (!$user_id): ?>
            <div class="badge badge-primary animate-fade-in" style="font-size: 10px;">GUEST SESSION</div>
        <?php else: ?>
             <div class="badge badge-primary animate-fade-in" style="background: rgba(34, 197, 94, 0.1); color: #16A34A; border: 1px solid rgba(34, 197, 94, 0.2); font-size: 10px;">LOGGED IN</div>
        <?php endif; ?>
    </nav>

    <div class="page-wrapper animate-fade-in">
        <div class="page-header" style="margin-bottom: 50px;">
            <div class="badge badge-primary" style="margin-bottom: 15px; font-size: 11px;">STEWARDSHIP</div>
            <h1>Support the <span class="text-gradient">Ministry</span></h1>
            <p class="subtitle" style="font-size: 18px;">"Each of you should give what you have decided in your heart to give." — 2 Cor 9:7</p>
        </div>

        <?php echo $message; ?>
        
        <div class="glass" style="padding: 50px; border-radius: var(--radius-xl); background: rgba(255,255,255,0.9); border: 1px solid #FFFFFF;">
            <form method="POST" id="givingForm">
                <label class="input-label">Donation Category</label>
                <div class="segmented-control">
                    <label class="segment-tab active">
                        <input type="radio" name="type" value="Offertory" required checked> Offertory
                    </label>
                    <label class="segment-tab">
                        <input type="radio" name="type" value="Tithe" required> Tithe
                    </label>
                    <label class="segment-tab">
                        <input type="radio" name="type" value="Seed" required> Seed
                    </label>
                </div>

                <label class="input-label">Choose Amount</label>
                <div class="amount-grid">
                    <label class="amount-card">
                        <input type="radio" name="amount" value="10000" style="display:none;">
                        <span class="cur">UGX</span>
                        <span class="val">10k</span>
                    </label>
                    <label class="amount-card active">
                        <input type="radio" name="amount" value="50000" style="display:none;" checked>
                        <span class="cur">UGX</span>
                        <span class="val">50k</span>
                    </label>
                    <label class="amount-card">
                        <input type="radio" name="amount" value="100000" style="display:none;">
                        <span class="cur">UGX</span>
                        <span class="val">100k</span>
                    </label>
                </div>
                
                <div class="input-group" style="margin-bottom: 40px;">
                    <div style="position: relative;">
                        <span style="position: absolute; left: 18px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--text-dim);">UGX</span>
                        <input type="number" name="custom_amount" id="customAmount" class="modern-input" placeholder="Enter custom amount" style="padding-left: 60px; background: white; border: 1px solid #E2E8F0; color: var(--text-main);">
                    </div>
                </div>

                <label class="input-label">Transfer Method</label>
                <div class="payment-method-grid">
                    <label class="payment-card active">
                        <input type="radio" name="payment_method" value="MTN Mobile Money" required checked>
                        <div class="payment-info">
                            <span class="payment-name">MTN Mobile Money</span>
                            <span class="payment-desc">Instant transfer via MoMo</span>
                        </div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/9/93/New-mtn-logo.jpg" alt="MTN" class="payment-logo">
                    </label>
                    <label class="payment-card">
                        <input type="radio" name="payment_method" value="Airtel Money" required>
                        <div class="payment-info">
                            <span class="payment-name">Airtel Money</span>
                            <span class="payment-desc">Instant transfer via Airtel</span>
                        </div>
                        <img src="images/airtel_money.png" alt="Airtel" class="payment-logo" style="object-fit: contain; padding: 5px;">
                    </label>
                </div>

                <label class="input-label">Dedication (Optional)</label>
                <div class="input-group">
                    <textarea name="reason" class="modern-input" placeholder="e.g. Building Fund contribution" style="min-height: 100px; background: white; border: 1px solid #E2E8F0; color: var(--text-main); font-size: 14px;"></textarea>
                </div>

                <button type="submit" class="btn-premium" style="margin-top: 30px; border-radius: var(--radius-lg); font-size: 18px; padding: 20px;">
                    Complete Donation <i class="fa-solid fa-heart" style="margin-left: 5px;"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        // Premium Interaction Logic for Giving Form
        const amountCards = document.querySelectorAll('.amount-card');
        const customAmount = document.getElementById('customAmount');
        const segmentTabs = document.querySelectorAll('.segment-tab');
        const paymentCards = document.querySelectorAll('.payment-card');

        amountCards.forEach(card => {
            card.addEventListener('click', function() {
                amountCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input').checked = true;
                customAmount.value = '';
            });
        });

        customAmount.addEventListener('input', function() {
            if (this.value) {
                amountCards.forEach(c => c.classList.remove('active'));
                const checkedRadio = document.querySelector('input[name="amount"]:checked');
                if (checkedRadio) checkedRadio.checked = false;
            }
        });

        segmentTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                segmentTabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input').checked = true;
            });
        });

        paymentCards.forEach(card => {
            card.addEventListener('click', function() {
                paymentCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input').checked = true;
            });
        });
    </script>
</body>
</html>
