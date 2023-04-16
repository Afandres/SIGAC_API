@extends('sica::layouts.master')

@section('stylesheet')
@endsection

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                {{-- Aqui inicia la tabla de Categorías --}}
                <div class="col-md-6">
                    <div class="card card-orange card-outline shadow">
                        <div class="card-header">
                            <h3 class="card-title">Categorías</h3>
                        </div>
                        <div class="card-body">
                            <div>
                                <table id="example2" class="display table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre</th>
                                            <th>Tipo de propiedad</th>
                                            <th>
                                                <a href="" class="text-success" data-toggle='tooltip'
                                                    data-placement="top" title="Agregar">
                                                    <i class="fas fa-plus-circle"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $c)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $c->name }}</td>
                                                <td>{{ $c->kind_of_property }}</td>
                                                <td>
                                                    <div class="opts">
                                                        <a href="#" data-toggle='tooltip' data-placement="top" title="Ver">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="#" data-toggle='tooltip' data-placement="top" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a class="btn-delete" href="#" data-action="delete" data-toggle='tooltip' data-placement="top" data-object="#" data-path="admin/role" title="Eliminar">
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
                    </div>
                </div>
                {{-- Aqui finaliza la tabla categorías --}}
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
        @if (Session::get('message_config'))
            $('html, body').animate({
                /* Move the page to the previously selected configuration */
                scrollTop: $("#{{ Session::get('card') }}").offset().top
            }, 1000);
            /* Show the message */
            @if (Session::get('icon') == 'success')
                toastr.success("{{ Session::get('message_config') }}");
            @elseif (Session::get('icon') == 'error')
                toastr.error("{{ Session::get('message_config') }}");
            @endif
        @endif

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
            $('table.display').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        function ajaxAction(route) {
            /* Ajax to show content modal to add event */
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

        $("#generalModal").on("hidden.bs.modal", function() {
            /* Modal content is removed when the modal is closed */
            $("#modal-content").empty();
        });

        function mayus(e) {
            /* Convert the content of a field to uppercase */
            e.value = e.value.toUpperCase();
        }
    </script>
@endsection
