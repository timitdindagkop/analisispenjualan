<div id="modalcicilan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title">Pembayaran cicilan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_cicilan">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="jumlah_uang" class="control-label">Nominal</label>
                                <input type="text" class="form-control" id="jumlah_uang" name="jumlah_uang" placeholder="Masukan nominal pembayaran">
                                <input type="hidden" name="penjualanbarang_id" id="penjualanbarang_id" value="{{ $data->id }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Bayar Cicilan</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->