<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dziennik Admina:</h1>
                    <div class="info">
                    </div>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <?php
    session_start();
    if (!isset($_SESSION["logged"]) || $_SESSION["logged"]["session_id"] != session_id() || session_status() != 2) {
        $_SESSION["error"] = "Zaloguj się!";
        header("location: ./");
    } else {
        switch ($_SESSION["logged"]["role_id"]) {
            case 1:
                $role = "logged_uczen";
                break;
            case 2:
                $role = "logged_nauczyciel";
                break;
            case 3:
                $role = "logged_admin";
                break;
        }
    }


    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AdminLTE 3 | Dashboard 2</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="../../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">

    </head>
    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content1-center align-items-center">
            <img class="animation__wobble" src="../../../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="128" width="128">
        </div>

        <!-- Navbar -->
        <?php
        require_once __DIR__ . "/navbar.php";
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        require_once __DIR__ . "/../$role/aside_admin.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Info boxes -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">


                                    </div>

                                    <!-- /.card-header -->
                                    <table class="card-body">

                                        <form method="post" action="">
                                            <div class="form-group">


                                            </div>

                                        </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>

        <!doctype html>
        <html lang="pl">
        <head>

            <meta charset="UTF-8">
            <meta name="viewport"
                  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <link rel="stylesheet" href="../../../css/table.css">
            <title>Uczniowie</title>
        </head>
        <body>
        <h4>Podgląd Uczniów</h4>
        <?php
        if (isset($_GET["userIdDelete"])) {
            if ($_GET["userIdDelete"] == 0) {
                echo "<h4>Nie usunięto użytkownika!</h4>";
            } else {
                echo "<h4>Usunięto użytkownika o id={$_GET['userIdDelete']}</h4>";
            }
        }
        if (isset($_SESSION["error"])) {
            echo "<h4>{$_SESSION['error']}</h4>";
            unset($_SESSION["error"]);
        }
        ?>
        <?php
        require_once "../../../scripts/connect.php";

        $sql = "SELECT u.id, u.firstName, u.lastName, u.email, r.role AS role\n"
            . "FROM users u\n"
            . "JOIN roles r ON u.role_id = r.id\n"
            . "WHERE u.role_id = 1;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>Imię</th>";
            echo "<th>Nazwisko</th>";
            echo "<th>Rola</th>";
            echo "<th>Email</th>";
            echo "<th>Akcje</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['firstName'] . "</td>";
                echo "<td>" . $row['lastName'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td><button class='delete-button' data-user-id='" . $row['id'] . "'>Usuń</button></td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Brak rekordów do wyświetlenia";
        }
        ?>

        </table>
        <?php if (isset($_GET["addUser"])) : ?>
            <h4>Dodawanie użytkownika</h4>
            <form action="../../../scripts/add_user.php" method="post">
                <input type="text" name="imie" placeholder="Podaj imię" autofocus><br><br>
                <input type="text" name="nazwisko" placeholder="Podaj nazwisko"><br><br>
                <input type="password" name="haslo" placeholder="Podaj hasło"><br><br>
                <input type="email" name="email" placeholder="Podaj adres e-mail"><br><br>
                <input type="submit" value="Wyślij">
            </form>
        <?php endif; ?>
        <a href="./uczniowie.php?addUser=1">Dodaj użytkownika</a>


        <script>
            function goBack() {
                history.back();
            }
            // Obsługa zdarzenia kliknięcia przycisku "Usuń"
            const deleteButtons = document.querySelectorAll(".delete-button");
            deleteButtons.forEach(button => {
                button.addEventListener("click", (event) => {
                    event.preventDefault();
                    const userId = event.target.dataset.userId;
                    deleteUser(userId);
                });
            });
            // Funkcja do usuwania użytkownika
            function deleteUser(userId) {
                if (confirm("Czy na pewno chcesz usunąć tego użytkownika?")) {
                    window.location.href = `../../../scripts/delete_user.php?userIdDelete=${userId}`;
                }
            }





            // Funkcja do otwierania formularza edycji użytkownika
            function openEditUserForm(userId) {
                window.location.href = `../pages/logged.php?userIdUpdate=${userId}`;
            }


        </script>
        </body>
        </html>

    </div>
</div>




</body>
</html>

<?php
require_once "../footer.php";
?>

</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.js"></script>

<!-- Ajax script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('.btn-details').click(function () {
            var userId = $(this).data('userId');

            // Wykonaj żądanie AJAX, aby pobrać szczegółowe informacje o użytkowniku
            $.ajax({
                url: 'pojedynczy.php',
                method: 'GET',
                data: {
                    userId: userId
                },
                success: function (response) {
                    // Wyświetl pobrane szczegółowe informacje o użytkowniku
                    $('#user-details').html(response);
                },
                error: function () {
                    // Wyświetl komunikat błędu, jeśli wystąpił problem z pobraniem danych
                    $('#user-details').html('Wystąpił błąd podczas pobierania informacji o użytkowniku.');
                }
            });
        });
    });
</script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../../../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../../../plugins/raphael/raphael.min.js"></script>
<script src="../../../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../../../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../../../plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../../dist/js/pages/dashboard2.js"></script>
</div>
</div>
</div>
</section>
</div>
</section>
</div>


</body>
</html>



<!-- /.content-wrapper -->

<!-- Main Footer -->


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.js"></script>

<!-- Ajax script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../../../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../../../plugins/raphael/raphael.min.js"></script>
<script src="../../../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../../../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../../../plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../../../dist/js/pages/dashboard2.js"></script>
</body>
</html>