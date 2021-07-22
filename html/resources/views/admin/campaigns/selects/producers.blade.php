<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Selección de producers</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">


                <div class="row justify-content-md-center">
                    <div class="col-8">
                        <div class="form-group bmd-form-group">
                            <label class="bmd-label-floating">Buscar</label>
                            <input type="text" name="name" id="autocomplete" class="form-control" value="">
                        </div>
                    </div>
                    <div class="col-1">
                        <br>
                        <i class="fas fa-search"></i>
                    </div>

                </div>

                <br>


                <table class="table table-sm producers">
                    <thead class="thead-dark">
                        <tr>
                            <th>Producer</th>
                        </tr>
                    </thead>
                    <tbody class="tbody">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
