{% extends "base/base.tpl" %}
{% block content %}

{# Vložení menu uživatle #}
{% include "reviewer/menu.tpl" %}

	<div class="container">
		<div class="row text-center col-lg-4 mx-auto">
			<p class="lead">Vítej{% if session.user.userName is defined%}, {{session.user.userName}}!{% else %}!{% endif %}</p>
		</div>
	</div>
	
{% endblock%}

{% block pageCSS %}
		
{% endblock %}

{% block pageJS %}

{% endblock %}