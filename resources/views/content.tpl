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
						
						<p class="lead">{{ post.text|length > 200 ? post.text|slice(0, 100) ~ '...' : post.text  }}</p>
						
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
	
	{% else %}
			<div class="container message">
			<div class="row">
			  <div class="col-lg-10 text-center mx-auto">
				<h2>Tato konference ještě neobsahuje žádné příspěvky!</h2>
			  </div>
			</div>
		  </div>
	{% endif%}
	
	
	  {% if stran is defined and stran is not empty %}
	  		<div class="container message">
			<div class="row">
			<div class="col-lg-4 text-center center mx-auto">
            <ul class="pagination pagination-lg text-center">
                {% if stran > 1 %}
                    {% for i in 1..stran %}
                        {% if loop.first %}
                            {% if currentPage != loop.index %}
                                <li class="page-item"><span class="page-link"><a href="index.php?page=content&part={{ i }}"> << </a></span></li>
                            {% endif %}
                            {% if currentPage > 1 %}
                                <li clss="page-item"><span class="page-link"><a href="index.php?page=content&part={{ currentPage-1 }}"> < </a></span></li>
                            {% endif %}
                        {% endif %}
                        {% if loop.index == currentPage %}
                            <li class="page-item active"><span class="page-link"><a href="index.php?page=content&part={{ i }}">{{ i }}</a></span></li>
                        {% else %}
							{% if loop.index == loop.last %}
                            <li class="page-item"><span class="page-link"><a href="index.php?page=content&part={{ i }}">{{ i }}</a></span></li>
							{% else %}
							<li class="page-item"><span class="page-link"><a href="index.php?page=content&part={{ i }}">{{ i }}</a></span></li>
							{% endif %}
						{% endif %}
                        {% if loop.last %}
                            {% if currentPage < loop.index %}
                                <li class="page-item"><span class="page-link"><a href="index.php?page=content&part={{ currentPage+1 }}">> </a></span></li>
                            {% endif %}
                            {% if currentPage != loop.index %}
                                <li class="page-item"><span class="page-link"><a href="index.php?page=content&part={{ i }}"> >> </a></span></li>
                            {% endif %}
                        {% endif %}
                    {% endfor %}
				{% else %}
					<li class="page-item active mx-auto"><span class="page-link"><a href="index.php?page=content&part=1">1</a></span></li>
				{% endif %}
            </ul>
			</div>
			</div>
			</div>
        {% endif %}
	
{% endblock%}

{% block pageCSS %}
	
	<link href="resources/css/app-page-content.css" rel="stylesheet">
	
	{% if posts is defined and posts is empty%}
		<link href="resources/css/app-page-error.css" rel="stylesheet">
	{% endif %}
	
	
	
{% endblock %}

{% block pageJS %}
{% endblock %}