<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekawan Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
</head>

<body>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="true">Table Data From API</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false">Add data to Database</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="card">
                <div class="card-header">Table Data From API</div>
                <div class="card-body">
                    <div class="container mt-2">
                        <button id="myInput" class="btn btn-primary my-3">Refresh</button>
                        <table class="display" id="table_id">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID Peg</th>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    <th>Age</th>
                                    <th>Photo</th>
                                </tr>
                            </thead>
                            <tbody id="showData">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <div class="card">
                <div class="card-header">Add data to Database</div>
                <div class="card-body">
                    <div class="container md-2">
                        <form method="POST" action="/employee/insert" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" class="form-control" name="employee_name">
                            </div>
                            <div class="form-group">
                                <label>Employee Salary</label>
                                <input type="number" class="form-control" name="employee_salary">
                            </div>
                            <div class="form-group">
                                <label>Employee Age</label>
                                <input type="number" class="form-control" name="employee_age">
                            </div>
                            <div class="form-group">
                                <label>Employee Profile Picture</label>
                                <input type="file" class="form-control" name="profile_picture">
                            </div>
                            <button type="submit" class="btn btn-success upload-image my-3">Save</button>
                        </form>
                    </div>
                    <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>ID Peg</th>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    <th>Age</th>
                                    <th>Photo</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                             $no = 1;
                             foreach($data as $employee) { 
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $employee['id']; ?></td>
                                    <td><?= $employee['employee_name']; ?></td>
                                    <td><?= $employee['employee_salary']; ?></td>
                                    <td><?= $employee['employee_age']; ?></td>
                                    <td><img src="/images/<?= $employee['profile_picture']; ?>" width="80px" alt=""></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
            integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"
            integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous">
        </script>
        <script>
        $(document).ready(function() {
            $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                alert('cannot refresh data. please check your connection')
                console.log(message);
            };;
            var t = $('#table_id').DataTable({
                ajax: {
                    url: "/api",
                    dataSrc: "data"
                },
                columns: [{
                        data: null
                    }, {
                        data: 'id'
                    },
                    {
                        data: 'employee_name'
                    },
                    {
                        data: 'employee_salary'
                    },
                    {
                        data: 'employee_age'
                    },
                    {
                        data: 'profile_image'
                    },
                ],
                columnDefs: [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                order: [
                    [4, "asc"]
                ],
            });
            $('#myInput').click(function() {
                t.ajax.url('/api').load()
            })
            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
        </script>
        <script src="http://malsup.github.com/jquery.form.js"></script>
        <script type="text/javascript">
        $("body").on("click", ".upload-image", function(e) {
            $(this).parents("form").ajaxForm(options);
        });

        var options = {
            complete: function(response) {
								console.log(response)
                if ($.isEmptyObject(response.responseJSON.error)) {
                    $("input[name='employee_name']").val('');
                    $("input[name='employee_salary']").val('');
                    $("input[name='employee_age']").val('');
                    alert('Upload gambar berhasil.');
                } else {
                    printErrorMsg(response.responseJSON.error);
                }
            }
        };

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }
        </script>


</body>


</html>