{% extends "base/base.tpl" %}
{% block content %}

{# Vložení menu administrace #}
{% include "admin/menu.tpl" %}

{% if users is defined and users is not empty%}

		<div class="container message">
				<div class="row">
					<p class="lead col-lg-2 text-dark font-weight-normal">Přezdívka:</p>
					<p class="lead col-lg-3 text-dark font-weight-normal">E-mail:</p>
					<p class="lead col-lg-2 text-dark font-weight-normal">Oprávnění:</p>
					<p class="lead col-lg-5 text-dark font-weight-normal text-right">Změna oprávnění:</p>				
				</div>
		</div>
	
	{% for order, user in users%}
		<div class="container message">
				<div class="row">
					<p class="lead col-lg-2">{{ user.name }}</p>
					<p class="lead col-lg-3">{{ user.email }}</p>
					{% if user.account == 0 %}<p class="lead col-lg-2">Autor</p>{% endif %}
					{% if user.account == 1 %}<p class="lead col-lg-2">Recenzent</p>{% endif %}
					{% if user.account == 2 %}<p class="lead col-lg-2">Administrátor</p>{% endif %}
					
					{% if user.user == session.user.userID or user.account == 2%}
					<div class="form-horizontal col-lg-5 text-right" role="form">
						<button type="submit" name="admin" id="admin" class="btn btn-danger " disabled><i class="fa fa-exclamation-triangle"></i> administrátor</button>
						<button type="submit" name="recenzent" id="recenzent" class="btn btn-warning " disabled><i class="fa fa-exclamation-triangle"></i> recenzent</button>
						<button type="submit" name="autor" id="autor" class="btn btn-info " disabled><i class="fa fa-exclamation-triangle"></i> autor</button>
					</div>
					{% else %}
					<form class="form-horizontal col-lg-5 text-right" role="form" method="POST" action="index.php?page=admin&part=users">
						<button type="submit" name="admin" value="{{user.user}}" id="admin" class="btn btn-danger "><i class="fa fa-exclamation-triangle"></i> administrátor</button>
						<button type="submit" name="recenzent" value="{{user.user}}" id="recenzent" class="btn btn-warning "><i class="fa fa-exclamation-triangle"></i> recenzent</button>
						<button type="submit" name="autor" value="{{user.user}}" id="autor" class="btn btn-info "><i class="fa fa-exclamation-triangle"></i> autor</button>
					</form>
					{% endif %}
				</div>
		</div>
	{% endfor%}
	
{% else %}
	<div class="container">
		<div class="row">
			<p class="lead">Nebyl nalezen žádný uživatel</p>
		</div>
	</div>
{% endif %}
	
{% endblock%}

{% block pageCSS %}
		
{% endblock %}

{% block pageJS %}

{% endblock %}