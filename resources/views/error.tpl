<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Konference - Příroda ve městě</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="resources/css/scrolling-nav.css" rel="stylesheet">
	
	<!-- Page exclusive CSS -->
	<link href="resources/css/app-page-error.css" rel="stylesheet">

  </head>

  <body id="page-top">

    <!-- Navigation -->
	{% include "base/menu.tpl" %}
	
	<header class="bg-danger text-white">
      <div class="container text-center">
        <h1>
			{% if code is defined and message is defined%} {{code}} - {{message}} {% else%} A000 - Neznámá chyba aplikace {% endif %}
		</h1>
        <p class="lead align-self-center">
		</p>
      </div>
    </header>
	
    <!-- Footer -->
    <footer class="py-5 bg-dark fixed-absolute">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Jakub Vítek 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="resources/vendor/jquery/jquery.min.js"></script>
    <script src="resources/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="resources/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom JavaScript for this theme -->
    <script src="resources/js/scrolling-nav.js"></script>

  </body>

</html>
