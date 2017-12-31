{% extends "base/base.tpl" %}
{% block content %}

    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">

		  	{% if loginSuccess is defined %}
				<div class="alert alert-success" role="alert">
				  <strong>Úspěch!</strong> Přihlášení proběhlo úspěšně.
				</div>	
			{% endif %}
			
		  	{% if loginErrorMessage is defined %}
				<div class="alert alert-danger" role="alert">
				  <strong>Chyba přihlášení!</strong> {{loginErrorMessage}}
				</div>	
			{% endif %}			
		  
			<form class="form-horizontal" role="form" method="POST" action="index.php?page=login">
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-8">
						<h2>Přihlášení uživatele</h2>
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="name">Přezdívka</label>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-user"></i></div>
								<input type="text" name="name" class="form-control" id="name" {% if loginCacheUsername is defined %} value="{{loginCacheUsername}}" {% endif %}"
									   placeholder="Přezdívka" required autofocus>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-control-feedback">
								<span class="text-danger align-middle">
										{% if loginErrorUsername is defined %}
										<i class="fa fa-close"> {{ loginErrorUsername }}</i>
									{% endif %}
								</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="password">Heslo</label>
					</div>
					<div class="col-md-6">
						<div class="form-group has-danger">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
								<input type="password" name="password" class="form-control" id="password"
									   placeholder="heslo" required>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-control-feedback">
								<span class="text-danger align-middle">
										{% if loginErrorPassword is defined %}
										<i class="fa fa-close"> {{ loginErrorPassword }}</i>
									{% endif %}
								</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<button type="submit" name="login" id="login" class="btn btn-success "><i class="fa fa-play-circle"></i> Přihlásit se</button>
					</div>
				</div>
			</form>
			
          </div>
        </div>
      </div>
    </section>

{% endblock%}

{% block pageCSS %}
	<link href="resources/css/app-pages-register-login.css" rel="stylesheet">
{% endblock %}

{% block pageJS %}
{% endblock %}
