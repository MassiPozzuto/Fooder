<h1>Crear receta</h1>
<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="formGroupTitulo" class="form-label">Titulo</label>
        <input name="nombre" type="text" class="form-control" id="formGroupTitulo" placeholder="Titulo">
    </div>
    <div class="mb-3">
        <label for="formGroupDescripcion" class="form-label">Descripcion</label>
        <textarea name="descripcion" class="form-control" id="formGroupDescripcion" placeholder="Another input placeholder"></textarea>
    </div>
    <div class="mb-3">
        <label for="formGroupCategoria" class="form-label">Categorias</label>
        <select name="categoria_id" class="form-select" id="formGroupCategoria">
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="formGroupPais" class="form-label">Paises</label>
        <select name="pais_id" class="form-select" id="formGroupPais">
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="principal_img" class="form-label">Subir img principal</label>
        <input class="form-control" type="file" name="principal_img" id="principal_img">
    </div>
    <div class="mb-3">
        <label for="principal_sec" class="form-label">Subir img secundaria</label>
        <input class="form-control" type="file" name="principal_sec" id="principal_sec">
    </div>
    <button type="submit" class="btn btn-primary mb-3">Guardar</button>
</form>