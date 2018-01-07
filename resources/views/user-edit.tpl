{% extends "base/base.tpl" %}
{% block content %}

<main class="Site-content">

	{# Vložení menu uživatle #}
	{% include "user/menu.tpl" %}

		
	<div class="container message">	
		<div class="row">
			<hr class="separator">
		</div>
	</div>
	
	{% if error is defined and error is not empty%}
	<div class="container message">	
		<div class="row">
			<div class="alert col-lg-8 mx-auto alert-danger" role="alert">
				<strong>Chyba!</strong> {{error}}
			</div>	
		</div>
	</div>
	{% endif %}
	
	{% if success is defined and success is not empty%}
	<div class="container message">	
		<div class="row">
			<div class="alert col-lg-8 mx-auto alert-success" role="alert">
				<strong>Úspěch!</strong> {{success}}
			</div>	
		</div>
	</div>
	{% endif %}
	
	<div class="container message">

		<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="index.php?page=user&part=edit&post={{post.post}}">
			<div class="row">
							
			  <div class="form-group col-lg-8 mx-auto">
				<h2 class="label label-primary text-primary">Název příspěvku:</h2>
				<input type="text" class="form-control" name="post-create-nazev" id="post-create-nazev" value="{{post.title}}" placeholder="Název příspěvku" required>
			  </div>
				
			</div>
		
			<div class="row">
							
				<div class="form-group col-lg-8 mx-auto">
					<h2 class="label label-primary text-primary">Text příspěvku:</h2>
					<textarea class="form-control" name="post-create-text" id="post-create-text" placeholder="Text příspěvku" rows="20"  required>{{post.text}}</textarea>
				</div> 
				
			</div>
			
			
		{% if files is defined and files != "empty" %}
			<div class="container message">
				<div class="row">
					  <div class="col-lg-8 mx-auto">
						<h2 class="label label-primary text-primary">
						Přilohy k příspěvku
						</h2>
						
							
						<ul class="list-group">
							{% for order, file in files%}
							<li class="list-group-item">
								<a href="upload/{{file.filename}}">{{file.filename}}</a>  
								
								<button type="submit" name="post-edit-file-remove" value="{{file.filename}}" id="post-edit-file-remove" title="Smazat přílohu" class="btn btn-danger pull-right">
										<i class="fa fa-trash"></i> smazat
								</button>
							 
							</li>
							
							{% endfor %}
						</ul>
					
					  </div>
				</div>
			</div>
		{% endif %}

		<br>
			
		<div class="container message">
			<div class="row">
							
				<div class="form-group col-lg-8 mx-auto">
					<h2 class="label label-primary text-primary">Nové řílohy:</h2>
					<input type="file" class="form-control-file" name="upload[]" id="upload[]" multiple>
				</div>
		</div>
				
				
				
			</div>
			
			<div class="row">
							
			  <div class="form-group col-lg-8 mx-auto">
				<button type="submit" name="post-edit" id="post-edit" class="btn btn-success pull-right">Změnit</button>
			  </div>
				
			</div>
		
		</form>
		
	</div>
</main>

{% endblock %}