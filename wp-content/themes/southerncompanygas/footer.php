<?php
/**
 * The footer template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
						<?php do_action( 'avada_after_main_content' ); ?>

					</div>  <!-- fusion-row -->
				</main>  <!-- #main -->

				<div id="footer-links">
		  <div class="footer-container card-group">
	      <a class="card card--micro" href="/our-business/">
					<div class="card--featured"></div>
					<div class="card--content">
						<div class="hed">Our Business</div>
					</div>
				</a>
				<a class="card card--micro" href="/responsibility/">
					<div class="card--featured"></div>
					<div class="card--content">
						<div class="hed">Responsibility</div>
					</div>
				</a>
				<a class="card card--micro" href="/investors/">
					<div class="card--featured"></div>
					<div class="card--content">
						<div class="hed">Investors</div>
					</div>
				</a>
		  </div>
		</div>

		<div id="footer-info">
		  <div class="footer-container">
		    <div class="footer-column">
		      <a href="/"><img class="image-logo" src="/assets/img/soco-gas-inverted-horiztonal-@2x.png" /></a>
		      <p>©2020 Southern Company. Use constitutes acceptance of General Website</p>
		      <p>
		        <a href="https://www.southerncompany.com/terms-and-conditions.html">Terms and Conditions</a>
		        <a href="https://www.southerncompany.com/privacy-statement.html">Privacy Policy</a>
		      </p>
		    </div>
		    <div class="footer-column">
		      <p class="hed">Get in touch</p>
		      <p>
		        P.O. Box 4569<br/>
		        Atlanta, GA 30302<br/>
		        404.584.4000
		      </p>
		    </div>
		    <div class="footer-column">
		      <ul>
		        <li><p class="hed">Connect with us</p></li>
		        <li><a href="/careers/">Careers</a></li>
		        <li><a href="https://www.facebook.com/SouthernCoGas">Facebook</a></li>
		        <li><a href="https://twitter.com/SouthernCoGas">Twitter</a></li>
		        <li><a href="https://www.linkedin.com/company/southern-company-gas/">LinkedIn</a></li>
		      </ul>
		    </div>
		    <div class="footer-column">
		      <p class="hed">Media</p>
		      <ul>
		        <li><a href="/resources/">Fact Sheets and Brochures</a></li>
		        <li><a href="/media/media-contacts/">Media Contacts</a></li>
		      </ul>
		    </div>
		  </div>
		</div>

		<div class="avada-footer-scripts">
			<?php wp_footer(); ?>
		</div>
	</body>
</html>
