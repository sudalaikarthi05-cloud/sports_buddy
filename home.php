<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olympic Sports Hub | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/home.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-running me-2"></i>Olympic Sports Hub
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="sports.php">Matches</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>

        <!-- Login Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" role="button">
                Login
            </a>
            <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                <li><a class="dropdown-item  " href="index.php">User Login</a></li>
                <li><a class="dropdown-item" href="adminlogin.php">Admin Login</a></li>
            </ul>
        </li>
    </ul>
</div>
        </div>
    </nav>

    <!-- Carousel -->
    <section id="home">
        <div id="sportsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#sportsCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="carousel-caption text-center">
                        <h1 class="display-3 fw-bold mb-4">Experience the Olympic Spirit</h1>
                        <p class="lead mb-5">Join our community of athletes and sports enthusiasts dedicated to excellence.</p>
                        <a href="register.php" class="btn btn-olympic btn-lg px-5 py-3">Get Started</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-caption text-center">
                        <h1 class="display-3 fw-bold mb-4">Train Like a Champion</h1>
                        <p class="lead mb-5">World-class training facilities and coaching for all levels of games.</p>
                        <a href="sports.php" class="btn btn-olympic btn-lg px-5 py-3">Our Games</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="carousel-caption text-center">
                        <h1 class="display-3 fw-bold mb-4">Upcoming Sports Events</h1>
                        <p class="lead mb-5">Participate in local and distric competitions.</p>
                        <a href="#events" class="btn btn-olympic btn-lg px-5 py-3">View Calendar</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#sportsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#sportsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- Olympic Rings -->
    <div class="olympic-rings">
        <div class="ring"></div>
        <div class="ring"></div>
        <div class="ring"></div>
        <div class="ring"></div>
        <div class="ring"></div>
    </div>

    <!-- About Us Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="section-title">About  Sports Buddy</h2>
                        <p class="lead">"Sports Buddy is your go-to platform to connect with sports lovers, create matches, and play anytime, anywhere.
Whether you're a beginner or a pro, we make it easy to find your team and start playing." </p>
                        <p>Welcome to Sports Buddy – Your Ultimate Matchmaker for Sports!
We believe that sports are more fun when shared. Sports Buddy is a platform built for athletes, amateurs, and everyday sports lovers to connect, create, and compete. Whether you're looking to join a friendly cricket match, host a football game, or just find a local player for a badminton rally — Sports Buddy brings people together through the power of play.</p>
                        <p>"Sports Buddy connects players, builds teams, and makes every match happen – anytime, anywhere."</p>
                        <div class="row mt-5">
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-medal text-warning fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5>Champions Trained</h5>
                                        <p>200+ international medalists</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-user-graduate text-primary fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5>Experienced Coaches</h5>
                                        <p>50+ certified professionals</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-map-marker-alt text-danger fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5>Global Reach</h5>
                                        <p>10 training centers worldwide</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex">
                                    <div class="me-3">
                                        <i class="fas fa-trophy text-success fa-2x"></i>
                                    </div>
                                    <div>
                                        <h5>Competitions</h5>
                                        <p>100+ events annually</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-img">
                        <img src="./css/allequipments.jpg" alt="Sports Training" class="img-fluid">
                    </div>
                     
                </div>
            </div>
        </div>
    </section>

    <!-- Matches -->
    <section id="services" class="services-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Matches</h2>
                <p class="lead">Comprehensive sports programs for all ages and skill levels</p>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-running"></i>
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="card-title">Athletic Training</h4>
                            <p class="card-text">Professional coaching in track and field, cross country, and endurance sports with personalized training programs.</p>
                            <a href="Atheletic.html" class="btn btn-sm btn-outline-primary mt-3">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-swimmer"></i>
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="card-title">Swimming Programs</h4>
                            <p class="card-text">From beginner lessons to competitive swim training in Olympic-sized pools with certified instructors.</p>
                            <a href="Swimming.html" class="btn btn-sm btn-outline-warning mt-3">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-basketball-ball"></i>
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="card-title">Team Sports</h4>
                            <p class="card-text">Basketball, volleyball, soccer and more with professional coaches and competitive league play.</p>
                            <a href="TeamSports.html" class="btn btn-sm btn-outline-success mt-3">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <div class="card-body text-center p-4">
                            <h4 class="card-title">Strength & Conditioning</h4>
                            <p class="card-text">Sport-specific strength training, injury prevention, and performance enhancement programs.</p>
                            <a href="Strength.html" class="btn btn-sm btn-outline-danger mt-3">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h2 class="section-title mb-4">Contact Us</h2>
                    <p class="mb-4">Have questions about our programs or facilities? Reach out to our team for more information.</p>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-map-marker-alt fa-2x text-primary"></i>
                                </div>
                                <div>
                                    <h5>Location</h5>
                                    <p>Sports buddy<br>Rajapalayam,Tamilnadu</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-phone fa-2x text-success"></i>
                                </div>
                                <div>
                                    <h5>Phone</h5>
                                    <p>xxxxxxxx</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-envelope fa-2x text-danger"></i>
                                </div>
                                <div>
                                    <h5>Email</h5>
                                    <p>sportsbudddy@gmail.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="fas fa-clock fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <h5>Hours</h5>
                                    <p>Mon-Fri: 6am - 10pm<br>Sat-Sun: 7am - 8pm</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h5>Follow Us</h5>
                        <div class="social-icons mt-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form">
                        <h4 class="mb-4">Send us a message</h4>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control py-3" placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control py-3" placeholder="Email Address" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control py-3" placeholder="Phone Number">
                            </div>
                            <div class="mb-3">
                                <select class="form-select py-3">
                                    <option selected>Interested In</option>
                                    <option>cricket</option>
                                    <option>Football</option>
                                    <option>Volleyball</option>
                                    <option>Kabadi</option>
                                    <option>Basketball</option>
                                    <option>Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control py-3" rows="4" placeholder="Your Message" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-olympic w-100 py-3">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5>Olympic Sports Hub</h5>
                    <p class="mt-3">Dedicated to excellence in sports training and athlete development. Join our community to experience world-class facilities and coaching.</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Quick Links</h5>
                    <ul class="footer-links ps-0">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#events">Events</a></li>
                        <li><a href="#coaches">Coaches</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5>Our Programs</h5>
                    <ul class="footer-links ps-0">
                        <li><a href="#">Youth Sports</a></li>
                        <li><a href="#">Elite Training</a></li>
                        <li><a href="#">Adult Fitness</a></li>
                        <li><a href="#">Swimming</a></li>
                        <li><a href="#">Team Sports</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to receive updates on events, training tips, and special offers.</p>
                    <form class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-warning" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="copyright">
                <p class="mb-0">&copy; 2025  Sports Buddy All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add active class to nav items on scroll
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section');
            const navItems = document.querySelectorAll('.nav-link');
            
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if(scrollY >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });
            
            navItems.forEach(item => {
                item.classList.remove('active');
                if(item.getAttribute('href').substring(1) === current) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>