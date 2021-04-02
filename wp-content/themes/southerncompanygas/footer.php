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
		  <div class="footer-container pattern card-group">
	      <a class="card" href="/our-business/">
					<div class="card--featured">
						<img src="/assets/img/operations.png" />
					</div>
					<div class="card--content">
						<div class="hed">Our Business</div>
						<p>Our four natural gas utilities that deliver clean, safe, reliable and affordable natural gas to approximately 4.2 million customers.</p>
					</div>
				</a>
				<a class="card" href="/responsibility/">
					<div class="card--featured">
						<img src="/assets/img/assistance.png" />
					</div>
					<div class="card--content">
						<div class="hed">Responsibility</div>
						<p>We have been a catalyst for positive change in our communities for more than 160 years. That’s why we continue to give back with our time, talent and resources.</p>
					</div>
				</a>
				<a class="card" href="http://investor.southerncompany.com">
					<div class="card--featured">
						<img src="/assets/img/economies-of-scale.png" />
					</div>
					<div class="card--content">
						<div class="hed">Investors</div>
						<p>We’re committed to supporting and improving our communities and environment at the local level and beyond, while conducting business with honesty, integrity and fairness.</p>
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

		<style>
			.footer-container {
				justify-content: space-evenly;
			}
			#main:before {
				display: none;
			}
			.ham {
				top: unset;
			}
		</style>

		<script type="text/javascript">
		  var container = document.querySelector(".container")
		  var navbar = document.querySelector(".navbar")
		  var ham = document.querySelector(".ham")

		  function navigate(e){
		    e.preventDefault()
		    const section = e.target.dataset.id;
		    var element = document.getElementById(section);
		    toggleHamburger()

		    var offset = document.getElementById(section).offsetTop
		    var headerOffest = document.getElementById("intro").offsetTop
		    window.scrollTo(0, offset - headerOffest)
		  }

		  function toggleHamburger(e){
		    navbar.classList.toggle("showNav")
		    ham.classList.toggle("showClose")
		    container.classList.toggle("fixed-position")
		  }

		  ham.addEventListener("click", toggleHamburger)

		  var menuLinks = document.querySelectorAll(".menuLink")
		  for (var i=0; i < menuLinks.length; i++){
		    menuLinks[i].addEventListener("click", navigate)
		  }
		</script>
	</body>
</html>
