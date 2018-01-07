{% extends "base/base.tpl" %}
{% block content %}

{# Vložení menu uživatle #}
{% include "user/menu.tpl" %}

				{% for order, post in posts%}
				<div class="container message bg-light">
						<div class="row">
							<p class="lead col-lg-3 text-dark font-weight-normal">Název příspěvku: </p>
							<p class="lead col-lg-6 text-dark">{{post.title}}</p>
							
							{% if post.deleted != "1" %}
								<form class="form-horizontal col-lg-3 text-right" role="form" method="POST" action="index.php?page=user&part=posts">
									<button type="submit" name="post-delete-user" value="{{post.post}}" id="post-delete-user" title="Odmítnout příspěvek" class="btn btn-danger"><i class="fa fa-trash"></i> smazat</button>
								</form>
							{% else %}
								<div class="col-lg-3 text-right">
									<button type="submit" name="post-delete-user" id="post-delete-user" title="Odmítnout příspěvek" class="btn btn-danger" disabled><i class="fa fa-trash"></i> smazat</button>
								</div>
							{% endif %}
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
								{% else %}
									{{post.state}}
								{% endif %}
							
								<div class="form-horizontal col-lg-3 text-right">
									<a href="index.php?page=user&part=edit&post={{post.post}}">
										<button type="submit" name="post-edit-user" id="post-edit-user" title="Odmítnout příspěvek" class="btn btn-primary">
											<i class="fa fa-trash"></i> editovat
										</button>
									</a>
								</div>						
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