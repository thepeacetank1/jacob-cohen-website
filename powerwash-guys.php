<?php
// PHP Form Handler - Placed at the top of the file
$formSubmitted = false;
$formError = false;
$errorMessage = '';

// Process the form if it was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? htmlspecialchars(trim($_POST['phone'])) : 'Not provided';
    $service = isset($_POST['service']) ? htmlspecialchars(trim($_POST['service'])) : 'Not specified';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($message)) {
        $formError = true;
        $errorMessage = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formError = true;
        $errorMessage = "Please enter a valid email address.";
    } else {
        // Set email parameters
        $to = "cmlsrandolph@gmail.com"; // Your email address
        $subject = "New Power Wash Request from $name";
        
        // Create email body
        $email_body = "You have received a new message from your website contact form.\n\n";
        $email_body .= "Name: $name\n";
        $email_body .= "Email: $email\n";
        $email_body .= "Phone: $phone\n";
        $email_body .= "Service Needed: $service\n\n";
        $email_body .= "Message:\n$message\n";
        
        // Set email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        // Attempt to send the email
        if (mail($to, $subject, $email_body, $headers)) {
            $formSubmitted = true;
        } else {
            $formError = true;
            $errorMessage = "Sorry, there was an error sending your message. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>The Power Wash Guys - Expert Cleaning Services</title>
    <link rel="canonical" href="https://thepowerwashguys.net/" />
    <meta name="description" content="The Power Wash Guys offer professional power washing and exterior cleaning services for homes and businesses. Get a free quote today!" />
    <style>
        /* Basic Reset & Defaults */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth; /* Enable smooth scrolling */
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        /* Header & Navigation */
        header {
            background: #333;
            color: #fff;
            padding: 1rem 0;
            position: sticky; /* Make header stick to top */
            top: 0;
            z-index: 1000;
            width: 100%;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        nav .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 1.5rem;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #00aaff; /* Accent color */
        }

        /* Sections General Styling */
        section {
            padding: 4rem 2rem;
            max-width: 1100px;
            margin: 2rem auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        section h2 {
            text-align: center;
            margin-bottom: 2rem;
            color: #333;
            font-size: 2rem;
        }

        /* Hero Section */
        #hero {
            position: relative;
            min-height: 60vh; /* Adjust height as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
            padding: 0; /* Remove padding to allow image full bleed */
            overflow: hidden; /* Hide overflowing parts of the image */
            border-radius: 0; /* Full width hero */
            margin: 0 auto; /* Remove top/bottom margin */
            max-width: none; /* Allow full width */
            box-shadow: none;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Cover the area, might crop */
            z-index: 1;
            filter: brightness(0.5); /* Darken image for text visibility */
        }

        .hero-content {
            position: relative;
            z-index: 2;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.3); /* Slight dark overlay for text */
            border-radius: 8px;
        }

        #hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        #hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }

        /* Call to Action Button */
        .cta-button {
            display: inline-block;
            background-color: #00aaff; /* Accent color */
            color: #fff;
            padding: 0.8rem 1.5rem;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .cta-button:hover {
            background-color: #0077cc; /* Darker accent */
        }

        /* About Section */
        #about p {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        /* Services Section */
        .service-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            text-align: center;
        }

        .service-item {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 5px;
            border: 1px solid #eee;
        }

        .service-item h3 {
            margin-bottom: 0.5rem;
            color: #00aaff;
        }

        /* Gallery Section */
        .gallery-notice {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #888;
            font-style: italic;
        }

        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .gallery-item img {
            width: 100%;
            height: 200px; /* Fixed height for consistency */
            object-fit: cover;
            border-radius: 5px;
            display: block;
            border: 1px solid #ddd;
        }

        .gallery-item p {
            text-align: center;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            color: #555;
        }

        /* Testimonials Section */
        .testimonial-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .testimonial {
            background: #f9f9f9;
            padding: 1.5rem;
            border-left: 5px solid #00aaff;
            border-radius: 5px;
        }

        .testimonial blockquote {
            font-style: italic;
            margin-bottom: 1rem;
            color: #555;
        }

        .testimonial cite {
            font-weight: bold;
            color: #333;
        }

        /* Contact Section */
        #contact-form {
            max-width: 600px;
            margin: 2rem auto 0 auto;
            background: #f9f9f9;
            padding: 2rem;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        .form-group textarea {
            resize: vertical; /* Allow vertical resizing */
        }

        #contact-form button {
            width: 100%;
            margin-top: 1rem;
        }

        .contact-info {
            text-align: center;
            margin-top: 2rem;
            font-size: 1.1rem;
        }

        .contact-info a {
            color: #00aaff;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }

        /* Form Success/Error Messages */
        .form-message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            text-align: center;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Footer */
        footer {
            background: #333;
            color: #aaa;
            text-align: center;
            padding: 2rem;
            margin-top: 2rem;
            font-size: 0.9rem;
        }

        footer p {
            margin-bottom: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                align-items: flex-start;
            }

            nav ul {
                margin-top: 1rem;
                flex-direction: column;
                width: 100%;
            }

            nav ul li {
                margin: 0.5rem 0;
                text-align: center;
                background: #444;
                padding: 0.5rem;
                border-radius: 4px;
            }

            #hero h1 {
                font-size: 2.2rem;
            }

            #hero p {
                font-size: 1rem;
            }

            section {
                padding: 3rem 1rem;
            }

            section h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">The Power Wash Guys</div>
            <ul>
                <li><a href="#hero">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#gallery">Gallery</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Hero Section -->
        <section id="hero">
            <!-- Placeholder Image from example site -->
            <!-- NOTE: Replace 'hero-image.jpg' with the actual downloaded filename if different -->
            <img src="hero-image.png" alt="Clean home exterior (Placeholder - Replace Me!)" class="hero-bg" />
            <div class="hero-content">
                <h1>Restore Your Property's Shine</h1>
                <p>Professional Power Washing for Homes & Businesses</p>
                <a href="#contact" class="cta-button">Get a Free Quote</a>
            </div>
        </section>

        <!-- About Section -->
        <section id="about">
            <h2>About The Power Wash Guys</h2>
            <p>
                We are your local experts in exterior cleaning. At The Power Wash
                Guys, we pride ourselves on delivering top-quality power washing
                services that enhance curb appeal and protect your investment. Using
                safe and effective techniques, we remove dirt, grime, mold, and
                mildew from various surfaces, leaving them looking brand new.
            </p>
            <!-- Optional: Add an image of your team or equipment here -->
        </section>

        <!-- Services Section -->
        <section id="services">
            <h2>Our Services</h2>
            <div class="service-container">
                <div class="service-item">
                    <!-- Placeholder icon/image needed -->
                    <h3>House Washing</h3>
                    <p>
                        Safely clean siding (vinyl, brick, stucco) removing algae and
                        dirt buildup.
                    </p>
                </div>
                <div class="service-item">
                    <!-- Placeholder icon/image needed -->
                    <h3>Driveway & Sidewalk Cleaning</h3>
                    <p>
                        Eliminate oil stains, tire marks, and grime for a welcoming
                        entrance.
                    </p>
                </div>
                <div class="service-item">
                    <!-- Placeholder icon/image needed -->
                    <h3>Deck & Patio Cleaning</h3>
                    <p>
                        Restore wood or composite decks and patios to their original
                        beauty.
                    </p>
                </div>
                <div class="service-item">
                    <!-- Placeholder icon/image needed -->
                    <h3>Fence Washing</h3>
                    <p>Bring back the life to your wood or vinyl fences.</p>
                </div>
                <div class="service-item">
                    <!-- Placeholder icon/image needed -->
                    <h3>Roof Cleaning (Soft Wash)</h3>
                    <p>
                        Gently remove black streaks (Gloeocapsa magma) and moss safely.
                    </p>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery">
            <h2>Before & After Gallery</h2>
            <p class="gallery-notice">
                <strong>Reminder:</strong> These are placeholder images. Replace them
                with your actual power washing work!
            </p>
            <div class="gallery-container">
                <div class="gallery-item">
                    <!-- NOTE: Replace 'portfolio-1.jpg' with the actual downloaded filename if different -->
                    <img src="Group-286-1.png" alt="Placeholder Image 1 - Replace Me" />
                    <p>Project Example 1 (Replace)</p>
                </div>
                <div class="gallery-item">
                    <!-- NOTE: Replace 'portfolio-2.jpg' with the actual downloaded filename if different -->
                    <img src="Group-286-1.png" alt="Placeholder Image 2 - Replace Me" />
                    <p>Project Example 2 (Replace)</p>
                </div>
                <div class="gallery-item">
                    <!-- NOTE: Replace 'portfolio-3.jpg' with the actual downloaded filename if different -->
                    <img src="Group-286-1.png" alt="Placeholder Image 3 - Replace Me" />
                    <p>Project Example 3 (Replace)</p>
                </div>
                <!-- Add more gallery items as needed -->
            </div>
        </section>

        <!-- Testimonials Section (Optional but Recommended) -->
        <section id="testimonials">
            <h2>What Our Customers Say</h2>
            <div class="testimonial-container">
                <div class="testimonial">
                    <blockquote>
                        "Our house looks brand new! The Power Wash Guys were professional,
                        efficient, and did an amazing job on our siding and driveway."
                    </blockquote>
                    <cite>- Jane D., Happy Homeowner</cite>
                </div>
                <div class="testimonial">
                    <blockquote>
                        "Highly recommend! They removed years of grime from our patio.
                        Great service and fair pricing."
                    </blockquote>
                    <cite>- Mark S., Satisfied Customer</cite>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact">
            <h2>Get Your Free Quote Today!</h2>
            <p>
                Fill out the form below or give us a call to discuss your power
                washing needs.
            </p>
            
            <?php if ($formSubmitted): ?>
                <!-- Success message shown after form submission -->
                <div class="form-message success-message">
                    <p>Thank you for your message! We will get back to you soon.</p>
                </div>
            <?php elseif ($formError): ?>
                <!-- Error message shown if form submission failed -->
                <div class="form-message error-message">
                    <p><?php echo $errorMessage; ?></p>
                </div>
            <?php endif; ?>
            
            <form id="contact-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>#contact">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" />
                </div>
                <div class="form-group">
                    <label for="service">Service Needed:</label>
                    <select id="service" name="service">
                        <option value="">--Select a Service--</option>
                        <option value="House Washing" <?php echo (isset($_POST['service']) && $_POST['service'] == 'House Washing') ? 'selected' : ''; ?>>House Washing</option>
                        <option value="Driveway/Sidewalk" <?php echo (isset($_POST['service']) && $_POST['service'] == 'Driveway/Sidewalk') ? 'selected' : ''; ?>>Driveway/Sidewalk</option>
                        <option value="Deck/Patio" <?php echo (isset($_POST['service']) && $_POST['service'] == 'Deck/Patio') ? 'selected' : ''; ?>>Deck/Patio</option>
                        <option value="Fence Washing" <?php echo (isset($_POST['service']) && $_POST['service'] == 'Fence Washing') ? 'selected' : ''; ?>>Fence Washing</option>
                        <option value="Roof Cleaning" <?php echo (isset($_POST['service']) && $_POST['service'] == 'Roof Cleaning') ? 'selected' : ''; ?>>Roof Cleaning</option>
                        <option value="Other" <?php echo (isset($_POST['service']) && $_POST['service'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="4" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>
                <button type="submit" class="cta-button">Send Request</button>
            </form>
            <p class="contact-info">
                Or call us at: <a href="tel:555-123-4567">555-123-4567</a>
                <!-- Replace with your actual phone number -->
            </p>
        </section>
    </main>

    <footer>
        <p>
            &copy; <span id="year"></span> The Power Wash Guys. All Rights
            Reserved. | Website by [Your Name/Company or leave blank]
        </p>
        <p>Serving [Your Service Area - e.g., Springfield & Surrounding Areas]</p>
    </footer>

    <script>
        // Smooth Scrolling for Navigation Links
        document.querySelectorAll('nav a[href^="#"]').forEach((anchor) => {
            anchor.addEventListener("click", function (e) {
                e.preventDefault(); // Prevent default jump

                const targetId = this.getAttribute("href");
                // Correctly select the target element even if the href is just "#"
                const targetElement =
                    targetId === "#" ? document.body : document.querySelector(targetId);

                if (targetElement) {
                    // Use scrollIntoView for specific elements, or scrollTo for top of page
                    if (targetId === "#" || targetId === "#hero") {
                        window.scrollTo({
                            top: 0,
                            behavior: "smooth",
                        });
                    } else {
                        // Calculate offset if header is sticky
                        const headerOffset =
                            document.querySelector("header")?.offsetHeight || 0;
                        const elementPosition =
                            targetElement.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = elementPosition - headerOffset - 20; // Extra 20px padding

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: "smooth",
                        });
                    }
                }
            });
        });

        // Set current year in footer
        const yearElement = document.getElementById("year");
        if (yearElement) {
            yearElement.textContent = new Date().getFullYear();
        }
    </script>
</body>
</html>
