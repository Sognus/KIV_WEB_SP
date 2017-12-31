{% extends "base/base.tpl" %}
{% block content %}

    <section id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
		
			{% if registerSuccess is defined %}
				<div class="alert alert-success" role="alert">
				  <strong>Úspěch!</strong> Registrace nového uživatele proběhla úspěšně.
				</div>	
			{% endif %}
		
			<form class="form-horizontal" role="form" method="POST" action="index.php?page=register">
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-8">
						<h2>Registrace nového uživatele</h2>
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
								<input type="text" name="name" class="form-control" id="name" {% if registerCacheUsername is defined %} value="{{registerCacheUsername}}" {% endif %}"
									   placeholder="Přezdívka" required autofocus>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-control-feedback">
								<span class="text-danger align-middle">
									{% if registerErrorUsername is defined %}
										<i class="fa fa-close"> {{ registerErrorUsername }}</i>
									{% endif %}
								</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="email">E-Mail adresa</label>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
								<input type="text" name="email" class="form-control" id="email"  {% if registerCacheEmail is defined %} value="{{registerCacheEmail}}" {% endif %}
									   placeholder="email@server.cz" required autofocus>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-control-feedback">
								<span class="text-danger align-middle">
									{% if registerErrorEmail is defined %}
										<i class="fa fa-close"> {{ registerErrorEmail }}</i>
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
									{% if registerErrorPassword is defined %}
										<i class="fa fa-close"> {{ registerErrorPassword }}</i>
									{% endif %}
								</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-3 field-label-responsive">
						<label for="password">Heslo znovu</label>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<div class="input-group mb-2 mr-sm-2 mb-sm-0">
								<div class="input-group-addon" style="width: 2.6rem">
									<i class="fa fa-repeat"></i>
								</div>
								<input type="password" name="passwordConfirm" class="form-control"
									   id="passwordConfirm" placeholder="heslo znovu" required>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-control-feedback">
								<span class="text-danger align-middle">
									{% if registerErrorConfirm is defined %}
										<i class="fa fa-close"> {{ registerErrorConfirm }}</i>
									{% endif %}
								</span>
						</div>
				</div>
				<div class="row">
					<div class="col-md-3"></div>
					<div class="col-md-6">
						<button id="register" name="register" type="submit" class="btn btn-success "><i class="fa fa-user-plus"></i> Register</button>
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
