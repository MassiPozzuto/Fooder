<h1>Crear receta</h1>
<form method="POST">
    <div class="mb-3">
        <label for="formGroupTitulo" class="form-label">Titulo</label>
        <input name="nombre" type="text" class="form-control" id="formGroupTitulo" placeholder="Titulo" value="<?php echo $comida['nombre']; ?>">
    </div>
    <div class="mb-3">
        <label for="formGroupDescripcion" class="form-label">Descripcion</label>
        <textarea name="descripcion" class="form-control" id="formGroupDescripcion"><?php echo $comida['descripcion']; ?></textarea>
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
            <?php foreach ($paises as $pais) { ?>
                <option value="<?php echo $pais['id']; ?>" <?php echo ($pais['id'] == $comida['pais_id']) ? 'selected' : ''; ?>><?php echo $pais['pais']; ?></option>
            <?php } ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary mb-3">Guardar</button>
</form>