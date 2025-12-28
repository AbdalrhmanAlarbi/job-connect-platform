<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Pending - LibyanJobs</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(0,0,0,0.8);
            font-family: 'Inter', sans-serif;
            color: white;
            text-align: center;
        }
        .content {
            background: #fff;
            color: #333;
            padding: 40px;
            border-radius: 20px;
            width: 400px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }
        .loading-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 20px 0;
        }
        .dot {
            width: 12px;
            height: 12px;
            background: var(--primary-color, #0044cc);
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .dot:nth-child(1) { animation-delay: -0.32s; }
        .dot:nth-child(2) { animation-delay: -0.16s; }
        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="content">
        <div style="font-size: 60px; color: #0044cc; margin-bottom: 20px;">
            <i class="fa-regular fa-clock"></i> <!-- Assuming FontAwesome is loaded or using CSS shape -->
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #0044cc;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
        </div>
        <h2 style="margin: 0 0 10px 0;">Request Waiting...</h2>
        <p style="color: #666; margin-bottom: 30px;">Your company account request is under review. Please wait until the admin accepts your request.</p>
        
        <div class="loading-dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
        
        <a href="<?= base_url('/') ?>" style="display: inline-block; margin-top: 20px; font-size: 14px; text-decoration: none; color: #0044cc;">Return to Home</a>
    </div>
</body>
</html>
