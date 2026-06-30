<?php

  require_once "connect.php";

  $obecna_strona = $_GET['action'] ?? "strona-glowna";
  
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ATARI Muzeum</title>
  <link rel="stylesheet" href="./css/style.css" />
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
</head>
<body>
  <header>
    <h2>ATARI Muzeum</h2>
  </header>

  <content>
    <nav>
      <div class="nav-item">
        <a href="?action=strona-glowna">
          <img src="img/docs.png" />
          <h3>Strona glowna</h3>
        </a>
      </div>
      <div class="nav-item">
        <a href="?action=nasze-zbiory">
          <img src="img/floppy.png" />
          <h3>Nasze zbiory</h3>
        </a>
      </div>
      <div class="nav-item">
        <a href="?action=o-nas">
          <img src="img/docs.png" />
          <h3>O nas</h3>
        </a>
      </div>
      <div class="nav-item">
        <a href="?action=wesprzyj-nas">
          <img src="img/docs.png" />
          <h3>Wsparcie</h3>
        </a>
      </div>
      <div class="nav-item">
        <a href="?action=skontaktuj-sie">
          <img src="img/docs.png" />
          <h3>Kontakt</h3>
        </a>
      </div>
    </nav>

    <main>
      <?php if($obecna_strona === "strona-glowna"): ?>
      <header>
        <h1>Aktualnosci</h1>
      </header>
        <?php
          try {
              $stmt = $pdo->query("SELECT * FROM posty ORDER BY data_publikacji DESC");
              $posty = $stmt->fetchAll();
          } catch (PDOException $e) {
              error_log("Blad zapytania: " . $e->getMessage());
              $posty = [];
          }
          foreach ($posty as $wiersz):
        ?>
              <article>
              <h2><?= htmlspecialchars($wiersz['tytul'], ENT_QUOTES, 'UTF-8') ?></h2>
                <p>
                  <?= htmlspecialchars($wiersz['zawartosc'], ENT_QUOTES, 'UTF-8') ?>
                </p>
              <?php if ($wiersz['zdjecie'] !== null && $wiersz['zdjecie'] !== ''): ?>
                <img src="./uploads/<?= htmlspecialchars($wiersz['zdjecie'], ENT_QUOTES, 'UTF-8') ?>" alt=""/>
              <?php endif; ?>
              <p>
                  Autor: <i><?= htmlspecialchars($wiersz['autor'], ENT_QUOTES, 'UTF-8') ?></i> <br/>
                  Data publikacji: <i><?= htmlspecialchars($wiersz['data_publikacji'], ENT_QUOTES, 'UTF-8') ?></i>
                </p>
              </article>
        <?php endforeach; ?>
      <?php elseif($obecna_strona === "nasze-zbiory"): ?>
      <article>
        <h2>A:\Nasze-zbiory</h2>
        <p>
          Dla naszej kolekcji nakreśliliśmy cel w postaci listy produktów
          jakie Atari wydała od początku (wg kodów produktów). Są to
          komputery, konsole, urządzenia peryferyjne jak modemy, drukarki,
          dyski twarde, myszy, monitory.<br /><br />
          To również oprogramowanie jakie wydało Atari, są to cadridge z grami
          na różne platformy konsol, dyskietki z oprogramowaniem na inne
          platformy. Ta lista opiewa na około 734 produkty. Z tego posiadamy
          na ten moment (01.2022) 16% i cały czas ją aktualizujemy.<br /><br />
          W naszej kolekcji znajdują się również takie rzeczy jak prospekty,
          literatura oraz oprogramowanie jakie było wydawane na komputery
          Atari przez inne firmy programistyczne. Software wraz z literaturą
          do nich stanowi całkiem pokaźny zbiór.<br /><br />
          Naszym marzeniem jest poszerzyć zbiory o produkty prototypowe, które
          zostały wyprodukowane w niewielkich, czasami nawet pojedynczych
          ilościach.
        </p>
      </article>

      <?php elseif($obecna_strona === "o-nas"): ?>
      <article>
        <h2>A:\O-nas</h2>
        <p>
          Jestem z pokolenia, które było świadkiem komputeryzacji świata,
          które postępowało w latach 80-tych i 90-tych. Śledzenie nowych
          technologii, dostępnych coraz częściej dla każdego w domu było
          fascynujące. <br /><br />
          Posiadanie komputera w latach 90-tych było niesamowitą frajdą i
          przygodą, dzięki czemu zyskiwało się +20 do koleżeństwa. :)
          <br /><br />
          Mój domowy świat lat 90-tych skomputeryzowała przede wszystkim firma
          ATARI. Pierwszy pod domową strzechę zawitał 1040STfm, mój osobisty
          własny jaki dostałem to 260ST, aby później w wyniku wymian,
          upgrade'u i innej przedsiębiorczości zmienić się w 1040STe z 4MB
          RAM. Później park maszyn poszerzył się o przenośną konsolę Atari
          LYNX oraz drapieżnego JAGUARA.<br /><br />
          Wszystkie te sprzęty mam do dziś, a gdy przypomniałem sobie o ich
          istnieniu 4 lata temu i pokazałem synowi wchodzącemu w świat PS3,
          zobaczyłem w jego oczach podobne emocje do moich z dzieciństwa, gdy
          brat wracał z giełdy komputerowej z paczką nowo nagranych dyskietek
          z grami. <br /><br />Stwierdziłem, że warto udostępnić taką
          możliwość szerszej publiczności. Ku mojemu pozytywnemu zaskoczeniu w
          różnych częściach Polski ludzie z pasją tworzą miejsca o podobnej
          tematyce. Kilka z nich udało się zobaczyć. <br /><br />Dlatego
          planuję otwarcie muzeum w Poznaniu - mieście które nie ma żadnej
          stałej wystawy związanej z pierwszymi komputerami, które znalazły
          się w naszych domach.
        </p>
      </article>

      <?php elseif($obecna_strona === "wesprzyj-nas"): ?>
      <article>
        <h2>A:\Wsparcie</h2>
        <p>
          <b style="color: red">Jak można nas wesprzeć?</b> <br />
          <br />
          Jeśli tak jak my czujesz sentyment do marki Atari i chciałbyś
          wspomóc nas w działaniach stworzenia największej kolekcji produktów
          Atari w Polsce, a może nawet w Europie, możesz to zrobić na kilka
          sposobów. <br />
          <br />
          > Jeśli posiadasz jakieś artefakty z logo Atari - sprzęt, gadgety
          reklamowe, ulotki lub prospekty, katalogi, dyskietki lub kasety z
          grami - prześlij je do nas wraz z historią jak trafiły w Twoje ręce
          lub jakie masz wspomnienia z nimi związane. Zrewanżujemy się
          upominkiem od muzeum. <br />
          <br />
          > Możesz zostać naszym patronem, przekazując co miesiąc kwotę z
          dostępnych progów. W takiej formie wsparcia, możesz śmiało nazwać
          się Współtwórcą naszego Muzeum. Dzięki regularnym, nawet małym
          wpływom, możemy śmielej planować przyszłość. Pamiętaj, że bycie
          Patronem nagradzane jest specjalnymi prezentami (w ograniczonej
          ilości) tylko dla Patronów. <br />
          <br />
          > Możesz również przekazać jednorazową wpłatę na fundację RETURN,
          której zadaniem statutowym jest stworzenie planowanego muzeum.
          <br /><br />
          <b id="patronite-link">Nasz <a href="https://patronite.pl/ATARImuzeum" target="_blank">PATRONITE</a></b>
        </p>
      </article>

      <?php elseif($obecna_strona === "skontaktuj-sie"): ?>
      <article>
        <h2 id="kontakt-title">KONTAKT</h2>
        <h3 style="text-align: center; padding: 10px; font-family: 'Times New Roman', Times, serif;">
          E-mail: kustosz@ATARImuzeum.pl <br /><br />
          Telefon: 572 202 302
        </h3>
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
          <a href="https://www.facebook.com/AtariMuzeum/" target="_blank">Odwiedz Fanpage na Facebook'u!</a>
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
