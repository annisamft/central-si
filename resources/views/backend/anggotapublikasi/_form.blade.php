<input type="hidden" name="publikasi_id" value="{{ $id }}">

<div class="form-group">
    <label for="dosen_id">Nama</label>
    {{ Form::select('dosen_id', $dosens, null,['class'=> 'form-control', 'nama' => 'nama', 'placeholder' => 'Dosen']) }}
</div>

<div class="form-group">
    <label for="posisi">Posisi</label>
<<<<<<< HEAD
    {{Form::select('posisi', [1=> 'Ketua', 2=> 'Anggota'], null, ['class' => 'form-control']) }}
=======
    {{ Form::text('posisi', null, ['class' => 'form-control', 'id' => 'posisi', 'placeholder' => 'posisi']) }}
>>>>>>> master
</div>

