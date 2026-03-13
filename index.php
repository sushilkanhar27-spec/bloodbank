<?php
session_start();
$conn = new mysqli("localhost", "root", "password", "bloodbank", 3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalUsers = $row['total'];

if (isset($_POST['submit_review'])) {

    if (!isset($_SESSION['user_email'])) {
        echo "<script>alert('Please login first');</script>";
    } else {

        $user_id = $_SESSION['user_id'];
        $email   = $_SESSION['user_email'];
        $review  = $conn->real_escape_string($_POST['review_text']);

        $sql = "INSERT INTO reviews (user_id, email, review_text)
                VALUES ('$user_id', '$email', '$review')";

        if ($conn->query($sql)) {
            echo "<script>alert('Review Added Successfully');</script>";
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Angels - Donate Blood, Save Lives</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <!-- Header -->
    <header>
        <nav>
            <div class="logo">
                <i class="fas fa-heartbeat"></i>
                <h3 data-translate="title">Blood Link</h3>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#process">How it Works</a></li>
                <li><a href="#benefits">Benefits</a></li>
                <li><a href="#faq">FAQ</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <button class="login-btn"><a href="registration.php" class="btn register">Register Now</a></button>
            <button class="login-btn"><a href="loginpage.php" class="btn login">Login</a></button>
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Donate Blood, Save Lives.</h1>
            <p>Your single donation can save up to three lives. Join thousands of heroes who make a difference every day
                through blood donation.</p>

            <div class="hero-features">
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>Safe and Professional Process</span>
                </div>
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>Free Health Checkup Included</span>
                </div>
                <div>
                    <i class="fas fa-check-circle"></i>
                    <span>Make a Difference Today</span>
                </div>
            </div>

            <div style="display:flex; gap:15px; margin-top:20px;">
                <a href="donate.html"
                    style="display:inline-block; padding:14px 28px; border-radius:30px; border:none; background:#e53935; color:#fff; text-decoration:none; cursor:pointer;"
                    data-translate="donateBtn">Donate Blood Today</a>

                <a href="findblood.php"
                    style="display:inline-block; padding:14px 28px; border-radius:30px; border:none; background:#2e7d32; color:#fff; text-decoration:none;"
                    data-translate="findBtn">Find Blood</a>

            </div>

        </div>
        <div class="hero-image">
            <img src="https://images.unsplash.com/photo-1615461066841-6116e61058f4?w=800&q=80" alt="Blood Donation">
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stat-card">
            <h2 id="donatedCount">0</h2>
            <p>Lives Donated</p>
        </div>
        <div class="stat-card">
            <h2 id="savedCount">0</h2>
            <p>Lives Saved</p>
        </div>

        <div class="stat-card">
            <h2><?php echo $totalUsers; ?></h2>
            <p>Registered Donors</p>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="process">
        <h2 class="section-title">How It Works?</h2>
        <p style="text-align: center; max-width: 700px; margin: 0 auto 3rem; color: #666; font-size: 1.1rem;">
            Just 4 Simple Steps to Help Save a Life
        </p>
        <div class="steps">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Fill the Form</h3>
                <p>Complete our simple registration form with your basic information and medical history.</p>
            </div>
            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Get Verified</h3>
                <p>Our medical team will review your information and verify your eligibility to donate.</p>
            </div>
            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Get Notified</h3>
                <p>Receive notification when your blood type is needed or for scheduled donation appointments.</p>
            </div>
            <div class="step-card">
                <div class="step-number">4</div>
                <h3>Save a Life</h3>
                <p>Visit our center and donate blood. The entire process takes less than an hour.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <h2 class="section-title">Voices from Our Heroes</h2>
        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Donating blood has been one of the most rewarding experiences. Knowing that
                    my donation could save lives makes me feel like a real hero."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">AM</div>
                    <div class="author-info">
                        <h4>Anjali Mallick</h4>
                        <p>Regular Donor</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"The staff is professional and caring. The process was quick and painless. I
                    highly recommend everyone to donate blood."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">SS</div>
                    <div class="author-info">
                        <h4>Suneli Sethi</h4>
                        <p>First Time Donor</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"I've been donating for 5 years now. It's amazing how something so simple
                    can have such a huge impact on someone's life."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">SP</div>
                    <div class="author-info">
                        <h4>Sarita Panda</h4>
                        <p>Veteran Donor</p>
                    </div>
                </div>
            </div>
            <!-- // Display reviews from database -->
            <?php
            $sql = "SELECT reviews.review_text, name
        FROM reviews
        JOIN users ON reviews.user_id = users.id
        ORDER BY reviews.created_at DESC";

            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="testimonial-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>

                    <p class="testimonial-text">
                        "<?php echo $row['review_text']; ?>"
                    </p>

                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <?php echo strtoupper(substr($row['name'], 0, 2)); ?>
                        </div>
                        <div class="author-info">
                            <h4><?php echo $row['name']; ?></h4>
                            <p>Blood Donor</p>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>

            <div class="testimonial-card">

                <section class="review-section">
                    <h2>Share Your Experience</h2>

                    <form method="POST" action="">
                        <textarea name="review_text" required placeholder="Write your review here..."></textarea>
                        <br><br>
                        <button type="submit" name="submit_review">Submit Review</button>
                    </form>
                </section>

            </div>
    </section>

    <!-- Benefits -->
    <section class="benefits" id="benefits">
        <h2 class="section-title">Benefits of Donating Blood</h2>
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="benefit-content">
                    <h3>Health Boosts</h3>
                    <ul class="benefit-list">
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Free health screening and blood tests before donation</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Reduces risk of heart disease by maintaining iron levels</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Stimulates production of new blood cells</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Burns calories and promotes overall health</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon">
                    <i class="fas fa-smile"></i>
                </div>
                <div class="benefit-content">
                    <h3>Emotional Uplift</h3>
                    <ul class="benefit-list">
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Feel good knowing you've helped save lives</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Boost mental wellbeing through altruistic action</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Connect with a community of caring individuals</span>
                        </li>
                        <li>
                            <i class="fas fa-check"></i>
                            <span>Create a positive impact on society</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq" id="faq">
        <h2 class="section-title">FAQs</h2>
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Q1. Who is eligible to donate blood?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Generally, healthy individuals aged 18-65, weighing at least 50kg, can donate blood. You should not
                    have any infections, chronic diseases, or recent tattoos/piercings (within 6 months).
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Q2. How often can I donate blood?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    You can donate whole blood every 8-12 weeks (2-3 months). This allows your body enough time to
                    replenish the donated blood cells.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Q3. Does donating blood hurt?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    You may feel a slight pinch when the needle is inserted, but the process is generally painless. Most
                    donors report feeling fine during and after donation.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Q4. How long does the donation process take?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    The entire process, including registration, screening, and donation, typically takes 45-60 minutes.
                    The actual blood collection takes only about 10-15 minutes.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Q5. What should I do before donating?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    Eat a healthy meal, drink plenty of water, avoid fatty foods, and get a good night's sleep before
                    donating. Bring a valid ID and list of any medications you're taking.
                </div>
            </div>
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <span>Q6. Can I donate if I have a cold or flu?</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    No, you should wait until you're fully recovered and feeling well. Being sick can affect your
                    ability to donate safely and may compromise the quality of your donation.
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <h2>Get Free Your Life By This Project!</h2>
        <p>Ready to make a difference? Join our community of lifesavers today.</p>
        <button class="cta-btn">Contact Us Now</button>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-section">
                <h3><i class="fas fa-heartbeat" data-translate="title"></i> Blood Link</h3>
                <p>Connecting donors with those in need. Every donation counts, every donor matters.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/suman.kumar.669087/"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/sumankumar_27/"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#process">How It Works</a></li>
                    <li><a href="#benefits">Benefits</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="#faq">FAQ</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Info</h3>
                <ul>
                    <li><i class="fas fa-phone"></i> +91- 77355 75832</li>
                    <li><i class="fas fa-envelope"></i> sushilkanhar27@gmail.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Govt.Polytechnic college Phulbani, 762001</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 Blood Link. All rights reserved. | Designed with <i class="fas fa-heart"></i> for humanity
            </p>
        </div>
    </footer>

    <script>
        function toggleFaq(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('i');

            // Close all other FAQs
            document.querySelectorAll('.faq-answer').forEach(item => {
                if (item !== answer) {
                    item.classList.remove('active');
                }
            });

            document.querySelectorAll('.faq-question i').forEach(item => {
                if (item !== icon) {
                    item.style.transform = 'rotate(0deg)';
                }
            });

            // Toggle current FAQ
            answer.classList.toggle('active');
            if (answer.classList.contains('active')) {
                icon.style.transform = 'rotate(180deg)';
            } else {
                icon.style.transform = 'rotate(0deg)';
            }
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll effect to header
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.boxShadow = '0 5px 20px rgba(0,0,0,0.15)';
            } else {
                header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
        });

        // Animate stats on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = 1; // Add any other styles you need
                }
            });
        }, observerOptions);
        document.querySelectorAll('.stat-card').forEach(card => {
            observer.observe(card);
        });
        // Update stats from localStorage
        function updateCounters() {

            let donated = Number(localStorage.getItem("donated")) || 0;
            let saved = Number(localStorage.getItem("saved")) || 0;
            let users = JSON.parse(localStorage.getItem("users")) || [];

            document.getElementById("donatedCount").innerText = donated;
            document.getElementById("savedCount").innerText = saved;
            document.getElementById("registeredCount").innerText = users.length;
        }

        updateCounters();
        // Add review functionality
        function addReview() {
            let review = prompt("Write your review:");
            if (review) {
                let div = document.createElement("p");
                div.innerText = review;
                document.getElementById("userReview").appendChild(div);
            }
        }
        //Add translation functionality
        const translations = {

            en: {
                title: "Blood Link",
                donateBtn: "Donate Blood Today",
                findBtn: "Find Blood",
                welcome: "Welcome to Blood Link"
            },

            hi: {
                title: "ब्लड लिंक",
                donateBtn: "आज रक्त दान करें",
                findBtn: "रक्त खोजें",
                welcome: "ब्लड लिंक में आपका स्वागत है"
            },

            od: {
                title: "ବ୍ଲଡ୍ ଲିଙ୍କ",
                donateBtn: "ଆଜି ରକ୍ତ ଦାନ କରନ୍ତୁ",
                findBtn: "ରକ୍ତ ଖୋଜନ୍ତୁ",
                welcome: "ବ୍ଲଡ୍ ଲିଙ୍କ କୁ ସ୍ୱାଗତ"
            }

        };
        //Language change function
        function changeLanguage(lang) {

            localStorage.setItem("language", lang);

            document.querySelectorAll("[data-translate]").forEach(element => {
                const key = element.getAttribute("data-translate");
                element.innerText = translations[lang][key];
            });
        }
        // load language automatically on page load
        function loadLanguage() {
            let savedLang = localStorage.getItem("language") || "en";

            document.querySelectorAll("[data-translate]").forEach(element => {
                const key = element.getAttribute("data-translate");
                element.innerText = translations[savedLang][key];
            });
        }
        loadLanguage();
    </script>
</body>
</html>