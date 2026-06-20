<?php
/**
 * Block: KM Hero
 * Renders the hero section with name, bio, certifications and photo.
 */
?>
<section class="section-hero" id="section-hero" tabindex="0">
    <div class="container">
        <div class="hero-content">
            <h1>Hi, I'm Klevis</h1>
            <p>I'm an independent WordPress contractor with 16 years of experience in working in International Affairs &amp; Think Tanks, News Media &amp; Editorial, Digital &amp; Creative Agencies, Music &amp; Entertainment, Sports &amp; Recreation, NGOs &amp; Business Angel Networks, Industrial &amp; Engineering, Hospitality etc</p>
            <p>I build and architect at scale: WordPress multisite networks, headless implementations, Shopify and WooCommerce stores, custom CMS solutions, REST API integrations, and high-availability infrastructure built for real traffic. I work across the full stack, from pixel-perfect Figma-to-theme delivery to database optimization and server configuration.</p>
            <div class="hero-certifications">
                <a href="https://automattic.credential.net/58e1443e-0dd1-49c4-a179-e076628e5c9a#acc.hDNR4YMG" target="_blank">
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/advanced-wordpress-developer.png' ); ?>" alt="Klevis Miho Advanced Professional WordPress Developer" />
                </a>
                <a href="https://www.credly.com/badges/6d27f144-208c-49c4-ac35-897e71123812/public_url" target="_blank">
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/member/iaap-professional-member.png' ); ?>" width="200" height="200" alt="IAAP Professional Member">
                </a>
                <a href="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/member/accesstia-accessibility-fundamentials.pdf' ); ?>" target="_blank">
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/member/accesstia-accessibility.webp' ); ?>" width="200" height="200" alt="Accesstia Accessibility Fundamentals">
                </a>
            </div>
        </div>
        <div class="hero-image">
            <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/images/klevismiho.webp' ); ?>" alt="Klevis Miho" width="500" height="500">
        </div>
    </div>
</section>