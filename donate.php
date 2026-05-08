<?php
require_once 'include/config.php';
require_once 'include/functions.php';
require_once 'include/header.php';
?>

<nav aria-label="breadcrumb">
  <ol class="breadcrumb bg-white px-0">
    <li class="breadcrumb-item"><a href="index.php">Головна</a></li>
    <li class="breadcrumb-item active" aria-current="page">Допомога притулку</li>
  </ol>
</nav>

<div class="text-center mb-5">
    <h2 class="font-weight-bold">❤️ Допомога хвостикам</h2>
    <p class="lead">Кожна ваша гривня допомагає нам рятувати життя.</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-warning h-100" style="border-radius: 15px;">
            <div class="card-body text-center p-4">
                <h4 class="font-weight-bold">Банківські реквізити</h4>
                <hr>
                <p class="mb-1 text-muted small">Номер карти (Monobank):</p>
                <h5 class="font-weight-bold" style="letter-spacing: 1px;">4441 1111 2222 3333</h5>
                <div class="mt-4 p-3 bg-light rounded text-left small text-muted">
                    <p class="mb-1"><strong>Одержувач:</strong> БФ "Щасливий хвостик"</p>
                    <p class="mb-0"><strong>ЄДРПОУ:</strong> 12345678</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-success text-center h-100" style="border-radius: 15px;">
            <div class="card-body p-4">
                <h4 class="font-weight-bold">QR-код на донат</h4>
                <hr>
                <div class="bg-white p-2 rounded d-inline-block border shadow-sm" data-toggle="modal" data-target="#qrModal" style="cursor: pointer;">
                    <img src="img/qr-code.jpg" alt="QR Code" style="width: 250px; height: 250px; object-fit: contain;">
                </div>
                <p class="mt-3 text-muted small">Натисніть на код, щоб збільшити</p>
            </div>
        </div>
    </div>
</div>

<!-- Модальне вікно -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content" style="border-radius: 10px;">
      <div class="modal-header border-0 p-1 pr-3">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center py-0 px-4">
        <img src="img/qr-code.jpg" alt="QR Code Large" class="img-fluid" style="max-width: 80%;">
        <p class="mt-2 mb-2 font-weight-bold">Відскануйте для допомоги</p>
      </div>
      <div class="modal-footer border-0 p-2 justify-content-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрити</button>
      </div>
    </div>
  </div>
</div>

<?php require_once 'include/footer.php'; ?>
