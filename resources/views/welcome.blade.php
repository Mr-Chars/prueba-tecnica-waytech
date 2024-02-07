<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</head>

<body class="">
    <div class="container">
        <h3>lista de usuarios</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Agregar</button>
        <button type="button" class="btn btn-primary" id="loadDataFromApi">Cargar datos desde api</button>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Nombre de usuario</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Compañia</th>
                    <th scope="col">Calle</th>
                    <th scope="col">Latitud</th>
                    <th scope="col">Logitud</th>
                    <th scope="col">editar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <th scope="row">1</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->company }}</td>
                    <td>{{ $user->street }}</td>
                    <td>{{ $user->lat }}</td>
                    <td>{{ $user->lng }}</td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="removeUser('{{ $user->id }}')">Eliminar</button>
                        <button type="button" class="btn btn-warning" onclick="showUpdateUserModal('{{ $user->id }}')">Actualizar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Guardar usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <input style="display:none" type="text" class="form-control" id="InputId">
                        <div class="mb-3">
                            <label for="InputName" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="InputName">
                        </div>
                        <div class="mb-3">
                            <label for="InputUsername" class="form-label">Nombre de usuario</label>
                            <input type="text" class="form-control" id="InputUsername">
                        </div>
                        <div class="mb-3">
                            <label for="InputEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="InputEmail">
                        </div>
                        <div class="mb-3">
                            <label for="InputPhone" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="InputPhone">
                        </div>
                        <div class="mb-3">
                            <label for="InputCompany" class="form-label">Compañia</label>
                            <input type="text" class="form-control" id="InputCompany">
                        </div>
                        <div class="mb-3">
                            <label for="InputStreet" class="form-label">Calle</label>
                            <input type="text" class="form-control" id="InputStreet">
                        </div>
                        <div class="mb-3">
                            <label for="InputLat" class="form-label">Latitud</label>
                            <input type="text" class="form-control" id="InputLat">
                        </div>
                        <div class="mb-3">
                            <label for="InputLng" class="form-label">Longitud</label>
                            <input type="text" class="form-control" id="InputLng">
                        </div>
                        <button type="button" id="btnAddUser" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js" integrity="sha512-NQfB/bDaB8kaSXF8E77JjhHG5PM6XVRxvHzkZiwl3ddWCEPBa23T76MuWSwAJdMGJnmQqM0VeY9kFszsrBEFrQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script>
        function showUpdateUserModal(idUser) {
            const where = JSON.stringify([
                ['user.id', '=', idUser, ]
            ])

            axios.get('http://localhost/prueba-tecnica-waytech/public/api-user-search?where=' + where)
                .then(function(response) {
                    $("#InputId").val(response.data.users[0].id);
                    $("#InputName").val(response.data.users[0].name);
                    $("#InputUsername").val(response.data.users[0].username);
                    $("#InputEmail").val(response.data.users[0].email);
                    $("#InputPhone").val(response.data.users[0].phone);
                    $("#InputCompany").val(response.data.users[0].company);
                    $("#InputStreet").val(response.data.users[0].street);
                    $("#InputLat").val(response.data.users[0].lat);
                    $("#InputLng").val(response.data.users[0].lng);

                    $('#addUserModal').modal('show');
                })
                .catch(function(error) {
                    // manejar error
                    console.log(error);
                })
                .finally(function() {
                    // siempre sera executado
                });
        }

        function removeUser(idUser) {
            axios.delete('http://localhost/prueba-tecnica-waytech/public/api-user-delete', {
                    data: {
                        id: idUser
                    }
                })
                .then(function(response) {
                    console.log(response.data);
                    if (!response?.data?.status) {
                        showToastCustom("" + response?.data?.error, '#eb4034');
                    } else {
                        showToastCustom("Se ha eliminado con éxito", '#2dc21f');
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }

        $('#addUserModal').on('hidden.bs.modal', function() {
            $("#InputId").val('');
            $("#InputName").val('');
            $("#InputUsername").val('');
            $("#InputEmail").val('');
            $("#InputPhone").val('');
            $("#InputCompany").val('');
            $("#InputStreet").val('');
            $("#InputLat").val('');
            $("#InputLng").val('');
        });

        $("#btnAddUser").click(() => {
            const inputId = $("#InputId").val();
            const inputName = $("#InputName").val();
            const inputUsername = $("#InputUsername").val();
            const inputEmail = $("#InputEmail").val();
            const inputPhone = $("#InputPhone").val();
            const inputCompany = $("#InputCompany").val();
            const inputStreet = $("#InputStreet").val();
            const inputLat = $("#InputLat").val();
            const inputLng = $("#InputLng").val();

            const dataToAdd = {
                id: inputId,
                name: inputName,
                username: inputUsername,
                phone: inputPhone,
                email: inputEmail,
                company: inputCompany,
                street: inputStreet,
                lat: inputLat,
                lng: inputLng,
            };

            if (!inputId) {
                axios.post('http://localhost/prueba-tecnica-waytech/public/api-user-add', dataToAdd)
                    .then(function(response) {
                        console.log(response.data);
                        if (!response?.data?.status) {
                            showToastCustom("" + response?.data?.error, '#eb4034');
                        } else {
                            showToastCustom("Se ha guardado con éxito", '#2dc21f');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            } else {
                axios.put('http://localhost/prueba-tecnica-waytech/public/api-user-update', dataToAdd)
                    .then(function(response) {
                        console.log(response.data);
                        if (!response?.data?.status) {
                            showToastCustom("" + response?.data?.error, '#eb4034');
                        } else {
                            showToastCustom("Se ha guardado con éxito", '#2dc21f');
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
            }

        })

        $("#loadDataFromApi").click(() => {

            axios.get('http://localhost/prueba-tecnica-waytech/public/api-user-search')
                .then(function(response) {
                    console.log(response.data);
                    if (response.data.users.length) {
                        showToastCustom("solo disponible cuando no hay datos en la tabla", '#eb4034');
                    } else {
                        axios.post('http://localhost/prueba-tecnica-waytech/public/api-user-getAndPushDataFromExternalDevice', {})
                            .then(function(response) {
                                console.log(response.data);
                                if (!response?.data?.status) {
                                    showToastCustom("" + response?.data?.error, '#eb4034');
                                } else {
                                    showToastCustom("Se ha cargado los datos con éxito", '#2dc21f');
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    }
                })
                .catch(function(error) {
                    // manejar error
                    console.log(error);
                })
                .finally(function() {
                    // siempre sera executado
                });
        })

        function showToastCustom(message, color) {
            Toastify({
                text: message,
                duration: 4000,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, " + color + ", " + color + ")",
                },
            }).showToast();
        }
    </script>
</body>

</html>