<?php if (!isset($hide_footer) || !$hide_footer): ?>
<!-- Footer -->
<footer style="background-color: #000; color: #fff; padding: 60px 0; text-align: center;">
    <div class="container">
        <div style="display: flex; flex-direction: column; align-items: center; gap: 30px; max-width: 800px; margin: 0 auto;">
            
            <!-- Logo -->
            <div style="display: flex; align-items: center; gap: 10px; font-size: 24px; font-weight: 700; letter-spacing: 1px;">
                <!-- Using a white version of logo or filter if needed, but standard img for now -->
                <img src="<?= base_url('assets/images/uploaded_image_1765372954783.png') ?>" alt="LibyanJobs" style="height: 40px; brightness: 0; invert: 1;"> 
                <span style="color: #fff;">LIBYANJOBS</span>
            </div>

            <!-- About Us (AI Generated) -->
            <p style="font-size: 16px; line-height: 1.8; color: #ccc;">
                LibyanJobs is the premier digital gateway connecting Libya's top talent with visionary companies. Established to bridge the gap in the local job market, we leverage cutting-edge technology to streamline recruitment, foster professional growth, and empower the next generation of Libyan workforce. Your future career starts here.
            </p>

            <!-- Contact Info -->
            <div style="display: flex; flex-direction: column; gap: 10px; font-size: 18px;">
                <a href="tel:+218910116794" style="color: #fff; text-decoration: none; display: flex; align-items: center; gap: 10px; justify-content: center;">
                    <i class="fa-solid fa-phone"></i> +218 91 011 6794
                </a>
            </div>

            <!-- Social Media -->
            <div style="display: flex; gap: 20px; font-size: 20px;">
                <a href="#" style="color: #fff; transition: opacity 0.3s; opacity: 0.8;"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" style="color: #fff; transition: opacity 0.3s; opacity: 0.8;"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" style="color: #fff; transition: opacity 0.3s; opacity: 0.8;"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" style="color: #fff; transition: opacity 0.3s; opacity: 0.8;"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            
            <div style="margin-top: 20px; font-size: 13px; color: #555;">
                &copy; <?= date('Y') ?> LibyanJobs. All rights reserved.
            </div>

        </div>
    </div>
</footer>
<?php endif; ?>
<!-- JS -->
<script src="<?= base_url('assets/js/main.js?v=' . time()) ?>"></script>
</body>
</html>