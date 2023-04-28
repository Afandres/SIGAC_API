@extends('sica::layouts.master')

@section('stylesheet')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-center">
                <div class="card card-orange card-outline shadow col-md-12">
                    <div class="card-header">
                        <h3 class="card-title">Redes de Conocimiento</h3>
                        <div class="btns">
                            <a href="{{ route('sica.admin.academy.curriculums') }}" class="btn btn-info float-right ml-1">
                                Programas <i class="fa-solid fa-angles-right fa-beat-fade"></i></a>
                            <a href="{{ route('sica.admin.academy.lines') }}" class="btn btn-info float-right ml-1"><i
                                    class="fa-solid fa-angles-left fa-beat-fade"></i> Líneas Tecnológicas </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="">
                            <table id="tableNetworks" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Redes de Conocimiento</th>
                                        <th>Línea Tecnológica</th>
                                        <th>Acciones
                                            <a class="mx-3" data-toggle="modal" data-target="#generalModal" onclick="ajaxAction('{{ route('sica.admin.academy.network.create') }}')">
                                                <b class="text-success" data-toggle="tooltip" data-placement="top" title="Agregar">
                                                    <i class="fas fa-plus-circle"></i>
                                                </b>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($networks as $n)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $n->name }}</td>
                                            <td>{{ $n->line->name }}</td>
                                            <td>
                                                <div class="opts">
                                                    <a href="{{ url('admin/re/edit/' . $n->id) }}" class="text-warning" data-toggle='tooltip' data-placement="top" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ url('admin/re/edit/' . $n->id) }}" class="text-info" data-toggle='tooltip' data-placement="top" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a class="text-danger btn-delete" href="#" data-action="delete" data-toggle='tooltip' data-placement="top" data-object="{{ $n->id }}" data-path="admin/role" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
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
    <!-- General modal -->
    <div class="modal fade" id="generalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered" role="document">
            <div class="modal-content" id="modal-content"></div>
        </div>
    </div>
    <div id="loader" style="display: none;"> {{-- Loader modal --}}
        <div class="modal-body text-center" id="modal-loader">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div><br>
            <b id="loader-message"></b>
        </div>
    </div>
@endsection
@section('script')
    <script>
        @if (Session::get('message_network'))
            /* Show the message */
            @if (Session::get('icon') == 'success')
                toastr.success("{{ Session::get('message_network') }}");
            @elseif (Session::get('icon') == 'error')
                toastr.error("{{ Session::get('message_network') }}");
            @endif
        @endif

        function ajaxAction(route) {
            /* Ajax to show content modal to add line */
            $('#loader-message').text('Cargando contenido...'); /* Add content to loader */
            $('#modal-content').append($('#modal-loader').clone()); /* Add the loader to the modal */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKE': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                    method: "get",
                    url: route,
                    data: {}
                })
                .done(function(html) {
                    $("#modal-content").html(html);
                });
        }

        // Vaciar el contenido del modal cuando sea cerrado
        $("#generalModal").on("hidden.bs.modal", function() {
            $("#modal-content").empty();
        });
    </script>
    <script>
        $(document).ready(function() {
            /* Initialización of Datatables Lines */
            $('#tableNetworks').DataTable({
                // opciones de configuración para la tabla 1
            });
        });
    </script>
@endsection
