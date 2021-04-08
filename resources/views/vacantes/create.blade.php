@extends('layouts.app')

@section('navegacion')
	@include('ui.admin_nav')
@endsection

@section('styles')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/css/medium-editor.min.css" integrity="sha512-zYqhQjtcNMt8/h4RJallhYRev/et7+k/HDyry20li5fWSJYSExP9O07Ung28MUuXDneIFg0f2/U3HJZWsTNAiw==" crossorigin="anonymous" />

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous" />
@endsection

@section('content')
	<h1 class="text-2xl text-center mt-10">Nueva vacante</h1>

	<form class="max-w-lg mx-auto my-10">
		<div class="mb-5">
			<label for="titulo" class="block text-gray-700 text-sm mb-2">Titulo Vacante: </label>

			<input id="titulo" type="text" class="p-3 bg-gray-100 rounded form-input w-full @error('password') is-invalid @enderror" name="titulo">
		</div>

		<div class="mb-5">
			<label for="categoria" class="block text-gray-700 text-sm mb-2">Categoría</label>

			<select id="categoria" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full" name="categoria">
				<option disabled selected>- Selecciona -</option>

				@foreach ($categorias as $categoria)
					<option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
				@endforeach
			</select>
		</div>

		<div class="mb-5">
			<label for="experiencia" class="block text-gray-700 text-sm mb-2">Experiencia</label>

			<select id="experiencia" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full" name="experiencia">
				<option disabled selected>- Selecciona -</option>

				@foreach ($experiencias as $experiencia)
					<option value="{{ $experiencia->id }}">{{ $experiencia->nombre }}</option>
				@endforeach
			</select>
		</div>

		<div class="mb-5">
			<label for="ubicacion" class="block text-gray-700 text-sm mb-2">Ubicación</label>

			<select id="ubicacion" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full" name="ubicacion">
				<option disabled selected>- Selecciona -</option>

				@foreach ($ubicaciones as $ubicacion)
					<option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
				@endforeach
			</select>
		</div>

		<div class="mb-5">
			<label for="salario" class="block text-gray-700 text-sm mb-2">Salario</label>

			<select id="salario" class="block appearance-none w-full border border-gray-200 text-gray-700 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500 p-3 bg-gray-100 w-full" name="salario">
				<option disabled selected>- Selecciona -</option>

				@foreach ($salarios as $salario)
					<option value="{{ $salario->id }}">{{ $salario->nombre }}</option>
				@endforeach
			</select>
		</div>

		<div class="mb-5">
			<label for="descripcion" class="block text-gray-700 text-sm mb-2">Descripcion del puesto: </label>

			<div class="editable p-3 bg-gray-100 rounded form-input w-full text-gray-700"></div>

			<input type="hidden" name="descripcion" id="descripcion">
		</div>

		<div class="mb-5">
			<label for="descripcion" class="block text-gray-700 text-sm mb-2">Imagen del puesto: </label>

			<div id="dropzoneDev" class="dropzone rounded bg-gray-100"></div>

			<input type="hidden" name="imagen" id="imagen">

			<p id="error"></p>
		</div>


		<button type="submit" class="bg-teal-500 w-full hover:bg-teal-600 text-gray-100 font-bold p-3 focus:outline focus:shadow-outline uppercase">Publicar vacante
		</button>
	</form>

@endsection


@section('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.3/js/medium-editor.min.js" integrity="sha512-5D/0tAVbq1D3ZAzbxOnvpLt7Jl/n8m/YGASscHTNYsBvTcJnrYNiDIJm6We0RPJCpFJWowOPNz9ZJx7Ei+yFiA==" crossorigin="anonymous"></script>

	<!-- Dropzone -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous"></script>

	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', () => {

			//Medium Editor
			const editor = new MediumEditor('.editable', {
				toolbar: {
					buttons: ['bold', 'italic', 'underline', 'quote', 'anchor', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull', 'orderedList', 'unorderedList', 'h2', 'h3'],
					static: true,
					sticky: true

				},
				placeholder: {
					text: 'Información de la vacante'
				}
			});

			editor.subscribe('editableInput', function(eventObj, editable) {
				const contenido = editor.getContent();
				document.querySelector('#descripcion').value = contenido;
			})

			//Dropzone
			const dropzoneDev = new Dropzone('#dropzoneDev', {
				url: "/vacantes/imagen", 
				dictDefaultMessage: 'Sube aquí tu archivo',
				acceptedFiles: ".png,.jpg,.jpeg,.gif,.bmp",
				addRemoveLinks: true,
				dictRemoveFile: 'Borrar archivo',
				headers: {
					'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
				},
				success: function(file, response) {
					console.log(response.correcto);
					document.querySelector('#error').textContent = '';

					//coloca la respuesta del servidor en el input hidden
					document.querySelector('#imagen').value = response.correcto;

					//añadir el objeto de archivo el nombre del servidor
					file.nombreServidor = response.correcto
				},
				maxfilesexceed: function(file) {
					if( this.files[1] != null ) {
						this.removeFile(this.files[0]);//eliminar archivo anterior
						this.addFile(file);//agregar nuevo arhivo
					}
				},
				removedfile: function(file, response) {

					file.previewElement.parentNode.removeChild(file.previewElement);

					params = {
						imagen: file.nombreServidor
					}

					axios.post('/vacantes/borrarimagen', params ).then(respuesta => console.log(respuesta))
				}
			})
		})
	</script>
@endsection