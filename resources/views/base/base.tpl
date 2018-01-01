{% set pageShort = "" %}

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Konference - Člověk a příroda</title>

    <!-- Bootstrap core CSS -->
    <link href="resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="resources/css/scrolling-nav.css" rel="stylesheet">
	
	<!-- Font awesome icons -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	
	{% block pageCSS %}
	{% endblock %}
	
	{% block pageSpecialCSS%}
	{%endblock %}

  </head>

  <body id="page-top">

    <!-- Navigation -->
	{% include "base/menu.tpl"%}

    <header class="bg-success text-white">
      <div class="container text-center">
        <h1>Konference - Člověk a příroda</h1>
        <p class="lead align-self-center">
		</p>
      </div>
    </header>
	
	{% block content %}
	{% endblock %}
	
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
	
	{% block pageJS %}
	{% endblock %}

  </body>

</html>
