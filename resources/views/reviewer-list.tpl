{% extends "base/base.tpl" %}
{% block content %}

{# Vložení menu uživatle #}
{% include "reviewer/menu.tpl" %}

				{% for order, post in posts%}
				<div class="container message bg-light">
						<div class="row">
							<p class="lead col-lg-3 text-dark font-weight-normal">Název příspěvku: </p>
							<p class="lead col-lg-6 text-dark">{{post.title}}</p>
							
								<div class="form-horizontal col-lg-3 text-right">
									<a href="index.php?page=reviewer&part=detail&id={{post.review}}">
										<button type="submit" title="Recenzovat příspěvek" class="btn btn-primary">
											<i class="fa fa-star-half-full"></i> recenzovat
										</button>
									</a>
								</div>	
							
						</div>
						
						<div class="row">
							<p class="lead col-lg-3 text-dark font-weight-normal">Stav příspěvku: </p>
							<p class="lead col-lg-6 text-dark">
							
								{% if post.state == "approved"%}
									Příspěvek přijat a zvěřejněn
								{% elseif post.state == "rejected"%}
									Příspěvek odmítnut
								{% elseif post.state == "deleted" %}
									Příspěvek smazání
								{% elseif post.state == "review" %}
									Příspěvek v recenzním řízením
								{% else %}
									{{post.state}}
								{% endif %}
						
							</p>
						</div>
						
						<div class="row">
							<p class="lead col-lg-3 text-dark font-weight-normal">Celkové hodnocení: </p>
							<p class="lead col-lg-6 text-dark">{% if post.average != 0 %}{{post.average|number_format(2)}}{% else %}Příspěvek není ohodnocen{% endif %}</p>
						</div>
						
						<br>
						<hr>
				</div>
				{% endfor %}
	
{% endblock%}

{% block pageCSS %}
		
{% endblock %}

{% block pageJS %}

{% endblock %}