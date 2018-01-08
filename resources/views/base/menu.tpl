    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">Semetrální práce z předmětu KIV/WEB</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php?page=about">O konferenci</a>
            </li>
			<li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="index.php?page=content">Příspěvky</a>
            </li>
            {% if session.user.userID is not defined %}
				{# Zde patří odkazy pro nepřihlášeného uživatele  #}
				
				<li class="nav-item">
					<a class="nav-link js-scroll-trigger" href="index.php?page=login">Přihlášení</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link js-scroll-trigger" href="index.php?page=register">Registrace</a>
				</li>
			{% else %}
			
			  <li class="nav-item">
				  <a class="nav-link js-scroll-trigger" href="index.php?page=create">Napsat příspěvek</a>
			  </li>

			  <li class="nav-item">
				  <a class="nav-link js-scroll-trigger" href="index.php?page=user">Účet</a>
			  </li>	

			  {# Odkazy pro recenzenta #}
			  {% if session.user.accountType >= 1 %}
			  <li class="nav-item">
				  <a class="nav-link js-scroll-trigger" href="index.php?page=reviewer">Recenzent</a>
			  </li>
			  {% endif %}
			
			  {# Odkazy pro administrátora #}
			  {% if session.user.accountType == 2 %}
			  <li class="nav-item">
				  <a class="nav-link js-scroll-trigger" href="index.php?page=admin">Administrace</a>
			  </li>
			  {% endif%}
			  
			  {# Zde patří odkazy pro přihlášeného uživatele  #}
			  
			  <li class="nav-item">
				  <a class="nav-link js-scroll-trigger" href="index.php?page=logout">Odhlásit</a>
			  </li>
			  

			  
			{% endif %}
			
			
          </ul>
        </div>
      </div>
    </nav>