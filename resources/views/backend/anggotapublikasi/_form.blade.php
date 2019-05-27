<input type="hidden" name="publikasi_id" value="{{ $id }}">

<div class="form-group">
    <label for="dosen_id">Nama</label>
    {{ Form::select('dosen_id', $dosens, null,['class'=> 'form-control', 'nama' => 'nama', 'placeholder' => 'Dosen']) }}
</div>


