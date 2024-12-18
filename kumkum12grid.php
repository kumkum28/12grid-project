<?php
$successMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $orgName = htmlspecialchars($_POST['org_name']);
    $phone = htmlspecialchars($_POST['phone']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Validate Empty Fields
    if (empty($name) || empty($orgName) || empty($phone) || empty($email) || empty($recaptchaResponse)) {
        $errorMessage = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Invalid email format.";
    } else {
        // Validate Google reCAPTCHA
        $secretKey = 'YOUR_SECRET_KEY'; // Replace with your reCAPTCHA Secret Key
        $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents("$verifyURL?secret=$secretKey&response=$recaptchaResponse");
        $responseKeys = json_decode($response, true);

        if (!$responseKeys["success"]) {
            $errorMessage = "reCAPTCHA verification failed. Try again.";
        } else {
            // Send Email Logic
            $to = "your-email@example.com"; // Replace with your email
            $subject = "New Contact Form Submission";
            $body = "Name: $name\nOrganization: $orgName\nPhone: $phone\nEmail: $email\nMessage: $message";
            $headers = "From: $email";

            if (mail($to, $subject, $body, $headers)) {
                $successMessage = "Message sent successfully!";
            } else {
                $errorMessage = "Failed to send the message.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Page</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Header -->
    <header class="text-center my-8">
        <h1 class="text-4xl font-bold text-gray-900">LASER TECHNOLOGIES</h1>
    </header>


   
    <!-- Contact Form -->
    <section class="bg-white max-w-5xl mx-auto p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Get in touch</h2>
        <p class="text-gray-600 mb-6">Need our expertise for choosing your next Laser machine?</p>

        <!-- Success/Error Messages -->
        <?php if ($successMessage): ?>
            <p class="text-green-600 mb-4"><?php echo $successMessage; ?></p>
        <?php elseif ($errorMessage): ?>
            <p class="text-red-600 mb-4" id="errorPopup"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <!-- Form -->
        <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <input type="text" name="name" placeholder="Your Name" class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <input type="text" name="org_name" placeholder="Organization Name" class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <input type="tel" name="phone" placeholder="Contact Number" class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <input type="email" name="email" placeholder="Email ID" class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-400" required>
            <textarea name="message" rows="5" placeholder="Your Message" class="p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 md:col-span-2" required></textarea>

            <!-- reCAPTCHA -->
            <div class="g-recaptcha" data-sitekey="6LeMY5wqAAAAAJzu_HTs9sZX2dSsqmzeVG-uEv6r"></div>
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-md md:col-span-2">Submit</button>
        </form>
    </section>

<!-- Google Map Section with Blackbox Info -->
<section class="mt-12 max-w-5xl mx-auto p-6 bg-gray-200 rounded-lg shadow-md relative">
    <!-- Map Container -->
    <div class="relative h-96 w-full rounded-lg overflow-hidden">
        <!-- Embedded Google Map -->
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.6333455528293!2d72.88897517466633!3d19.123734450473332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c80e7065cd01%3A0x6762fa5c67ba4ac0!2sRIR%20POWER%20ELECTRONICS%20LIMITED%20(Formerly%20Ruttonsha%20International%20Rectifier%20Ltd.)!5e0!3m2!1sen!2sin!4v1734250243655!5m2!1sen!2sin" 
            width="100%" 
            height="100%" 
            frameborder="0" 
            style="border:0;" 
            allowfullscreen 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>

        <!-- Black Information Box -->
        <div class="absolute top-8 left-8 bg-gray-900 text-white p-6 rounded-lg shadow-lg max-w-sm">
            <h3 class="text-lg font-semibold mb-2">Headquarters office</h3>
            <p class="text-sm font-medium">Laser Technologies Pvt Ltd</p>
            <p class="text-sm mt-1">PAP/R/6/B, Rabale MIDC, Near Dual Electric Company,<br>
            Rabale MIDC, Navi Mumbai - 400701.</p>
            <p class="text-sm mt-1"><strong>Landline:</strong> +91 22 4193 0999</p>
            <a href="https://maps.google.com" target="_blank" class="text-green-400 mt-2 inline-block hover:underline">
                Google Map Link
            </a>
        </div>
    </div>
</section>

    <!-- How Can We Help Section -->
    <section class="bg-white max-w-5xl mx-auto p-8 rounded-lg shadow-lg mb-8">
        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">How can we help?</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
            <div class="p-4 border rounded-lg hover:shadow-lg">
                <img src="https://img.icons8.com/ios-filled/50/000000/video-call.png" alt="Demo" class="mx-auto mb-3">
                <h3 class="font-semibold text-red-500">Schedule a <span class="font-bold">Demo</span></h3>
            </div>
            <div class="p-4 border rounded-lg hover:shadow-lg">
                <img src="https://img.icons8.com/ios-filled/50/000000/document.png" alt="Quote" class="mx-auto mb-3">
                <h3 class="font-semibold text-red-500">Request a <span class="font-bold">Quote</span></h3>
            </div>
            <div class="p-4 border rounded-lg hover:shadow-lg">
                <img src="https://img.icons8.com/ios-filled/50/000000/box.png" alt="Sample" class="mx-auto mb-3">
                <h3 class="font-semibold text-red-500">Send us a <span class="font-bold">Sample</span></h3>
            </div>
            <div class="p-4 border rounded-lg hover:shadow-lg">
                <img src="https://img.icons8.com/ios-filled/50/000000/headset.png" alt="Query" class="mx-auto mb-3">
                <h3 class="font-semibold text-red-500">Raise your <span class="font-bold">Query</span></h3>
            </div>
        </div>
    </section>
<!-- Newsletter Subscription -->
<section class="bg-red-500 text-white text-center py-6 mt-8">
        <h3 class="text-xl font-semibold mb-4">Subscribe To Our Newsletter & Stay Updated</h3>
        <div class="flex justify-center items-center gap-2">
            <input type="email" placeholder="Your Email" class="p-3 rounded-l-md text-gray-700 w-2/3 max-w-md">
            <button class="bg-black text-white p-3 rounded-r-md hover:bg-gray-800">SUBSCRIBE</button>
        </div>
    </section>
    <!-- Footer -->
    <footer class="mt-12 bg-gray-900 text-white text-center p-4">
        <p>© 2024 Laser Technologies. All Rights Reserved.</p>
    </footer>

    <!-- Popup Script -->
    <script>
        window.onload = function() {
            const errorPopup = document.getElementById('errorPopup');
            if (errorPopup) {
                setTimeout(() => {
                    errorPopup.style.display = 'none';
                }, 5000);
            }
        };
    </script>
    
</body>
</html>