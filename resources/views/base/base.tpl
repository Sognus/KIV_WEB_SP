{% set pageShort = "" %}

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content="Semestrální práce z KIV/WEB"/>
    <meta name="author" content="Jakub Vítek" />

    <title>Konference - Člověk a příroda</title>
    
    <link rel="icon" href="resources/images/icon.jpg" sizes="32x32" type="image/png">

    <!-- Bootstrap core CSS -->
    <link href="resources/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="resources/css/scrolling-nav.css" rel="stylesheet">

	<!-- Base CSS -->
	<link href="resources/css/app-base.css" rel="stylesheet">
	
	<!-- Font awesome icons -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
	
	{% block pageCSS %}
	{% endblock %}
	
	{% block pageSpecialCSS%}
	{%endblock %}
	
	{% block pageTopJS %}
	{% endblock %}

  </head>

  <body class="Site" id="page-top">

    <!-- Navigation -->
	<div class="Site-header">
		{% include "base/menu.tpl"%}

		<header class="bg-success text-white">
		  <div class="container text-center">
			<h1>Konference - Člověk a příroda</h1>
			<p class="lead align-self-center">
			</p>
		  </div>
		</header>
	</div>
	
	<main class="Site-content">
	{% block content %}
	{% endblock %}
	</main>
	
    <!-- Footer -->
    <footer id="footer" class="py-5 bg-dark fixed-absolute">
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
    
    <script type="text/javascript">
    var shortContent = function() {    
      if($(window).height() + $('#footer').height()  > $('body').height()) {
          $('#footer').addClass('Site-footer');
      }
      else
      {
          $('#footer').removeClass('Site-footer');
      }
    
    };
    
    (function(){
    
       shortContent();
    
       $(window).resize(function() {
        shortContent();
       });
    
    }());
    </script>
	
	{% block pageJS %}
	{% endblock %}

  </body>

</html>
