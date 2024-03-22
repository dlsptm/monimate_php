<?php if (!isset($_SESSION['user'])) : ?>
			<footer class="text-center text-lg-start border mt-xl-5 pt-4">
				<div class="container p-4">
					<div class="row">
						<div class="col-lg-3 col-md-6 mb-4 mb-lg-0 d-flex align-items-center justify-content-center">
							<ul class="list-unstyled mb-4 d-flex flex-column align-items-center">
								<li class="mb-3">
									<a href="index?p=home/index" class="text-dark "><img src="assets/img/logo_light.png" alt="logo" width="130px"></a>
								</li>
								<li class="text-center">
									<a type="button" class="btn btn-floating btn-light btn-lg mb-2">
										<i class="fab fa-facebook-f"></i>
									</a>
									<a type="button" class="btn btn-floating btn-light btn-lg mb-2">
										<i class="fa-brands fa-x-twitter"></i>
									</a>
									<a type="button" class="btn btn-floating btn-light btn-lg mb-2">
										<i class="fa-brands fa-instagram"></i>
									</a>

								</li>
							</ul>

						</div>

						<div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
							<h5 class="text-uppercase mb-4">Assistance</h5>

							<ul class="list-unstyled">
								<li>
									<a href="index?p=home/contact" class="text-dark">Contact us</a>
								</li>
								<li>
									<a href="index?p=home/legal" class="text-dark">Mentions Légales</a>
								</li>
								<li>
									<a href="index?p=home/conditions" class="text-dark">Conditions d'utilisation</a>
								</li>
							</ul>
						</div>

						<div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
							<h5 class="text-uppercase mb-4">Carrière</h5>

							<ul class="list-unstyled">
								<li>
									<a href="#!" class="text-dark">Rejoignez-nous</a>
								</li>
							</ul>
						</div>

						<div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
							<h5 class="text-uppercase mb-4">S'inscrire à notre Newsletter</h5>

							<div class="form-outline form-dark mb-4">
								<label class="form-label" for="newsletter" name="newsletter">Adresse Email</label>
								<input type="email" id="newsletter" class="form-control"/>
							</div>

							<button type="submit" class="btn btn-outline-dark btn-block">S'inscrire</button>
						</div>
					</div>
				</div>

				<div class="text-center p-3">
					© 2024 Copyright:
					<a class="text-dark" href="#">Monimate</a>
				</div>
			</footer>
		<?php endif ?>
</body>
</html>