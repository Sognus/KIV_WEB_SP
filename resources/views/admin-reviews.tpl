{% extends "base/base.tpl" %}
{% block content %}

{# Vložení menu administrace #}
{% include "admin/menu.tpl" %}
		
		{% if reviews is defined and reviews is not empty%}
			{% for order, review in reviews%}
		<div class="container message">
				<div class="row">
					<p class="lead col-lg-2 text-dark font-weight-normal">Příspěvek</p>
					<p class="lead col-lg-2 text-dark font-weight-normal">Autor</p>
					<p class="lead col-lg-2 text-dark font-weight-normal">Recenzent</p>
					<p class="lead col-lg-2 text-dark font-weight-normal">Hodnocení</p>
					<p class="lead col-lg-4 text-dark font-weight-normal text-right">Akce</p>				
				</div>
		</div>
			
				<div class="container message">
						<div class="row">
							<p class="lead col-lg-2">{{ review.title }}</p>
							<p class="lead col-lg-2">{{ review.authorName }}</p>
							<p class="lead col-lg-2">{{ review.reviewerName }}</p>
							<p class="lead col-lg-2">{{ review.average }}</p>
						
							<form class="form-horizontal col-lg-4 text-right" role="form" method="POST" action="index.php?page=admin&part=reviews">
								<button type="submit" name="review-delete" value="{{review.review}}" id="review-dele" title="Smazat recenzi" class="btn btn-danger "><i class="fa fa-trash"></i> Smazat recenzi</button>
							</form>
						</div>
				</div>
				
				<hr>
			{% endfor%}
		
		
		{% else %}		
		<div class="container">
			<div class="row text-center col-lg-4 mx-auto">
				<p class="lead">Nebyla nalezena žádná recenze!</p>
			</div>
		</div>
		{% endif %}

{% endblock%}

{% block pageCSS %}
		
{% endblock %}

{% block pageJS %}

{% endblock %}