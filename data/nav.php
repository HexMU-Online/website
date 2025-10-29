<!-- Mobile Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-lg-none position-fixed w-100 top-0" style="z-index:1030;">
	<div class="container-fluid">
		<a class="navbar-brand p-0" href="https://hexmu.com">
			<img src="/data/images/hexmu_logo_inline.png" alt="HexMU Logo" height="40" class="d-inline-block align-text-top">
		</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
			<span class="navbar-toggler-icon"></span>
		</button>
	</div>
</nav>
<!-- Offcanvas Sidebar for Mobile -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
	<div class="offcanvas-header">
		<a class="navbar-brand" href="https://hexmu.com" id="mobileSidebarLabel">
			<img src="/data/images/hexmu_logo.png" alt="HexMU Logo" class="d-inline-block align-text-top mw-100 px-2">
		</a>
		<div class="text-center mt-2">
			<span class="badge online py-1 px-3">
				Loading...
			</span>
		</div>
	</div>
	<div class="offcanvas-body d-flex flex-column p-0" style="height:100%;">
		<nav class="nav flex-column flex-grow-1 mt-3">
			<a class="btn btn-download mb-4 mx-2" href="/download/">Download</a>
			<?php if ( isset( $_SESSION['user'] ) ) : ?>
				<div class="text-white text-center mx-2"><div class="icon-holder greet-icon"><?php include $_SERVER['DOCUMENT_ROOT'] . '/data/images/icons/hello.svg'; ?></div> Welcome, <a href="/dashboard/" title="Account Dashboard"><strong class="color-my-dark-accent"><?php echo htmlspecialchars( $_SESSION['user'] ); ?></strong></a>!</div>
			<?php endif; ?>
			<a class="nav-link mt-2" href="/"><i class="bi bi-house-door me-2"></i>Home</a>
			<a class="nav-link" href="/about/"><i class="bi bi-info-circle me-2"></i>About Server</a>
			<a class="nav-link" href="/ranking/"><i class="bi bi-bar-chart-line me-2"></i>Rankings</a>
			<?php if ( isset( $_SESSION['user'] ) ) : ?>
				<a class="nav-link" href="/dashboard/"><i class="bi bi-person-circle me-2"></i>My Account</a>
				<a class="nav-link" href="/logout/"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
			<?php else : ?>
				<a class="nav-link" href="/login/"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
				<a class="nav-link" href="/register/"><i class="bi bi-person-plus me-2"></i>Register</a>
			<?php endif; ?>
		</nav>
		<a class="nav-link mt-auto text-white d-flex align-items-center justify-content-center mx-2 my-3 discord" href="/discord/" target="_blank">
			<i class="bi bi-discord me-2" style="font-size:1.3em;"></i>
			Contact
		</a>
	</div>
</div>
<div class="col-lg-2 d-none d-lg-block bg-light sidebar position-fixed d-flex flex-column" style="width:220px;height:100vh;">
	<div class="flex-grow-1 d-flex flex-column" style="height:100%;">
		<div class="offcanvas-header">
			<a class="navbar-brand pb-2" href="https://hexmu.com">
				<img src="/data/images/hexmu_logo.png" alt="HexMU Logo" class="d-inline-block align-text-top mw-100 px-2">
			</a>
			<div class="text-center mt-2">
				<span class="badge online py-1 px-3">
					Loading...
				</span>
			</div>
		</div>
		<nav class="nav flex-column flex-grow-1 mt-3">
			<a class="btn btn-download mb-4 mx-2" href="/download/">Download</a>
			<?php if ( isset( $_SESSION['user'] ) ) : ?>
				<div class="text-white text-center mx-2"> <div class="icon-holder greet-icon"><?php include $_SERVER['DOCUMENT_ROOT'] . '/data/images/icons/hello.svg'; ?></div> Welcome, <a href="/dashboard/" title="Account Dashboard"><strong class="color-my-dark-accent"><?php echo htmlspecialchars( $_SESSION['user'] ); ?></strong></a>!</div>
			<?php endif; ?>
			<a class="nav-link mt-2" href="/"><i class="bi bi-house-door me-2"></i>Home</a>
			<a class="nav-link" href="/about/"><i class="bi bi-info-circle me-2"></i>About Server</a>
			<a class="nav-link" href="/ranking/"><i class="bi bi-bar-chart-line me-2"></i>Rankings</a>
      		<?php if ( isset( $_SESSION['user'] ) ) : ?>
				<a class="nav-link" href="/dashboard/"><i class="bi bi-person-circle me-2"></i>My Account</a>
				<a class="nav-link" href="/logout/"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
			<?php else : ?>
				<a class="nav-link" href="/login/"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a>
				<a class="nav-link" href="/register/"><i class="bi bi-person-plus me-2"></i>Register</a>
			<?php endif; ?>
		</nav>
		<a class="nav-link mt-auto text-white d-flex align-items-center justify-content-center mx-2 my-3 discord" href="/discord/" target="_blank">
			<i class="bi bi-discord me-2" style="font-size:1.3em;"></i>
			Contact
		</a>
	</div>
</div>