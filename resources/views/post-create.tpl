{% extends "base/base.tpl" %}
{% block content %}

<main class="Site-content">
		
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

		<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="index.php?page=create">
			<div class="row">
							
			  <div class="form-group col-lg-8 mx-auto">
				<h2 class="label label-primary text-primary">Název nového příspěvku:</h2>
				<input type="text" class="form-control" name="post-create-nazev" id="post-create-nazev" placeholder="Název příspěvku" required>
			  </div>
				
			</div>
		
			<div class="row">
							
				<div class="form-group col-lg-8 mx-auto">
					<h2 class="label label-primary text-primary">Text příspěvku:</h2>
					<textarea class="form-control" name="post-create-text" id="post-create-text" placeholder="Text příspěvku" rows="20"  required></textarea>
				</div>
				
			</div>
			
			<div class="row">
							
				<div class="form-group col-lg-8 mx-auto">
					<h2 class="label label-primary text-primary">Přílohy:</h2>
					<input type="file" class="form-control-file" name="upload[]" id="upload[]" multiple>
				</div>
				
				
				
			</div>
			
			<div class="row">
							
			  <div class="form-group col-lg-8 mx-auto">
				<button type="submit" name="post-create" id="post-create" class="btn btn-success pull-right">Odeslat</button>
			  </div>
				
			</div>
		
		</form>
		
	</div>
</main>

{% endblock %}
