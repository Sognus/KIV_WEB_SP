{% extends "base/base.tpl" %}
{% block content %}


	{% if posts is defined %}
		
		{% if posts is empty %}
			<div class="container message">
				<div class="row">
					<div class="col-lg-10 text-center mx-auto">
						<h2>Tolik příspěvků zde není!</h2>
					</div>
				</div>
			</div>
			
		{% else %}
		
		{% for order,post in posts%}
			<div class="container message">
				<div class="row">
					  <div class="col-lg-8 mx-auto">
						<h2>
							<a href="index.php?page=post&id={{post.post}}">{{post.title}}</a>
						</h2>
						
						<p class="lead">{{ post.text }}</p>
						
						<div class="row">
							<div class="col-lg-6">Autor: {{ post.user.getNickname() }} </div>
							<div class="col-lg-6">Datum publikace: {{post.published}}</div>
						</div>
					
					  </div>
				</div>
			</div>
			
			<div class="container message">	
				<div class="row">
					<hr class="separator">
				</div>
			</div>
			
		{% endfor %}	
		{% endif %}
		
		{% if files is defined and files != "empty" %}
			<div class="container message">
				<div class="row">
					  <div class="col-lg-8 mx-auto">
						<h2>
							Přilohy k příspěvku
						</h2>
						
							
						<ul class="list-group">
							{% for order, file in files%}
							<li class="list-group-item"><a href="upload/{{file.filename}}">{{file.filename}}</a></li>
							{% endfor %}
						</ul>
					
					  </div>
				</div>
			</div>
		{% endif %}
	
	{% else %}
			<div class="container message">
			<div class="row">
			  <div class="col-lg-10 text-center mx-auto">
				<h2>Příspěvek, který se pokoušíte zobrazit, neexistuje!</h2>
				
			  </div>
			</div>
		  </div>
	{% endif %}
	
{% endblock%}

{% block pageCSS %}
	
	<link href="resources/css/app-page-content.css" rel="stylesheet">
	
	{% if pageShort is defined and pageShort == "yes" %}
		<link href="resources/css/app-page-error.css" rel="stylesheet">
	{% endif %}
		
{% endblock %}

{% block pageJS %}
{% endblock %}