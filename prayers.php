<?php
session_start();
require_once 'config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit; }

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? 'Other';
    $request = $_POST['request'] ?? '';
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    if ($is_anonymous) {
        $name = 'Anonymous';
    }

    if (!empty($request)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO prayer_requests (name, category, request, is_anonymous) VALUES (?, ?, ?, ?)");
            if ($stmt->execute([$name, $category, $request, $is_anonymous])) {
                 $message = "Prayer request submitted successfully.";
                 $messageType = "success";
            } else {
                 $message = "Failed to submit request. Please try again.";
                 $messageType = "error";
            }
        } catch(PDOException $e) {
            $message = "A system error occurred. Please try again.";
            $messageType = "error";
        }
    } else {
        $message = "Request details cannot be empty.";
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Prayer Request</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<    <style>
        .page-wrapper {
            max-width: 680px;
            margin: 0 auto;
            padding: 40px 20px 100px;
        }

        .category-chips {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .chip {
            padding: 10px 24px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: var(--radius-full);
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            color: var(--text-dim);
            position: relative;
        }

        .chip:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .chip.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            box-shadow: 0 8px 16px var(--primary-glow);
        }

        .chip input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .anon-toggle {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 24px;
            background: #F8FAFC;
            border-radius: var(--radius-md);
            margin-bottom: 35px;
            cursor: pointer;
            border: 1px solid #F1F5F9;
            transition: var(--transition);
        }

        .anon-toggle:hover {
            background: #F1F5F9;
        }

        .char-counter {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-dim);
        }

        .success-box {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.2);
            color: #15803D;
            padding: 20px;
            border-radius: var(--radius-md);
            margin-bottom: 30px;
            display: flex;
            align-items: center; gap: 12px; font-weight: 600;
        }

        .error-box {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #B91C1C;
            padding: 20px;
            border-radius: var(--radius-md);
            margin-bottom: 30px;
            display: flex;
            align-items: center; gap: 12px; font-weight: 600;
        }
    </style>
</head>
<body>
    <nav class="dashboard-nav glass">
        <div class="nav-brand">
            <a href="dashboard.php" class="mini-logo"><i class="fa-solid fa-arrow-left"></i></a>
            <h2 class="brand-font" style="letter-spacing: 1px;">PRAYER ROOM</h2>
        </div>
        <div class="badge badge-primary animate-fade-in" style="font-size: 10px;">INTERCESSION</div>
    </nav>

    <div class="page-wrapper animate-fade-in">
        <div class="page-header" style="margin-bottom: 50px;">
            <div class="badge badge-primary" style="margin-bottom: 15px; font-size: 11px; background: rgba(99, 102, 241, 0.1); color: var(--secondary); border: 1px solid rgba(99, 102, 241, 0.2);">SPIRITUAL SUPPORT</div>
            <h1 style="font-size: 42px; font-weight: 800;">How can we <span class="text-gradient">Pray for you?</span></h1>
            <p class="subtitle" style="font-size: 18px;">"Where two or three are gathered together in my name, there am I in the midst of them." — Matthew 18:20</p>
        </div>

        <?php if(!empty($message)): ?>
            <div class="<?php echo $messageType === 'success' ? 'success-box' : 'error-box'; ?> animate-fade-in">
                <i class="fa-solid <?php echo $messageType === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation'; ?>"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="glass" style="padding: 50px; border-radius: var(--radius-xl); background: rgba(255,255,255,0.9); border: 1px solid #FFFFFF;">
            <form method="POST">
                <div class="input-group">
                    <label class="input-label">FullName (Leave blank for anonymous)</label>
                    <input type="text" name="name" class="modern-input" placeholder="Enter your name" style="background: white; border: 1px solid #E2E8F0; color: var(--text-main);">
                </div>

                <div class="input-group">
                    <label class="input-label">Prayer Category</label>
                    <div class="category-chips">
                        <label class="chip active">
                            <input type="radio" name="category" value="Healing" checked required> Healing
                        </label>
                        <label class="chip">
                            <input type="radio" name="category" value="Family"> Family
                        </label>
                        <label class="chip">
                            <input type="radio" name="category" value="Finance"> Finance
                        </label>
                        <label class="chip">
                            <input type="radio" name="category" value="Other"> Other
                        </label>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Your Prayer Request</label>
                    <textarea name="request" id="prayerRequest" class="modern-input" placeholder="Share your burden with us..." required style="min-height: 200px; background: white; border: 1px solid #E2E8F0; color: var(--text-main); font-size: 15px;"></textarea>
                    <div class="char-counter">
                        <span>Min 10 characters</span>
                        <span id="charCount">0/500</span>
                    </div>
                </div>

                <label class="anon-toggle">
                    <input type="checkbox" name="is_anonymous" style="width: 20px; height: 20px; accent-color: var(--primary);">
                    <div style="flex-grow: 1;">
                        <span style="display: block; font-weight: 700; color: var(--text-main); font-size: 14px;">Submit Anonymously</span>
                        <span style="display: block; font-size: 12px; color: var(--text-dim);">Your request will be visible to our team but your name will be hidden.</span>
                    </div>
                    <i class="fa-solid fa-lock-open" style="color: var(--text-dim); opacity: 0.5;"></i>
                </label>

                <button type="submit" class="btn-premium" style="margin-top: 10px; border-radius: var(--radius-lg); font-size: 18px; padding: 20px;">
                    Submit Prayer <i class="fa-solid fa-paper-plane" style="margin-left: 8px;"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.chip').forEach(chip => {
            chip.addEventListener('click', function() {
                document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                this.querySelector('input').checked = true;
            });
        });

        const prayerRequest = document.getElementById('prayerRequest');
        const charCountDisplay = document.getElementById('charCount');
        prayerRequest.addEventListener('input', function() {
            charCountDisplay.textContent = `${this.value.length}/500`;
        });
    </script>
</body>
</html>y>
</html>
