{% extends "base/base.tpl" %}
{% block content %}

{# Vložení menu uživatle #}
{% include "reviewer/menu.tpl" %}

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

			<div class="row">
							
			  <div class="form-group col-lg-8 mx-auto">
				<h2 class="label label-primary text-primary">Název příspěvku:</h2>
				<input type="text" class="form-control" value="{{post.title}}" placeholder="Název příspěvku" readonly>
			  </div>
				
			</div>
		
			<div class="row">
							
				<div class="form-group col-lg-8 mx-auto">
					<h2 class="label label-primary text-primary">Text příspěvku:</h2>
					<textarea class="form-control" placeholder="Text příspěvku" rows="20"  readonly>{{post.text}}</textarea>
				</div> 
				
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
								
							 
							</li>
							
							{% endfor %}
						</ul>
					
					  </div>
				</div>
			</div>
			
		{% endif %}

		<br>
	
<form method="POST" action="index.php?page=reviewer&part=detail&id={{review}}"	
	<div class="container message">

			<div class="row col-lg-8 mx-auto">
				<h2 class="label label-primary text-primary">Hodnocení:</h2>
			</div>
	
			<div class="row col-lg-8 mx-auto">
							
			  <div class="form-group">
				<label class="label">Originalita příspěvku:</label>
				
				<select class="form-control" name="review-originality" id="review-originality">
				  <option value=""  {% if reviewData.originality is not defined or reviewData.originality == "" %}selected{% endif %}>výběr známky</option>
				  <option value="1" {% if reviewData.originality is defined and reviewData.originality == 1 %}selected{% endif %}>1</option>
				  <option value="2" {% if reviewData.originality is defined and reviewData.originality == 2 %}selected{% endif %}>2</option>
				  <option value="3" {% if reviewData.originality is defined and reviewData.originality == 3 %}selected{% endif %}>3</option>
				  <option value="4" {% if reviewData.originality is defined and reviewData.originality == 4 %}selected{% endif %}>4</option>
				  <option value="5" {% if reviewData.originality is defined and reviewData.originality == 5 %}selected{% endif %}>5</option>
				</select>
				
			  </div>
				
			</div>
			
			<div class="row col-lg-8 mx-auto">
							
			  <div class="form-group">
				<label class="label">Téma příspěvku:</label>
				
				<select class="form-control" name="review-subject" id="review-subject">
				  <option value=""  {% if reviewData.subject is not defined or reviewData.subject == "" %}selected{% endif %}>výběr známky</option>
				  <option value="1" {% if reviewData.subject is defined and reviewData.subject == 1 %}selected{% endif %}>1</option>
				  <option value="2" {% if reviewData.subject is defined and reviewData.subject == 2 %}selected{% endif %}>2</option>
				  <option value="3" {% if reviewData.subject is defined and reviewData.subject == 3 %}selected{% endif %}>3</option>
				  <option value="4" {% if reviewData.subject is defined and reviewData.subject == 4 %}selected{% endif %}>4</option>
				  <option value="5" {% if reviewData.subject is defined and reviewData.subject == 5 %}selected{% endif %}>5</option>
				</select>
				
			  </div>
				
			</div>
			
			<div class="row col-lg-8 mx-auto">
							
			  <div class="form-group">
				<label class="label">Technická stránka příspěvku:</label>
				
				<select class="form-control" name="review-technical" id="review-technical">
				  <option value=""  {% if reviewData.technical is not defined or reviewData.technical == "" %}selected{% endif %}>výběr známky</option>
				  <option value="1" {% if reviewData.technical is defined and reviewData.technical == 1 %}selected{% endif %}>1</option>
				  <option value="2" {% if reviewData.technical is defined and reviewData.technical == 2 %}selected{% endif %}>2</option>
				  <option value="3" {% if reviewData.technical is defined and reviewData.technical == 3 %}selected{% endif %}>3</option>
				  <option value="4" {% if reviewData.technical is defined and reviewData.technical == 4 %}selected{% endif %}>4</option>
				  <option value="5" {% if reviewData.technical is defined and reviewData.technical == 5 %}selected{% endif %}>5</option>>
				</select>
				
			  </div>
				
			</div>
			
			<div class="row col-lg-8 mx-auto">
							
			  <div class="form-group">
				<label class="label">Jazyk příspěvku:</label>
				
				<select class="form-control" name="review-language" id="review-language">
				  <option value=""  {% if reviewData.language is not defined or reviewData.language == "" %}selected{% endif %}>výběr známky</option>
				  <option value="1" {% if reviewData.language is defined and reviewData.language == 1 %}selected{% endif %}>1</option>
				  <option value="2" {% if reviewData.language is defined and reviewData.language == 2 %}selected{% endif %}>2</option>
				  <option value="3" {% if reviewData.language is defined and reviewData.language == 3 %}selected{% endif %}>3</option>
				  <option value="4" {% if reviewData.language is defined and reviewData.language == 4 %}selected{% endif %}>4</option>
				  <option value="5" {% if reviewData.language is defined and reviewData.language == 5 %}selected{% endif %}>5</option>
				</select>
				
			  </div>
				
			</div>
			
			<div class="row col-lg-8 mx-auto">
							
			  <div class="form-group">

			    <button type="submit" name="review-confirm" class="btn btn-primary">Oznámkuj</button>
			  
			  </div>
				
			</div>
		
		
	</div>
</form>
	
{% endblock%}

{% block pageCSS %}
		
{% endblock %}

{% block pageJS %}

{% endblock %}