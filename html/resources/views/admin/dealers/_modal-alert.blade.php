<div class="modal fade" id="warningText" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Alertas
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 align='center'>Alerta <br><span></span></h5>
                <br>
                <br>

                <div class="row justify-content-md-center">
                    <div class="col-lg-8">
                        <form action="{{ route('dealers.setAlert') }}" method="POST" id="formAlerta">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label class="bmd-label-floating">Alerta</label>
                                        <input type="text" name="warning" class="form-control alertaText">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" class="dealer_id" value="" name="dealer_id">

                            <div class="row justify-content-center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
