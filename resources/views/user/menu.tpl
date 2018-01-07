<nav class="navbar navbar-expand-lg navbar-light bg-light" id="mainNav">
      <div class="container text-primary">
        <a class="navbar-brand js-scroll-trigger text-primary" href="index.php?page=user">{% if session.user.userName is defined%}{{session.user.userName}}{% else %}Uživatel{% endif %}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive2" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive2">
          <ul class="navbar-nav ml-auto">

			<li class="nav-item">
              <a class="nav-link js-scroll-trigger text-primary" href="index.php?page=user&part=posts">Příspěvky</a>
            </li>
            			
          </ul>
        </div>
      </div>
    </nav>
	
	<hr class="no-margin-top">