{% extends "base/base.tpl" %}
{% block content %}

{# Vložení menu administrace #}
{% include "admin/menu.tpl" %}
	
		{% if posts is defined and posts is not empty %}
		
			{% for order, post in posts%}
				<div class="container message bg-light">
						<div class="row">
							<p class="lead col-lg-3 text-dark font-weight-normal">Název příspěvku: </p>
							<p class="lead col-lg-6 text-dark">{{post.title}}</p>
						</div>
						
						<div class="row">
							<p class="lead col-lg-3 text-dark font-weight-normal">Autor příspěvku: </p>
							<p class="lead col-lg-6 text-dark">{{post.authorName}}</p>
						</div>
						
						<div class="row">
							<p class="lead col-lg-3 text-dark font-weight-normal">Celkové hodnocení: </p>
							<p class="lead col-lg-6 text-dark">{% if post.average != 0 %}{{post.average|number_format(2)}}{% else %}Příspěvek není ohodnocen{% endif %}</p>
						</div>
						
						<br>
						
						<div class="row">
							<p class="lead col-lg-12 mx-auto font-weight-normal text-info">Recenzenti: </p>
						</div>
						
						{% if post.reviewers is defined and post.reviewers is not empty%}
							{% for o, rw in post.reviewers %}
							<div class="row">
								<p class="lead col-lg-2 offset-lg-1 text-dark font-weight-normal">Jméno: </p>
								<p class="lead col-lg-2 text-dark">{{rw.reviewerName}}</p>
								<p class="lead col-lg-3 text-dark">{% if rw.average != 0 %}Hodnocení: {{rw.average|number_format(2)}}{% else %} Recenzent ještě nehodnotil{% endif %}</p>								
								
								<form class="form-horizontal col-lg-4 text-right" role="form" method="POST" action="index.php?page=admin&part=posts">
									<input type="hidden" name="post-reviewer-remove-post" value="{{post.post}}">
									<button type="submit" name="post-reviewer-remove" value="{{rw.reviewer}}" id="post-dele" title="Odstranit recenzenta" class="btn btn-danger "><i class="fa fa-trash"></i> Odebrat recenzenta</button>
								</form>
							</div>
							{% endfor %}
						{% else %}
						<div class="row">
							<p class="lead col-lg-11 offset-lg-1 text-dark font-weight-normal">Tento příspěvek právě nemá recenzenty!</p>
						</div>
						{% endif %}
						
						<br>
						
						{% if reviewers is defined and reviewers is not empty%}
						<div class="row">
							<div class="col-lg-11 offset-lg-1">
									
								<form class="form-inline" role="form" method="POST" action="index.php?page=admin&part=posts">
								  <div class="form-group col-lg-2">
									<label for="staticEmail2" class="sr-only">Email</label>
									<input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Nový recenzent">
								  </div>
								  <div class="form-group mx-sm-3 col-lg-2">
									<label for="inputPassword2" class="sr-only">Password</label>			
									<select name="post-new-reviewer-select" class="form-control">
										{% for order,reviewer in reviewers %}
											<option value="{{reviewer.user}}">{{reviewer.name}}</option>
										{% endfor %}
									</select>
									
								  </div>
								
								  <div class="col-lg-7 pull-right text-right">
								  <button type="submit" name="posts-new-reviewer" value={{post.post}} class="btn btn-primary mb-2">Nový recenzent</button>
								  </div>
								</form>
								
							</div>
						</div>
						{% endif %}
						
						
						
						<hr>
				</div>
				{% endfor %}
		{% else %}		
		<div class="container">
			<div class="row text-center col-lg-4 mx-auto">
				<p class="lead">Nebyl nalezen žádný příspěvek!</p>
			</div>
		</div>
		{% endif %}

{% endblock%}

{% block pageCSS %}
		
{% endblock %}

{% block pageJS %}

{% endblock %}