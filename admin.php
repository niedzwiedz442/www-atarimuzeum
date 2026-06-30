<?php
    session_start();

    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel administratora

    </title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <header>
        <h2>ATARI Muzeum</h2>
    </header>

    <content>
        <nav>
            <div class="nav-item">
                <a href="index.php">
                    <img src="img/docs.png" />
                    <h3>Strona główna</h3>
                </a>
                <?php if(!empty($_SESSION['zalogowano'])): ?>
                <a href="logout.php">
                    <h3>Wyloguj się</h3>
                </a>
                <?php endif; ?>
            </div>
        </nav>
        <main>
            <?php if(empty($_SESSION['zalogowano'])): ?>
            <article>
            <h2>Zaloguj się</h2>
            <form action="login.php" method="post">
                <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                Login: <br/> <input type="text" name="login" /> <br/>
                Hasło: <br/> <input type="password" name="haslo" /> <br/> <br/>
                <input type="submit" value="Zaloguj się"/>
            </form>
            </article>
            <?php else: ?>
                <article>
                    <h2>
                        Witaj <?= htmlspecialchars($_SESSION['zalogowany_user']) ?>, udostępnij post:
                    </h2>
                    <form action="upload-post.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                        <label for="tytul">Tytuł:</label>
                        <input type="text" name="tytul" id="tytul" required><br>

                        <label for="tresc">Treść posta:</label>
                        <textarea name="tresc" id="tresc" required></textarea><br>

                        <label for="plik">Zdjecie:</label>
                        <input type="file" name="plik" id="plik">

                        <label for="autor">Autor:</label>
                        <input type="text" name="autor" id="autor" required><br>

                        <label for="data_publikacji">Data publikacji:</label>
                        <input type="date" name="data_publikacji" id="data_publikacji" required><br>

                        <input type="submit" value="Utwórz post">
                    </form>
                </article>
            <?php endif; ?>
        </main>

        <aside>
      <figure>
        <h2>
          Fundacja RETURN <br />
          os. St. Batorego 14i <br />
          60-687 Poznań <br />
          KRS: 0000840072 <br />
        </h2>
      </figure>
      <figure>
          <h2>T: 572 202 302</h2>
      </figure>
      <figure>
        <h2>
          <a href="https://www.facebook.com/AtariMuzeum/" target="_blank">Odwiedź Fanpage na Facebook'u!</a>
        </h2>
      </figure>
    </aside>
    </content>

    <footer>
    <p>
      AtariMuzeum.pl &copy; 2024 - website created by Michał Cholewczyński
    </p>
    </footer>
</body>
</html>