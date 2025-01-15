@extends('layouts.app')

@section('title','Tambah-LJKH')

@section('contents')
<div class="container-fluid">
    <a href="{{route('admin.ljkh')}}" class="d-none d-sm-inline-block btn btn-primary shadow-sm float-right" 
        style="margin-top: 15px"><i class="fas fa-arrow-left fa-sm text-white-50"></i>  BACK
    </a>
    <h1 class="mb-0 mt-4">Add Job</h1>
    <hr style="border-top-color:gray">

    <form action="{{ route('admin.storeLJKH') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row mb-2">
            <div class="col">
                <span style="color:red;">*</span>PROJEK</label>
                <input type="text" class="form-control" name="project" id="project" placeholder="Nama Projek">
            </div>
            <div class="col">
                <span style="color:red;">*</span>ID JOB/Anumber</label>
                <input type="text" name="id_job" id="id_job" class="form-control"
                placeholder="Masukan A Number" onkeyup="checkAndFixInput()">
                @error('id_job')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <span style="color:red;">*</span>ID MACHINING</label>
                <select class="form-control" name="id_mch" id="id_mch">
                    <option selected disabled>Select ID Machining</option>
                    @foreach($idMchs as $idMch)
                        <option value="{{ $idMch }}">{{ $idMch }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <span style="color:red;">*</span>TASK NAME</label>
                <select class="form-control" name="activity_name" id="task_name">
                    <option selected disabled>Select Your Task</option>
                    @foreach($taskNames as $Tn)
                        <option value="{{ $Tn }}">{{ $Tn }}</option>
                        @endforeach
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <span style="color: red">*</span>WORK CENTER</label>
                <select name="work_ctr" id="work_ctr" class="form-control">
                    <option selected disabled>Select Work Center</option>
                    <option value="ENDCADCAM">ENDCADCAM</option>
                    <option value="MCH-SML">MCH-SML</option>
                    <option value="MCH-MED">MCH-MED</option>
                    <option value="MCH-BIG">MCH-BIG</option>
                    <option value="PATTERN">PATTERN</option>
                </select>
            </div>
            <div class="col">   
                <span style="color:red;">*</span>die_part</label>
                <select class="form-control" name="die_part" id="die_part">
                    <option selected disabled>Select Die Part</option>
                    <option value="70">Upper</option>
                    <option value="71">Lower</option>
                    <option value="72">Pad</option>
                </select>
            </div>
        </div>
        
        <button type="submit" class="btn btn-block btn-primary">Submit</button>
    </form>
</div>

<script>
    function checkAndFixInput() {
        var input = document.getElementById('id_job');
        var value = input.value;
        
        // Pastikan nilai dimulai dengan "A", jika tidak, tambahkan "A" di awal
        if (value.length === 0 || value.charAt(0) !== 'A') {
            input.value = 'A' + value;
        }
    }

    document.getElementById('id_job').addEventListener('blur', function() {
    var idJobInput = this.value;
    if (idJobInput.length !== 7 || !idJobInput.startsWith('A')) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'ID JOB harus memiliki panjang 7 karakter!',
            });
        }
    });

</script>
@endsection