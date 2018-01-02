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
					<p class="lead col-lg-5 text-dark font-weight-normal text-right">Akce:</p>				
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
						<button type="submit" name="user-ban" value="{{user.user}}" title="Zablokovat uživatele"  id="autor" class="btn btn-danger "  disabled><i class="fa fa-ban"></i> </button>
						<button type="submit" name="user-delete" value="{{user.user}}" title="Smazat uživatele" id="autor" class="btn btn-danger " disabled><i class="fa fa-trash-o"></i> </button>
					</div>
					{% else %}
					<form class="form-horizontal col-lg-5 text-right" role="form" method="POST" action="index.php?page=admin&part=users">
						<button type="submit" name="admin" value="{{user.user}}" id="admin" class="btn btn-danger "><i class="fa fa-exclamation-triangle"></i> administrátor</button>
						<button type="submit" name="recenzent" value="{{user.user}}" id="recenzent" class="btn btn-warning "><i class="fa fa-exclamation-triangle"></i> recenzent</button>
						<button type="submit" name="autor" value="{{user.user}}" id="autor" class="btn btn-info "><i class="fa fa-exclamation-triangle"></i> autor</button>
						
						{% if user.banned == true %}
						<button type="submit" name="user-unban" value="{{user.user}}" title="Odblokovat uživatele" id="autor" class="btn btn-success "><i class="fa fa-check-circle-o"></i> </button>
						{% else%}
						<button type="submit" name="user-ban" value="{{user.user}}" title="Zablokovat uživatele" id="autor" class="btn btn-danger "><i class="fa fa-ban"></i> </button>
						{% endif %}
						
						<button type="submit" name="user-delete" value="{{user.user}}" title="Smazat uživatele" id="autor" class="btn btn-danger "><i class="fa fa-trash-o"></i> </button>
					</form>
					
					{% endif %}
					
					
				</div>
				
		</div>
		
		<hr>
	{% endfor%}
	
{% else %}
	<div class="container">
		<div class="row text-center col-lg-4 mx-auto">
			<p class="lead">Nebyl nalezen žádný uživatel</p>
		</div>
	</div>
{% endif %}
	
{% endblock%}

{% block pageCSS %}
		
{% endblock %}

{% block pageJS %}

{% endblock %}