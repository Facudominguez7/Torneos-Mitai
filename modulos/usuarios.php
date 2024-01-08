<section>
    <?php
    $sqlMostrarEmail = "SELECT email FROM usuarios";
    $consultaEmails = mysqli_prepare($con, $sqlMostrarEmail);
    mysqli_stmt_execute($consultaEmails);
    $resultEmails = mysqli_stmt_get_result($consultaEmails);

    if ($resultEmails->num_rows > 0) {
        while ($row = $resultEmails->fetch_assoc()) {
            $emails[] = $row["email"];
        }
    } else {
        echo "0 resultados";
    }

    // Formatear los valores del campo email separados por comas
    $emailsSeparated = implode(', ', $emails);
    ?>
    <h1 class="text-3xl font-bold tracking-tight flex justify-center text-white mt-5">
        Emails de los Usuarios.
    </h1>
    <div class="flex justify-center mt-5 items-center">
        <textarea rows="20" cols="60"><?php echo htmlspecialchars($emailsSeparated); ?></textarea>
    </div>
</section>