    <!-- Footer -->
    <footer>
        <div class="company-info" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="0">
            
            <?php dynamic_sidebar( 'footer-left-widget' ); ?>
            <!-- <h3>yoga class</h3>
            <p>Lorem ipsum dolor sit amet, consetteture adipiscing elit. Donec fringilla neque euismod volut-pat cursus. Alequam at dignissim nunc, id maximus ex. Etiam nec dignissim elit at dignissim enim</p> -->
        </div>
        <div class="navs">
                <?php dynamic_sidebar( 'footer-nav-widgets' ); ?>
            
            <div class="social-links" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="0">
                <ul>
                    <li>Follow Us</li>
                    <li><a href=""><i class="fab fa-facebook-f"></i>Facebook</a></li>
                    <li><a href=""><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href=""><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href=""><i class="fab fa-whatsapp"></i> Whatsap</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <?php wp_footer(); ?>

</body>
</html>