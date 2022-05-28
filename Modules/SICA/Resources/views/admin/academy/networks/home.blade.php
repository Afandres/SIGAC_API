@extends('sica::layouts.master')

@section('stylesheet')
@endsection

@section('content')
    <div class="content">
      <div class="container-fluid">
    <div class="d-flex justify-content-center">
      <div class="card card-orange card-outline shadow col-md-12">
        <div class="card-header">
              <h3 class="card-title">Networks</h3>
        </div>
              <!-- /.card-header -->
        <div class="card-body">
            <div class="btns">
            <a href="" class="btn btn-primary "><i class="fas fa-user-plus"></i> Agregar Red</a>
            <a href="{{ route('sica.admin.academy.curriculums') }}" class="btn btn-info float-right ml-1"> Programas >></a>
            <a href="{{ route('sica.admin.academy.lines') }}" class="btn btn-info float-right ml-1"> << Lineas</a>    

        </div>
        <div class="mtop16">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Linea</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($networks as $n)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $n->name }}</td>
                    <td>{{ $n->line->name }}</td>
                    <td>
                    <div class="opts">
                      <a href="{{ url('admin/re/edit/'.$n->id) }}" data-toggle='tooltip' data-placement="top" title="Ver"><i class="fas fa-eye"></i></a>
                      <a href="{{ url('admin/re/edit/'.$n->id) }}" data-toggle='tooltip' data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                      <a class="btn-delete" href="#" data-action="delete" data-toggle='tooltip' data-placement="top" data-object="{{ $n->id }}" data-path="admin/role" title="Eliminar"><i class="fas fa-trash-alt"></i></a>
                    </div>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>

                </table>
            </div>
              </div>
              <!-- /.card-body -->
      </div>

        </div>
    </div>
</div>
@endsection
@section('script')
      <script>
        $(function () {
          $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
          });
          $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
      </script>
@endsection    
    